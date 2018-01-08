<?php
/**
 * Created by PhpStorm.
 * User: 17ZY-HPYKFD2
 * Date: 2018/1/8
 * Time: 17:17
 */
namespace Admin\Model;
use Think\Model;
class YearModel extends Model
{
    protected $tableName = 'year';
    public function getYearNameList($ids)
    {
        $where['id'] = array('in', $ids);
        $res = $this->where($where)->field('name')->select();
        $yearList = [];
        foreach ($res as $k => $v) {
            $yearList[$k] = $v['name'];
        }
        return "[".implode(",", $yearList)."]";
    }
}