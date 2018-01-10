<?php
/**
 * Created by PhpStorm.
 * User: 17ZY-HPYKFD2
 * Date: 2018/1/10
 * Time: 14:30
 */
namespace Admin\Controller;
use Think\Upload;

class DeclarationController extends BaseController
{
    public function index()
    {
        $yearModel = M('year');
        $year_list = $yearModel->field(true)->select();
        $this->year_list = $year_list;
        cookie('__forward__',$_SERVER['REQUEST_URI']);
        $this->display();
    }

    public function upload()
    {
        if(IS_POST) {
            $museum_id = I('post.museum_id', '', intval);
            $year_id = I('post.year_id', '', intval);
//            $uploadPath = '/Uploads/'.'declaration'.'/';
            $upload = new Upload();
            $upload->maxSize = 3145728;
            $upload->exts = array('jpg', 'gif', 'png', 'jpeg', 'doc', 'docx');
            $upload->savePath = 'declaration/';
            $upload->rootPath = './Uploads/'; // 设置附件上传根目录
            $info = $upload->upload();
            if (!$info) {// 上传错误提示错误信息
                $this->error($upload->getError());
            } else {// 上传成功
//                var_dump($info);
                $data['file_name'] = $info['declaration']['savename'];
                $data['file_url'] = $info['declaration']['savepath'];
                $data['file_ext'] = $info['declaration']['ext'];
                $data['original_name'] = $info['declaration']['name'];
                $data['create_time'] = date('Y-m-d H:i:s');
                $data['year_id'] = $year_id;
                $data['museum_id'] = $museum_id;
//                M('declaration')->create($data);
                if (false === M('declaration')->add($data)) {
                    $this->error('数据库写入错误');
                }
                $this->success('上传成功!', cookie('__forward__'));
            }
        } else {
            $yearModel = M('year');
            $museumModel = M('museum');
            $year_list = $yearModel->field(true)->select();
            $museum_list = $museumModel->field('id', 'name')->select();
            $this->year_list = $year_list;
            $this->museum_list = $museum_list;
            $this->display();
        }

    }

}