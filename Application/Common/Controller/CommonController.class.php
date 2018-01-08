<?php
namespace Common\Controller;
use Think\Controller;

class CommonController extends Controller {
    public function _initialize() {
        /*多域名跳转到正式域名*/
        if (C('TEST_DOMAIN') && C('FORMAL_DOMAIN')) {
            if (in_array($_SERVER['HTTP_HOST'], explode('|', C('TEST_DOMAIN')))) {
                $formal_url = str_replace($_SERVER['HTTP_HOST'], C('FORMAL_DOMAIN'), $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
                header("Location:http://" . $formal_url);
            }
        }
        $this->is_mobile();
    }

    /**
     * +----------------------------------------------------------
     * 手机端判断
     * +----------------------------------------------------------
     */
    protected function is_mobile($viewPath) {
        if (C('HAS_WAP')) {
            define('IS_WAP', is_mobile());
            if (IS_WAP) {
                C('VIEW_PATH', $viewPath);
            }
        } else {
            define('IS_WAP', false);
        }
    }
}