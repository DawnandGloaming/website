<?php
/**
 * Created by PhpStorm.
 * User: 17ZY-HPYKFD2
 * Date: 2018/1/9
 * Time: 11:59
 */
namespace Admin\Model;
use Think\Model;

class MuseumModel extends Model
{
    protected $tableName = 'museum';
    public function getSearchResult($yearId)
    {
        $museumTypeModel = M('museum_type');
        $museumLevelModel = M('museum_level');
        $museum_list = $this->field(true)->select();
        $museum_list_search = [];
        foreach ($museum_list as $k => $v) {
            if(in_array($yearId, unserialize($v['year_id']))) {
                $museum_list_search[$k] = $museum_list[$k];
                $where['id'] = array('eq', $v['museum_type_id']);
                $museum_list_search[$k]['museum_type'] = $museumTypeModel->where($where)->getField('name');
                $where['id'] = array('eq', $v['museum_level_id']);
                $museum_list_search[$k]['museum_level'] = $museumLevelModel->where($where)->getField('name');
            }
        }
        $museum_list_search = array_values($museum_list_search);
        return json_encode($museum_list_search);
    }
}