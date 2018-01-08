<?php
namespace Admin\Controller;

class OneModelController extends BaseController {
    protected $modelName = null;//实例化表名

    public function index(){
        $this->modelName === null ? $model = D(CONTROLLER_NAME) : $model = D($this->modelName);
        method_exists($this,'index_list ') ? $this->index_list() : null;
        cookie('__forward__',$_SERVER['REQUEST_URI']);
        $this->display();
    }

    public function create(){
        $this->modelName === null ? $model = D(CONTROLLER_NAME) : $model = D($this->modelName);
        if(IS_POST){
            if(false === $model->create($_POST)){
                $this->error($model->getError());
            }
            if(false !== $model->add()){
                $this->success('添加成功',cookie('__forward__'));
            }else{
                $this->error('添加失败');
            }
        }else{
            method_exists($this,'get_create') ? $this->get_create() : null;
            $this->display();
        }
    }

    public function editor(){
        $this->modelName === null ? $model = D(CONTROLLER_NAME) : $model = D($this->modelName);
        if(IS_POST){
            if(false === $model->create($_POST)){
                $this->error($model->getError());
            }
            if(false !== $model->save()){
                $this->success('修改成功',cookie('__forward__'));
            }else{
                $this->error('修改失败');
            }
        }else{
            method_exists($this,'get_editor') ? $this->get_editor() : null;
            $this->display();
        }
    }

    public function delete(){
        $this->modelName === null ? $model = M(CONTROLLER_NAME) : $model = M($this->modelName);
        $where['delete'] = array('eq',1);
        $data['id'] = array('eq',I('get.id','',intval));
        if(false !== $model->where($where)->save($data)){
            $this->success('删除成功',cookie('__forward__'));
        }else{
            $this->error('删除失败');
        }
    }

    public function remove(){
        $this->modelName === null ? $model = M(CONTROLLER_NAME) : $model = M($this->modelName);
        $where['id'] = array('eq',I('get.id','',intval));
        if(false !== $model->where($where)->delete()){
            $this->success('删除成功',cookie('__forward__'));
        }else{
            $this->error('删除失败');
        }
    }

    public function list_form(){
        $this->modelName === null ? $model = M(CONTROLLER_NAME) : $model = M($this->modelName);
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
                $model->where('id=' . $k)->setField('sort', $v);
            }
        }
        $this->success('保存成功',cookie('__forward__'));
    }

    public function change_status(){
        $this->modelName === null ? $model = M(CONTROLLER_NAME) : $model = M($this->modelName);
        if(IS_AJAX){
            $type = I('get.type','');
            $data['id'] = I('get.id','',intval);
            $data["$type"] = abs(I("get.$type",'')-1);
            if(false !== $model->save($data)){
                $this->success('修改成功',cookie('__forward__'));
            }else{
                $this->error('修改失败');
            }
        }
    }

}