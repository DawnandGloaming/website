<?php
/**
 * Created by PhpStorm.
 * User: 17ZY-HPYKFD2
 * Date: 2018/1/5
 * Time: 18:20
 */
namespace Admin\Controller;
class ExpertController extends BaseController
{
    public function index()
    {
        $indicatorModel = M('indicator');
        $expertModel = M('expert');
        $expert_list = $expertModel->field(true)->select();
        foreach($expert_list as $k => $v) {
            $where['id'] = array('eq', $v['indicator_id']);
            $expert_list[$k]['indicator_name'] = $indicatorModel->where($where)->getField('name');
        }
        $this->expert_list = $expert_list;
        cookie('__forward__',$_SERVER['REQUEST_URI']);
        $this->display();
    }

    public function create()
    {
        $indicatorModel = M('indicator');
        $expertModel = M('expert');
        if(IS_POST) {
            if(false === $expertModel->create($_POST)) {
                $this->error($expertModel->getError());
            }

            if(false !== $expertModel->add()) {
                $this->success('添加成功',cookie('__forward__'));
            } else {
                $this->error("添加失败");
            }
        } else {
            $indicator_list = $indicatorModel->field(true)->select();
            $this->indicator_list = $indicator_list;
            $this->display();
        }
    }

    public function remove()
    {
        $expertModel = M('expert');
        $id = I('get.id', 0, intval);
        $where['id'] = array('eq', $id);
        empty($id) ? $this->error("参数错误") : null;
        if(false !== $expertModel->where($where)->delete()) {
            $this->success("删除成功");
        } else {
            $this->error("删除失败");
        }
    }

    public function editor()
    {
        $a = [];
        $expertModel = M('expert');
        if(IS_POST) {
            if(false === $expertModel->create($_POST)) {
                $this->error($expertModel->getError());
            }
            if(false !== $expertModel->save()) {
                $this->success('修改成功',cookie('__forward__'));
            } else {
                $this->error('修改失败');
            }
        } else {
            $id = I('get.id', '', intval);
            $where['id'] = array('eq', $id);
            $expert_info = $expertModel->where($where)->find();
            $this->expert_info = $expert_info;
            $indicator_list = M('indicator')->select();
            $this->indicator_list = $indicator_list;
            $this->display();
        }
    }


}