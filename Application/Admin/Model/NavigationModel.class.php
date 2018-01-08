<?php
namespace Admin\Model;
use Think\Model;

class NavigationModel extends Model{
    protected $_validate = array(
        array('name','require','导航名称不能为空',0,),
        array('url','require','导航链接不能为空',0,),
    );
    protected $_auto = array(
        array('sort','auto_sort',1,'callback'),
    );
    public function auto_sort(){
        $pid = I('post.pid','',intval);
        if($pid !== ''){
            $sort = $this->where(array('pid'=>$pid))->max('sort');
        }else{
            $sort = 0;
        }
        $new_sort = $sort + 1;
        return $new_sort;
    }
}