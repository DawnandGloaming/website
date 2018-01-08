<?php
namespace Admin\Controller;
class ClearController extends BaseController{
    public function cache(){
        $rtim = del_dir(SITE_PATH . '/Runtime');
        if ($rtim) {
            $this->success('清除成功');
        } else {
            $this->error('清除失败');
        }
    }
}