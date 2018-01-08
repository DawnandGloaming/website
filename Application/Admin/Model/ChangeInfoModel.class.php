<?php
namespace Admin\Model;
use Think\Model;

class ChangeInfoModel extends Model{
    protected $tableName = 'admin';
    protected $_validate = array(
        array('nickname','require','请输入用户名'),
        array('passwords','password','两次密码不一致',0,'confirm'),
        array('email','require','请输入邮箱'),
        array('email', 'email', '邮箱格式不正确'),
    );
    protected $_auto = array(
        array('password','password_change',2,'callback'),
    );
    public function password_change(){
        $id = I('post.id');
        $password = I('post.password','',trim);
        $old_password = $this->where('id='.$id)->getField('password');
        empty($password)?$new_password = $old_password:$new_password = md5($password);
        return $new_password;
    }
}