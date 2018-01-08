<?php
/**
 * 管理人员控制器
 * ###index>>管理人员列表###
 * @@@create>>添加管理人员@@@
 * @@@editor>>修改管理人员@@@
 * @@@remove>>删除管理人员@@@
 * @@@change_status>>改变状态@@@
 */
namespace Admin\Controller;
class AdminController extends BaseController{
    public function index(){
        $groupModel = M('group');
        $adminModel = M('admin');
        $admin_list = $adminModel->field(true)->select();
        foreach ($admin_list as $k => $v){
            $where['id'] = array('eq',$v['group_id']);
            $admin_list[$k]['group_name'] = $groupModel->where($where)->getField('name');
        }
        $this->admin_list = $admin_list;
        cookie('__forward__',$_SERVER['REQUEST_URI']);
        $this->display();
    }
    public function create(){
        $adminModel = D('admin');
        $groupModel = M('group');
        if(IS_POST){
            if(false === $adminModel->create($_POST)){
                $this->error($adminModel->getError());
            }
            if(false !== $adminModel->add()){
                $this->success('添加成功',cookie('__forward__'));
            }else{
                $this->error('添加失败');
            }
        }else{
            $where['status'] = array('eq',1);
            $group_list = $groupModel->where($where)->field('id,name')->select();
            $this->group_list = $group_list;
            $this->display();
        }
    }

    public function editor(){
        $adminModel = D('ChangeInfo');
        $groupModel = M('group');
        if(IS_POST){
            if(false === $adminModel->create($_POST)){
                $this->error($adminModel->getError());
            }
            if(false !== $adminModel->save()){
                $this->success('修改成功',cookie('__forward__'));
            }else{
                $this->error('修改失败');
            }
        }else{
            $id = I('get.id','',intval);
            $where['id'] = array('eq',$id);
            $admin_information = M('admin')->where($where)->field('password',true)->find();
            $this->admin_information = $admin_information;

            $wheres['status'] = array('eq',1);
            $group_list = $groupModel->where($wheres)->field('id,name')->select();
            $this->group_list = $group_list;
            $this->display();
        }
    }

    public function remove(){
        $adminModel = M('admin');
        $id = I('get.id',0,intval);
        empty($id) ? $this->error('参数错误') : null;
        if($id == 1){
            $this->error('超级管理员无法删除');
        }
        $where['id'] = array('eq',$id);
        if(false !== $adminModel->where($where)->delete()){
            $this->success('删除成功',cookie('__forward__'));
        }else{
            $this->error('删除失败');
        }
    }

    public function change_status(){
        if(IS_AJAX){
            $type = I('get.type','');
            if(I('get.id','') == 1){
                $this->error('超级管理员无法改变');
            }
            $data['id'] = I('get.id','');
            $data["$type"] = abs(I("get.$type",'')-1);
            if(false !== M('admin')->save($data)){
                $this->success('修改成功',cookie('__forward__'));
            }else{
                $this->error('修改失败');
            }
        }
    }
}