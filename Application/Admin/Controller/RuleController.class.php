<?php
/**
 * 权限规则控制器
 * ###index>>权限规则列表###
 * @@@remove>>删除权限规则@@@
 * @@@get_all_rule>>更新权限规则@@@
 */
namespace Admin\Controller;
class RuleController extends BaseController{
    public function index(){
        $rumeModel = M('rule');
        $rule_list = $rumeModel->select();
        $rule_list = \Library\Tree::list_to_tree($rule_list);
        $this->assign('rule_list',$rule_list);
        $this->display();
    }

    public function remove(){
        $id = I('get.id','',intval);
        empty($id) ? $this->error('参数错误') : null;
        $have_son = M('rule')->where('pid = '.$id)->find();
        if($have_son){
            $this->error('含有子类，无法删除');
        }
        if(false !== M('rule')->where('id ='.$id)->delete()){
            $this->success('删除成功');
        }else{
            $this->error('删除失败');
        }
    }

    public function get_all_rule(){
        $file_path = glob(dirname(__FILE__).'/*.class.php');
        $ruleModel = M('rule');
        $i = 1;
        foreach ($file_path as $value){
            $file_content = file_get_contents($value);
            $is_find_rule = preg_match(getRuleStr(1), $file_content, $rule_info);
            $controller_name = basename(substr($value,0,-20));
            if($is_find_rule){
                $rule_info = explode('>>',trim($rule_info[1]));
            }
            $controller_data['name'] = trim($rule_info[1]);
            $controller_data['rule'] = $controller_name.'/'.trim($rule_info[0]);
            $controller_data['pid'] = 0;
            $controller_data['level'] = 1;
            $controller_data['sort'] = $i;
            $where['rule'] = array('eq',$controller_data['rule']);

            $old_id = $ruleModel->where($where)->field('id')->find();
            if(!empty($controller_data['name'])){
                if($old_id){
                    $map['id'] = array('eq',$old_id['id']);
                    $ruleModel->where($map)->save($controller_data);
                }else{
                    $ruleModel->add($controller_data);
                }
                $i++;
            }

            $is_find_action_rule = preg_match_all(getRuleStr(2), $file_content, $action_rule_info);
            $k = 1;
            if($is_find_action_rule){
                foreach ($action_rule_info[1] as $values){
                    $action_rule_info = explode('>>',trim($values));
                    $prevInfo = $ruleModel->where($where)->field('id')->find();

                    $action_data['name'] = trim($action_rule_info[1]);
                    $action_data['rule'] = $controller_name.'/'.trim($action_rule_info[0]);
                    $action_data['sort'] = $k;
                    $action_data['pid'] = $prevInfo['id'];
                    $action_data['level'] = 2;

                    $maps['rule'] = array('eq',$action_data['rule']);
                    $oldId = $ruleModel->where($maps)->field('id')->find();
                    if($oldId){
                        $mapss['id'] = array('eq',$oldId['id']);
                        $ruleModel->where($mapss)->save($action_data);
                    }else{
                        $ruleModel->add($action_data);
                    }
                    $k++;
                }
            }
        }
        $this->success('更新完成');
    }
}