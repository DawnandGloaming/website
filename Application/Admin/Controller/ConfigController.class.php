<?php
namespace Admin\Controller;
class ConfigController extends BaseController{
    public function index(){
        $configModel = M('Config');
        switch (CONTROLLER_NAME){
            case 'WebConfig':
                $group_id = 1;
                break;
            case 'BasicConfig':
                $group_id = 2;
                break;
            case 'CoreConfig':
                $group_id = 3;
                break;
            case 'EmailConfig':
                $group_id = 4;
                break;
            case 'AdjunctConfig':
                $group_id = 5;
                break;
        }
        $where['group_id'] = array('eq',$group_id);
        $this->group_id = $group_id;
        cookie('__forward__',$_SERVER['REQUEST_URI']);
        $this->config_list = $configModel->where($where)->field(true)->order('sort asc')->select();
        $this->display('Config/index');
    }

    public function create(){
        $config_typeModel = M('ConfigType');
        $configModel = D('Config');
        if(IS_POST){
            if(false === $configModel->create($_POST)){
                $this->error($configModel->getError());
            }else{
                if (false !== $configModel->add()){
                    $this->freadconfig();
                    $this->success('添加成功',cookie('__forward__'));
                }else{
                    $this->error('添加失败');
                }
            }
        }else{
            $group_id = I('get.group_id','',intval);
            $this->group_id = $group_id;
            $this->config_type_list = $config_typeModel->field(true)->select();
            $this->display('Config/create');
        }
    }

    public function editor(){
        $config_typeModel = M('ConfigType');
        $configModel = D('Config');
        if(IS_POST){
            if(false === $configModel->create($_POST)){
                $this->error($configModel->getError());
            }else{
                if (false !== $configModel->save()){
                    $this->success('修改成功',cookie('__forward__'));
                }else{
                    $this->error('修改失败');
                }
            }
        }else{
            $id = I('get.id','',intval);
            $this->config_type_list = $config_typeModel->field(true)->select();
            $where['id'] = array('eq',$id);
            $this->config_info = $configModel->where($where)->field(true)->find();
            $this->display('Config/editor');
        }
    }

    public function remove(){
        $id = I('get.id','',intval);
        empty($id) ? $this->error('参数错误') : null;
        $where['id'] = array('eq',$id);
        if(false !== M('config')->where($where)->delete()){
            $this->success('删除成功',cookie('__forward__'));
        }else{
            $this->error('删除失败');
        }
    }

    public function list_form(){
        $configModel = M('Config');
        if (!is_array($_POST['sort'])) {
            $this->error('没有任何数据');
        }
        foreach ($_POST['sort'] as $k => $v) {
            $reg = "/^[0-9]*$/";
            if (!preg_match($reg, $v)) {
                $this->error('只能是数字');
            }
            if ($v == '') {
                $this->error('排序不能为空');
            } else {
                $configModel->where('id=' . $k)->setField('sort', $v);
            }
        }
        foreach ($_POST['value'] as $key => $val) {
            $configModel->where('id=' . $key)->setField('value', $val);
        }
        $this->freadconfig();
        $this->success('保存成功',cookie('__forward__'));
    }

    private function freadconfig() {
        del_dir(RUNTIME_PATH . '/Cache');
        $voList = M('Config')->order('id')->field('varname,value')->select();
        $temphtml = '<?php
/**
 * 系统配置文件
 * @version        Website ' . date(' Y年m月d日H:i:s') . ' struggle $
 */
/**
 * 系统会自动生成配置文件请勿自行修改，否则系统会出错误 
 */
return array(' . "\n";
        foreach ($voList as $v) {
            $temphtml .= "\t" . '\'' . $v['varname'] . '\'=><<<html' . "\n" . $v['value'] . "\n" . 'html' . "\n" . ',' . "\n\n";
        }
        $temphtml .= "\t" . ');
?>';
        $filename = C('CONF_WRITE_PATH');
        $handle = fopen($filename, 'w');
        $fwrite = fwrite($handle, $temphtml);
        fclose($handle);
        if ($fwrite === FALSE) {
            return false;
        } else {
            return true;
        }
    }
}