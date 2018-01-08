<?php
namespace Admin\Controller;
use Think\Controller;

class PublicController extends Controller{
    public function login(){
        $loginModel = D('Login');
        if(IS_POST){
            if(false === $loginModel->create($_POST)){
                $this->error($loginModel->getError());
            }
            $where['nickname'] = I('post.nickname','','htmlspecialchars');
            $where['password'] = I('post.password','','md5');
            $admin_info = $loginModel->where($where)->field('password',true)->find();
            if(!empty($admin_info)){
                $admin_status = (int)$admin_info['status'];
                if($admin_status !== 1){
                    $this->error('账号已冻结');
                }else{
                    $wheres['id'] = array('eq',$admin_info['group_id']);
                    $group_status = M('group')->where($wheres)->getField('status');
                    $data['id'] = $admin_info['id'];
                    $data['last_login_time'] = time();
                    $data['last_login_ip'] = get_client_ip();
                    if($admin_info['id'] != 1){
                        if($group_status != 1){
                            $this->error('权限组被冻结');
                        }else{
                            if(false !== $loginModel->save($data)){
                                session('admin_info',$admin_info);
                                $this->success('验证通过',U('Index/index'));
                            }else{
                                $this->error('用户名或密码错误');
                            }
                        }
                    }else{
                        if(false !== $loginModel->save($data)){
                            session('admin_info',$admin_info);
                            $this->success('验证通过',U('Index/index'));
                        }else{
                            $this->error('用户名或密码错误');
                        }
                    }
                }
            }else{
                $this->error('用户名或密码错误');
            }
        }else{
            $this->display();
        }
    }
    public function change_info(){
        $publicModel = D('Public');
        if(IS_POST){
            if(false === $publicModel->create($_POST)){
                $this->error($publicModel->getError());
            }
            if(false !== $publicModel->save()){
                $this->success('修改成功',cookie('__forward__'));
            }else{
                $this->error('修改失败');
            }
        }else{
            $admin_id = get_admin_id();
            $where['id'] = array('eq',$admin_id);
            $this_admin_info = $publicModel->where($where)->Field('password',true)->find();
            $this->this_admin_info = $this_admin_info;
            $this->display();
        }
    }
    public function change_password(){
        $publicModel = D('ChangePassword');
        if(IS_POST){
            if(false === $publicModel->create($_POST)){
                $this->error($publicModel->getError());
            }
            if(false !== $publicModel->save()){
                $this->success('修改成功',cookie('__forward__'));
            }else{
                $this->error('修改失败');
            }
        }else{
            $admin_id = get_admin_id();
            $this->admin_id = $admin_id;
            $this->display();
        }
    }
    public function logout(){
        session('admin_info', null);
        $this->redirect('Public/login');
    }
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