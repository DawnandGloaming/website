<?php
/**
 * 管理组控制器
 * ###index>>管理组列表###
 * @@@create>>添加管理组@@@
 * @@@editor>>修改管理组@@@
 * @@@remove>>删除管理组@@@
 * @@@change_status>>改变状态@@@
 * @@@give_rule>>管理组授权@@@
 */
namespace Admin\Controller;
class GroupController extends BaseController{
    public function index(){
        $groupModel = M('Group');
        $group_list = $groupModel->field('access',true)->select();
        cookie('__forward__',$_SERVER['REQUEST_URI']);
        $this->group_list = $group_list;
        $this->display();
    }
    public function create(){
        $groupModel = D('Group');
        if(IS_POST){
            if(false === $groupModel->create($_POST)){
                $this->error($groupModel->getError());
            }
            if(false !== $groupModel->add()){
                $this->success('添加成功',cookie('__forward__'));
            }else{
                $this->error('添加失败');
            }
        }
        $this->display();
    }
    public function editor(){
        $groupModel = D('Group');
        if(IS_POST){
            if(false === $groupModel->create($_POST)){
                $this->error($groupModel->getError());
            }
            if(false !== $groupModel->save()){
                $this->success('修改成功',cookie('__forward__'));
            }else{
                $this->error('修改失败');
            }
        }else{
            $id = I('get.id','',intval);
            $where['id'] = array('eq',$id);
            $this_group_info = $groupModel->where($where)->field('rules',true)->find();
            $this->this_group_info = $this_group_info;
            $this->display();
        }
    }
    public function remove(){
        $id = I('get.id','',intval);
        empty($id) ? $this->error('参数错误') : null;
        $where['id'] = array('eq',$id);
        if(false !== M('group')->where($where)->delete()){
            $this->success('删除成功',cookie('__forward__'));
        }else{
            $this->error('删除失败');
        }
    }

    public function change_status(){
        $groupModel = D('Group');
        if(IS_AJAX){
            $type = I('get.type','');
            $data['id'] = I('get.id','');
            $data["$type"] = abs(I("get.$type",'')-1);
            if(false !== $groupModel->save($data)){
                $this->success('修改成功',cookie('__forward__'));
            }else{
                $this->error('修改失败');
            }
        }
    }

    public function give_rule(){
        $ruleModel = M('rule');
        $groupModel = M('group');
        if(IS_POST){
            $id = I('post.id','',intval);
            $access = I('post.access','');
            $rules = serialize($access);
            $where['id'] = array('eq',$id);
            $data['access'] = array('eq',$rules);
            if (false !== $groupModel->where($where)->setField('access', $rules)){
                $this->success('授权成功');
            } else {
                $this->error('授权失败');
            }
            echo $groupModel->getLastSql();
        }else{
            $id = I('get.id','',intval);
            $rule_list = $ruleModel->field(true)->select();
            $rule_list = \Library\Tree::list_to_tree($rule_list);
            $where['id'] = array('eq',$id);
            $group_info = $groupModel->where($where)->find();
            foreach ($rule_list as $k => $v) {
                if (in_array($v['id'], unserialize($group_info['access']))) {
                    $rule_list[$k]['access'] = true;
                } else {
                    $rule_list[$k]['access'] = false;
                }
            }
            $assign['name'] = $group_info['name'];
            $assign['rule_list'] = list_to_tree($rule_list);
            $this->assign($assign);
            $this->display();
        }
    }
}