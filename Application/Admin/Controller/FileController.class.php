<?php
/**
 * 文件管理控制器
 * ###index>>文件夹列表###
 * @@@editfile>>编辑文件@@@
 * @@@downfile>>下载文件@@@
 * @@@delfolder>>删除文件@@@
 * @@@filehandle>>批量打包@@@
 * @@@decompression>>解压@@@
 */
namespace Admin\Controller;
class FileController extends AdminController {
    public function index() {
        $path = I('get.dir');
        $next_path = $this->next_path($path);
        $tree = glob($next_path);
        foreach ($tree as $k => $v) {
            $end = explode("/",to_utf($v));
            $file_list[$k]['name'] = end($end);
            $file_list[$k]['path'] = url_encode(to_utf($v));
            if (is_file($v)) {
                $file_list[$k]['type'] = true;
                $ext = pathinfo($v, PATHINFO_EXTENSION);
                $file_list[$k]['ext'] = $ext;
                $file_list[$k]['create_time'] = date('Y-m-d H:i:s', filectime($v));
                $file_list[$k]['update_time'] = date('Y-m-d H:i:s', filemtime($v));
                $file_list[$k]['filesize'] = byte_format(filesize($v));
            } else {
                $file_list[$k]['type'] = false;
                $file_list[$k]['create_time'] = date('Y-m-d H:i:s', filectime($v));
                $file_list[$k]['update_time'] = date('Y-m-d H:i:s', filemtime($v));
                $file_list[$k]['filesize'] = '-';
            }
        }
        $assign['file_list'] = $file_list;
        $assign['last_path'] = $this->last_path($path);
        $nowpath = to_utf($this->now_path($path));
        if ($nowpath) {
            $assign['now_path'] = str_replace(SITE_PATH, '', $nowpath);
        } else {
            $assign['now_path'] = '/';
        }
        $this->assign($assign);
        $this->display();
    }

    public function editfile() {
        $path = I('get.dir');
        $now_path = $this->now_path($path);
        if (IS_POST) {
            $content = I('post.content', '', 'htmlspecialchars_decode');
            if (file_put_contents($now_path, $content)) {
                $this->success('修改成功');
            } else {
                $this->error('修改失败');
            }
        } else {
            $ext = pathinfo($now_path, PATHINFO_EXTENSION);
            $array = array('php', 'html', 'txt', 'css', 'js');
            if (!in_array($ext, $array)) {
                $this->error('文件不能编辑');
            }
            $content = file_get_contents($now_path);
            $last_path = $this->last_path($path);
            $this->ext = $ext;
            $nowpath = to_utf($this->now_path($path));
            if ($nowpath) {
                $assign['now_path'] = str_replace(SITE_PATH, '', $nowpath);
            } else {
                $assign['now_path'] = '/';
            }
            $assign['content'] = htmlspecialchars(preg_replace('/--(.*?)--/is', '--$1--', $content));
            $assign['last_path'] = $last_path;
            $this->assign($assign);
            $this->display();
        }
    }
    

    function downfile() {
        $path = I('get.dir');
        $file = $this->now_path($path);
        $size = filesize($file);
        $filename = basename(to_utf($file));
        $fileext = pathinfo($file, PATHINFO_EXTENSION);
        if (is_file($file)) {
            $download = new \Library\Download('', false);
            if (!$download->downloadfile($file)) {
                echo $download->geterrormsg();
            }
            exit;
        }
    }

    function delfile() {
        $path = I('get.dir');
        $path = $this->now_path($path);
        if (unlink($path)) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }

    function delfolder() {
        $path = I('get.dir');
        $path = $this->now_path($path);
        if ($this->deldir($path)) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }

    private function deldir($dir) {
        if (is_dir($dir)) {
            $dh = opendir($dir);
            while ($file = readdir($dh)) {
                if ($file != "." && $file != "..") {
                    $fullpath = $dir . "/" . $file;
                    if (!is_dir($fullpath)) {
                        unlink($fullpath);
                    } else {
                        $this->deldir($fullpath);
                    }
                }
            }
            closedir($dh);
            if (rmdir($dir)) {
                return true;
            } else {
                return false;
            }
        } else {
            if (unlink($dir)) {
                return true;
            } else {
                return false;
            }
        }
    }

    function filehandle() {
        $data = I('post.dir');
        if ($data == '') {
            $this->error('没有任何选择');
            die;
        }
        $zip = new \ZipArchive();
        $zipname = SITE_PATH . '/' . date('YmdHis', time()) . '.gz';
        if ($zip->open($zipname, \ZIPARCHIVE::CREATE) !== TRUE) {
            $this->error('无法创建文件');
        }
        foreach ($data as $k => $v) {
            $files[] = $this->listdir($this->now_path($v));
        }
        foreach ($files as $v) {
            foreach ($v as $path) {
                $zip->addFile($path, str_replace("./", "", str_replace("\\", "/", $path)));
            }
        }
        $zip->close();
        $this->success('打包成功');
    }

    private function listdir($dir = '.') {
        $files = array();
        if (is_dir($dir)) {
            $fh = opendir($dir);
            while (($file = readdir($fh)) !== false) {
                $filepath = $dir . '/' . $file;
                if ((strcmp($file, '.') == 0 || strcmp($file, '..') == 0))
                    continue;
                if (is_dir($filepath)) {
                    $files = array_merge($files, $this->listdir($filepath));
                } else {
                    array_push($files, $filepath);
                }
            }
            closedir($fh);
        } else {
            array_push($files, $dir);
        }
        return $files;
    }

    function decompression() {
        $path = I('get.dir');
        $path = url_decode($path);
        if ($this->Release($path, dirname($path))) {
            $this->success('解压成功');
        } else {
            $this->error('解压失败');
        }
    }

    private function Release($file, $path = null) {
        if (!isset ($path)) {
            $array = explode('.', $file);
            $path = reset($array);
        }
        $zip = new \ZipArchive ();
        if ($zip->open($file) === true) {
            $rs = $zip->extractTo($path);
            $zip->close();
        }
        return $rs;
    }

    private function next_path($path) {
        $path = url_decode($path);
        if ($path == '') {
            return SITE_PATH . '/*';
        } else {
            $path = to_gbk($path);
            return $path . '/*';
        }
    }

    private function last_path($path) {
        $path = url_decode($path);
        if ($path == SITE_PATH) {
            $path = '';
        }
        $path = dirname($path);
        $path = url_encode($path);
        return $path;
    }

    private function now_path($path) {
        $path = url_decode($path);
        $path = to_gbk($path);
        return $path;
    }
}