<?php
namespace Home\Controller;
use Think\Controller;

class PublicController extends Controller{
    public function verify() {
        $config = array(
            'codeSet'   =>  '123456789',   // 验证码字符集合
            'useImgBg' => false,           // 使用背景图片 
            'fontSize' => 14,              // 验证码字体大小(px)
            'useCurve' => false,          // 是否画混淆曲线
            'useNoise' => false,          // 是否添加杂点
            'length' => 4,                 // 验证码位数
            'bg' => array(255, 255, 255),  // 背景颜色
        );
        $Verify = new \Think\Verify($config);
        $Verify->entry();
    }
}