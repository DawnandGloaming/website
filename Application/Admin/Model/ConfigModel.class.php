<?php
namespace Admin\Model;
use Think\Model;

class ConfigModel extends Model {
    protected $_validate = array(
        array('name', 'require', '设置名不能为空！'),
        array('name', '', '设置名已经存在！', 0, 'unique', 1),
        array('varname', 'require', '变量名不能为空！'),
        array('varname', '', '变量名已经存在！', 0, 'unique', 1),
    );
    protected $_auto = array(
        array('varname', 'strtoupper', 3, 'function'),
        array('sort','auto_sort',1,'callback'),
    );
    public function auto_sort(){
        $group_id = I('post.group_id','',intval);
        if($group_id !== ''){
            $sort = $this->where(array('group_id'=>$group_id))->max('sort');
        }else{
            $sort = 0;
        }
        $new_sort = $sort + 1;
        return $new_sort;
    }
}