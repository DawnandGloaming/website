<?php
namespace Home\Controller;
class MemberController extends BaseController{
    public function register(){
        $registerModel = D('register');
        $adminModel = M('admin');
        if(IS_POST){
            if(false === $registerModel->create($_POST)){
                $this->error($registerModel->getError());
            }else{
                $initialize_member_list = $registerModel->select();
                if(empty($initialize_member_list)){
                    if(false !== $registerModel->add()){
                        $first_member = $registerModel->where('id=1')->field(true)->find();
                        $adminModel->add($first_member);
                        $this->success('注册成功',U('Member/login'));
                    }else{
                        $this->error('注册失败');
                    }
                }else{
                    if(false !== $registerModel->add()){
                        $this->success('注册成功',U('Member/login'));
                    }else{
                        $this->error('注册失败');
                    }
                }
            }
        }else{
            $this->display();
        }
    }
    public function login(){
        $this->display();
    }
    public function logout(){

    }
}