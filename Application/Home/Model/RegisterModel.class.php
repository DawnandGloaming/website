<?php
namespace Home\Model;
use Think\Model;

class RegisterModel extends Model{
    protected $tableName = 'member';
    protected $_validate = array(
        array('nickname','require','请输入用户名'),
        array('nickname', '', '用户名已经存在', 0, 'unique', 1),
        array('phone','require','请输入手机号码'),
        array('phone', '/^((1([3-8]{1})([0-9]{1})|(15[0-9]{1}))+\d{8})$/', '手机号码格式不对'),
        array('phone', '', '手机号已使用', 0, 'unique', 1),
        array('email','require','请输入邮箱'),
        array('email', 'email', '邮箱格式不正确'),
        array('email', '', '邮箱已使用', 0, 'unique', 1),
        array('password','require','请输入密码'),
        array('passwords','require','请输入确认密码'),
        array('passwords','password','两次密码不一致',1,'confirm'),
        array('verify','require','请输入验证码'),
        array('verify','CheckVerify','验证码错误',0,'callback'),
    );
    protected $_auto = array(
        array('password','md5',1,'function'),
        array('register_time','time',1,'function'),
        array('register_ip','get_client_ip',1,'function'),
    );
    public function CheckVerify($verify){
        $Verify = new \Think\Verify();
        return $Verify->check($verify);
    }
}