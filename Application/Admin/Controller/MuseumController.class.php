<?php
/**
 * Created by PhpStorm.
 * User: PCY
 * Date: 2018/1/8
 * Time: 0:32
 */
namespace Admin\Controller;
use Think\Controller;
use Admin\Model\YearModel;
class MuseumController extends BaseController
{
    public function index()
    {
        $museumModel = M('museum');
        $museumTypeModel = M('museum_type');
        $museumLevelModel = M('museum_level');
        $yearModel = new YearModel;
        $museum_list = $museumModel->field(true)->select();
        foreach ($museum_list as $k => $v) {
            $where['id'] = array('eq', $v['museum_type_id']);
            $museum_list[$k]['museum_type'] = $museumTypeModel->where($where)->getField('name');
            $where['id'] = array('eq', $v['museum_level_id']);
            $museum_list[$k]['museum_level'] = $museumLevelModel->where($where)->getField('name');
            $museum_list[$k]['year_id'] = unserialize($museum_list[$k]['year_id']);
            $museum_list[$k]['year'] = $yearModel->getYearNameList($museum_list[$k]['year_id']);
        }
        $this->museum_list = $museum_list;
        cookie('__forward__',$_SERVER['REQUEST_URI']);
        $this->display();
    }


    public function create()
    {
        $museumModel = M('museum');
        $museumTypeModel = M('museum_type');
        $museumLevelModel = M('museum_level');
        $yearModel = M('year');
        if(IS_POST) {
            $_POST['year_id'] = serialize($_POST['year_id']);
            if(false === $museumModel->create($_POST)) {
                $this->error($museumModel->getError());
            }

            if(false !== $museumModel->add()) {
                $this->success('添加成功',cookie('__forward__'));
            } else {
                $this->error('添加失败');
            }
        } else {
            $museum_type_list = $museumTypeModel->field(true)->select();
            $this->museum_type_list = $museum_type_list;
            $museum_level_list = $museumLevelModel->field(true)->select();
            $this->museum_level_list = $museum_level_list;
            $year_list = $yearModel->field(true)->select();
            $this->year_list = $year_list;
            $this->display();
        }
    }

    public function showMuseumYearList()
    {
        $yearModel = M('year');
        $year_list = $yearModel->field(true)->select();
        $this->year_list = $year_list;
        cookie('__forward__',$_SERVER['REQUEST_URI']);
        $this->display('Museum/search');
    }

    public function search()
    {
        $year_id = I('post.year_id', '');
        $jumpUrl = I('post.url', '');
        $museumModel = M('museum');
        $museum_list = $museumModel->field(true)->select();
        $museum_list_search = [];
        foreach ($museum_list as $k => $v) {
            if(in_array($year_id, unserialize($v['year_id']))) {
                $museum_list_search[] = $museum_list[$k];
            }
        }
        $this->museum_list = $museum_list;
//        var_dump($museum_list_search);
        $this->success($jumpUrl, cookie('__forward__'));

    }
}