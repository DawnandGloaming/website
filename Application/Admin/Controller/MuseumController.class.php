<?php
/**
 * Created by PhpStorm.
 * User: PCY
 * Date: 2018/1/8
 * Time: 0:32
 */
namespace Admin\Controller;
class MuseumController extends BaseController
{
    public function index()
    {
        $museumModel = M('museum');
        $museumTypeModel = M('museum_type');
        $museumLevelModel = M('museum_level');
        $museum_list = $museumModel->field(true)->select();
        foreach ($museum_list as $k => $v) {
            $where['id'] = array('eq', $v['museum_']);
        }
    }
}