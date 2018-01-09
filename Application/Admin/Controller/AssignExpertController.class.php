<?php
/**
 * Created by PhpStorm.
 * User: PCY
 * Date: 2018/1/7
 * Time: 16:58
 */
namespace Admin\Controller;
use Admin\Model\ExpertModel;

class AssignExpertController extends BaseController
{
    public function index()
    {
        $yearModel = M('year');
        $year_list = $yearModel->field(true)->select();
        $this->year_list = $year_list;
        cookie('__forward__',$_SERVER['REQUEST_URI']);
        $this->display();
    }

    public function search()
    {
        $expertModel = new ExpertModel;
        $year_id = I('get.year_id', '');
        $yearModel = M('year');
        $year_list = $yearModel->field(true)->select();
        $this->year_list = $year_list;
        $this->year_id = $year_id;
        $this->expert_list1 = $expertModel->getAnnualReviewExpert($year_id);
        $this->expert_list2 = $expertModel->getAnnualReviewExpertCandidate($year_id);
        $this->display('AssignExpert/index');
    }

    public function create()
    {
        $expertModel = new ExpertModel;
        $year_id = I('get.year_id', '');
        $id = I('get.id', '', intval);
        if(!$expertModel->addAnnualExpert($id, $year_id)) {
            $this->error('添加失败');
        }
        $this->success('添加成功', cookie('__forward__'));
    }

    public function remove()
    {
        $expertModel = new ExpertModel;
        $year_id = I('get.year_id', '');
        $id = I('get.id', '', intval);
        if(!$expertModel->removeAnnualExpert($id, $year_id)) {
            $this->error('删除失败');
        }
        $this->success('删除成功', cookie('__forward__'));
    }
}