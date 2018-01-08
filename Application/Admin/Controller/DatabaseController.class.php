<?php
/**
 * 数据库备份
 * ###index>>备份文件列表###
 */
namespace Admin\Controller;
class DatabaseController extends AdminController{
    public function index(){
        $sqlDataDir = SITE_PATH . "/Data/";
        mkdir($sqlDataDir);
        if (!empty($_GET['Action'])) {
            $config = array(
                'host' => C('DB_HOST'),
                'port' => C('DB_PORT'),
                'userName' => C('DB_USER'),
                'userPassword' => C('DB_PWD'),
                'dbprefix' => C('DB_PREFIX'),
                'charset' => 'UTF8',
                'path' => $sqlDataDir,
                'isCompress' => 1, //是否开启gzip压缩
                'isDownload' => 0
            );
            $mr = new \Library\MySQLReback($config);
            $mr->setDBName(C('DB_NAME'));
            switch ($_GET['Action']) {
                case 'backup':
                    $mr->backup();
                    sleep(1);
                    $this->success('数据库备份成功');
                    die;
                    break;
                case 'RL':
                    $mr->recover($_GET['file']);
                    $this->success('数据库还原成功');
                    die;
                    break;
                case 'Del':
                    $this->RemoveFile($sqlDataDir . $_GET['file']);
                    die;
                    break;
                case 'download':
                    $this->DownloadFile($sqlDataDir . $_GET['file']);
                    die;
                    break;
            }
            die;
        }
        $sql_list = $this->MyScandir($sqlDataDir);
        $this->assign("sql_list", $sql_list);
        $this->display();
    }

    private function MyScandir($FilePath = './') {
        $FileCorse = opendir($FilePath);
        while (false !== ($filename = readdir($FileCorse))) {
            if ($filename != '.' && $filename != '..') {
                $FileAndFolderAyy[] = $filename;
            }
        }
        foreach ($FileAndFolderAyy as $k => $v) {
            $filetime = date('Y-m-d H:i:s', filectime($FilePath . $v));
            $FileList[$k]['filename'] = $v;
            $FileList[$k]['filesize'] = byte_format(filesize($FilePath . $v));
            $FileList[$k]['filetime'] = $filetime;
            $FileSort[$k] = $filetime;
        }
        array_multisort($FileSort, SORT_DESC, $FileList);
        return $FileList;
    }

    private function RemoveFile($filePath) {
        if (@unlink($filePath)) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }

    private function DownloadFile($fileName) {
        ob_end_clean();
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Length: ' . filesize($fileName));
        header('Content-Disposition: attachment; filename=' . basename($fileName));
        readfile($fileName);
    }

}