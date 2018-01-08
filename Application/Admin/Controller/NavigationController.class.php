<?php
/**
 * 后台导航控制器
 * ###index>>后台导航列表###
 * @@@create>>添加后台导航@@@
 * @@@editor>>修改后台导航@@@
 * @@@remove>>删除后台导航@@@
 * @@@list_form>>批量保存@@@
 * @@@change_status>>改变状态@@@
 */
namespace Admin\Controller;
class NavigationController extends BaseController{
    public function index(){
        $navigationModel = M('Navigation');
        $pid = I('get.pid','',intval);
        empty($pid)?$top_id = 0:$top_id = $pid;
        $where['pid'] = array('eq',$top_id);
        $navigation_list = $navigationModel->where($where)->order('sort')->field(true)->select();
        foreach ($navigation_list as $k => $v){
            $navigation_list[$k]['pid_name'] =  $navigationModel->where('id ='.$v['pid'])->getField('name');
        }
        /*记录当前列表页的cookie*/
        cookie('__forward__',$_SERVER['REQUEST_URI']);
        $this->navigation_list = $navigation_list;
        $this->display();
    }

    public function create(){
        $navigationModel = D('Navigation');
        if(IS_POST){
            if(false === $navigationModel->create($_POST)){
                $this->error($navigationModel->getError());
            }
            if(false !== $navigationModel->add()){
                $this->success('添加成功',cookie('__forward__'));
            }else{
                $this->error('添加失败');
            }
        }else{
            $pid = I('get.pid','',intval);
            $this->this_pid = $pid;
            $where['is_show'] = array('eq',1);
            $where['pid'] = array('eq',0);
            $navigation_list = $navigationModel->where($where)->field(true)->select();
            $navigation_list = array_merge(array(0=>array('id'=>0,'name'=>'顶级导航')), $navigation_list);
            $this->navigation_list = $navigation_list;
            $this->display();
        }
    }

    public function editor(){
        $navigationModel = D('Navigation');
        if(IS_POST){
            if(false === $navigationModel->create($_POST)){
                $this->error($navigationModel->getError());
            }
            if(false !== $navigationModel->save()){
                $this->success('修改成功',cookie('__forward__'));
            }else{
                $this->error('修改失败');
            }
        }else{
            $id = I('get.id','',intval);
            if(!empty($id)){
                $map['id'] = array('eq',$id);
                $navigation_info = $navigationModel->where($map)->field(true)->find();
            }

            $where['is_show'] = array('eq',1);
            $where['pid'] = array('eq',0);
            $navigation_list = $navigationModel->where($where)->field(true)->select();
            $navigation_list = array_merge(array(0=>array('id'=>0,'name'=>'顶级导航')), $navigation_list);

            $this->navigation_info = $navigation_info;
            $this->navigation_list = $navigation_list;
            $this->display();
        }
    }

    public function remove(){
        $id = I('get.id','',intval);
        empty($id) ? $this->error('参数错误') : null;
        $where['id'] = array('eq',$id);
        if(false !== M('navigation')->where($where)->delete()){
            $this->success('删除成功',cookie('__forward__'));
        }else{
            $this->error('删除失败');
        }
    }

    public function list_form(){
        $navigationModel = M('Navigation');
        if (!is_array($_POST['sort'])) {
            $this->error('没有任何数据');
        }
        foreach ($_POST['sort'] as $k => $v) {
            $reg = "/^[0-9]*$/";
            if (!preg_match($reg, $v)) {
                $this->error('只能是数字');
            }
            if ($v == '') {
                $this->error('排序不能为空');
            } else {
                $navigationModel->where('id=' . $k)->setField('sort', $v);
            }
        }
        $this->success('保存成功',cookie('__forward__'));
    }

    public function change_status(){
        $navigationModel = M('Navigation');
        if(IS_AJAX){
            $type = I('get.type','');
            $data['id'] = I('get.id','');
            $data["$type"] = abs(I("get.$type",'')-1);
            if(false !== $navigationModel->save($data)){
                $this->success('修改成功',cookie('__forward__'));
            }else{
                $this->error('修改失败');
            }
        }
    }
}