<?php
namespace Admin\Model;
use Think\Model;

class ChangePasswordModel extends Model{
    protected $tableName = 'admin';
    protected $_validate = array(
        array('old_password','require','请输入原密码'),
        array('old_password','check_password','原密码错误',0,'callback'),
        array('password','require','请输入密码'),
        array('passwords','require','请输入确认密码'),
        array('passwords','password','两次密码不一致',1,'confirm'),
    );
    protected $_auto = array(
        array('password','md5',2,'function'),
    );
    public function check_password(){
        $old_password = I('old_password','',md5);
        $this_admin_id = I('post.id','',intval);
        $where['id'] = array('eq',$this_admin_id);
        $this_password = M('admin')->where($where)->getField('password');
        if($old_password !== $this_password){
            return false;
        }else{
            return true;
        }
    }
}