<?php
namespace Admin\Controller;
use Common\Controller\CommonController;

class BaseController extends CommonController{
    public function _initialize() {
        parent::_initialize();
        $this->checkAuth();
        $this->checkLanuage();
        $this->navigation();
        $admin_info = get_admin_info();
        $this->bread();
        $this->admin_info = $admin_info;
    }
    private function checkAuth(){
        empty(session('?admin_info'))?$this->redirect('Public/logout'):null;
        if(C('USER_AUTH_ON')){
            if(session('admin_info.id') != 1){
                $url = CONTROLLER_NAME."/".ACTION_NAME;
                $admin_id = get_admin_id();
                $where['rule'] = array('eq',$url);
                $rule_id = M('rule')->where($where)->getField('id');
                $group_id = M('admin')->where('id ='.$admin_id)->getField('group_id');
                $wheres['id'] = array('eq',$group_id);
                $access = M('group')->where($wheres)->getField('access');
                $access = unserialize($access);
                if(!in_array($rule_id,$access) && !in_array($url,C('NOT_ACTION'))){
                    $this->error('没有权限');die;
                }
            }
        }
    }
    /*后台导航*/
    private function navigation(){
        $admin_id = get_admin_id();
        $where['is_show'] = array('eq',1);
        if($admin_id == 1){
            $nav = M('Navigation')->where($where)->field(true)->select();
        }else{
            $group_id = M('admin')->where('id ='.$admin_id)->getField('group_id');
            $access = M('group')->where('id ='.$group_id)->getField('access');
            $access = unserialize($access);
            $rule_list = M('rule')->field('id,rule')->select();
            foreach ($rule_list as $k => $v){
                if(in_array($v['id'],$access)){
                    $rule_lists[] = $v['rule'];
                }
            }
            $navs = M('Navigation')->where($where)->field(true)->select();
            $nav_top = M('Navigation')->where('is_show = 1 and pid = 0')->field(true)->select();
            foreach ($navs as $key => $value){
                if(in_array($value['url'],$rule_lists)){
                    $nav[] = $navs[$key];
                    $nav_pid[] = $navs[$key]['pid'];
                }
            }
            $nav_pid = array_unique($nav_pid);
            foreach ($nav_top as $kk =>$vv){
                if(in_array($vv['id'],$nav_pid)){
                    $nav_tops[] = $nav_top[$kk];
                }
            }
            $nav = array_merge($nav,$nav_tops);
        }
        $nav = list_to_tree($nav);
        $this->nav = $nav;
    }
    /*后台面包屑*/
    private function bread(){
        $where['is_show'] = array('eq',1);
        $where['pid'] = array('neq',0);
        $nav = M('Navigation')->where($where)->field(true)->select();
        foreach ($nav as $k => $v){
            $now_controller = CONTROLLER_NAME.'/index';
            $now_action = CONTROLLER_NAME.'/'.ACTION_NAME;
            if($now_controller === $v['url']){
                $bread['controller_name'] = $v['name'];
                $bread['controller_url'] = U($v['url']);
            }
            if(ACTION_NAME !== 'index'){
                if($now_action === $v['url']){
                    $bread['action_name'] = $v['name'];
                }
            }
        }
        $this->bread = $bread;
    }

    /*当前语言*/
    private function checkLanuage(){
        $now_lanuage = C('DB_PREFIX');
        $this->now_lanuage = $now_lanuage;
    }

    /*后台语言切换*/
    public function switch_language(){
        if(IS_AJAX){
            $for_language = I('get.for_language','');
            empty($for_language) ? $this->error('参数错误') : null;
            if($for_language == 'english'){
                $old_db_prefix = 'zh_';
                $db_prefix = 'en_';
            }elseif ($for_language == '中文'){
                $old_db_prefix = 'en_';
                $db_prefix = 'zh_';
            }
            change_file_content(APP_PATH.'Admin/Conf/mysql.php',$old_db_prefix,$db_prefix);
            $this->ajaxReturn();
        }
    }
}