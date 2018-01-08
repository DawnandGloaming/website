<?php
/**
 * Created by PhpStorm.
 * User: PCY
 * Date: 2018/1/7
 * Time: 16:58
 */
namespace Admin\Controller;
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
        $expert_list1 = M('expert')->field(true)->select();
        $this->index()->assign('expert_list1', $expert_list1);
        $this->success("123");
        $this->display('AssignExpert/index');
//            foreach ($expert_list1 as $k => $v) {
//                if(!in_array($yearId, unserialize($v['year_id']))) {
//                    $expert_list2[] = array_splice($expert_list1, $k, 1)[0];
//                }
//            }
//            $this->expert_list1 = $expert_list1;
    }
}