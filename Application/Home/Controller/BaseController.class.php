<?php
namespace Home\Controller;
use Common\Controller\CommonController;

class BaseController extends CommonController {
    public function _initialize() {
        parent::_initialize();
        /*检测网站是否开启*/
        if (C('WEB_STATUS')) {
            die(C('WEB_STATUS_INFO'));
        }
        $this->is_mobile('./Template/Mobile/default/');
    }
    public function switch_language(){
        if(IS_AJAX){
            $for_language = I('get.for_language','');
            empty($for_language) ? $this->error('参数错误') : null;
            if($for_language == 'english'){
                $old_theme = 'default';
                $theme = 'english';
                $old_db_prefix = 'zh_';
                $db_prefix = 'en_';
            }elseif ($for_language == '中文'){
                $old_theme = 'english';
                $theme = 'default';
                $old_db_prefix = 'en_';
                $db_prefix = 'zh_';
            }
            change_file_content(APP_PATH.'Home/Conf/mysql.php',$old_db_prefix,$db_prefix);
            change_file_content(APP_PATH.'Home/Conf/config.php',$old_theme,$theme);
            $this->ajaxReturn();
        }
    }
}