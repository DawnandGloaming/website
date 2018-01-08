<?php
namespace Admin\Model;
use Think\Model;

class GroupModel extends Model{
    protected $_validate = array(
        array('name','require','请输入分组名称'),
    );
}