<?php
namespace Admin\Model;
use Think\Model;

class LoginModel extends Model{
    protected $tableName = 'admin';
    protected $_validate = array(
        array('nickname','require','用户名不能为空'),
        array('password','require','密码不能为空'),
        array('verify','require','请输入验证码'),
        array('verify','CheckVerify','验证码错误',0,'callback'),
    );
    public function CheckVerify($verify){
        $Verify = new \Think\Verify();
        return $Verify->check($verify);
    }
}