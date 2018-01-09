<?php
/**
 * Created by PhpStorm.
 * User: 17ZY-HPYKFD2
 * Date: 2018/1/9
 * Time: 14:51
 */
namespace Admin\Model;
use Think\Model;

class ExpertModel extends Model
{
    protected $tableName = 'expert';

    public function getAnnualReviewExpert($yearId)
    {
        $expert_list = $this->field(true)->select();
        $indicatorModel = M('indicator');
        $expert_list1 = [];
        foreach ($expert_list as $k => $v) {
            if(in_array($yearId, unserialize($v['year_id']))) {
                $expert_list1[$k] = $expert_list[$k];
                $where['id'] = array('eq', $v['indicator_id']);
                $expert_list1[$k]['indicator_name'] = $indicatorModel->where($where)->getField('name');
            }
        }
        return $expert_list1;
    }

    public function getAnnualReviewExpertCandidate($yearId)
    {
        $expert_list = $this->field(true)->select();
        $indicatorModel = M('indicator');
        $expert_list2 = [];
        foreach ($expert_list as $k => $v) {
            if(!in_array($yearId, unserialize($v['year_id']))) {
                $expert_list2[$k] = $expert_list[$k];
                $where['id'] = array('eq', $v['indicator_id']);
                $expert_list2[$k]['indicator_name'] = $indicatorModel->where($where)->getField('name');
            }
        }
        return $expert_list2;
    }

    public function addAnnualExpert($id, $yearId)
    {
        $where['id'] = array('eq', $id);
        $expertInfo = $this->where($where)->find();
        if(is_null($expertInfo['year_id'])) {
            $res = [];
        } else {
            $res = unserialize($expertInfo['year_id']);
        }
        array_push($res, $yearId);
        $expertInfo['year_id'] = serialize($res);
        if(false === $this->create($expertInfo)) {
            return false;
        }
        if(false !== $this->save()) {
            return true;
        } else {
            return false;
        }
    }

    public function removeAnnualExpert($id, $yearId)
    {
        $where['id'] = array('eq', $id);
    }

}