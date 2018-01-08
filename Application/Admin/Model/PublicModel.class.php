<?php
namespace Admin\Model;
use Think\Model;

class PublicModel extends Model{
    protected $tableName = 'admin';
    protected $_validate = array(
        array('nickname','require','请输入用户名'),
        array('email','require','请输入邮箱'),
        array('email', 'email', '邮箱格式不正确'),
    );
}