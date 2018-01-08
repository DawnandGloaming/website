<?php
namespace Library;
class MySQLReback {

    private $config;
    private $content;
    private $dbName = array();

    const DIR_SEP = DIRECTORY_SEPARATOR;

    public function __construct($config) {
        $this->config = $config;
        header("Content-type: text/html;charset=utf-8");
        $this->connect();
    }

    private function connect() {
        if (mysql_connect($this->config['host'] . ':' . $this->config['port'], $this->config['userName'], $this->config['userPassword'])) {
            mysql_query("SET NAMES '{$this->config['charset']}'");
            mysql_query("set interactive_timeout=24*3600");
        } else {
            $this->throwException('无法连接到数据库!');
        }
    }

    public function setDBName($dbName = '*') {
        if ($dbName == '*') {
            $rs = mysql_list_dbs();
            $rows = mysql_num_rows($rs);
            if ($rows) {
                for ($i = 0; $i < $rows; $i++) {
                    $dbName = mysql_tablename($rs, $i);
                    $block = array('information_schema', 'mysql');
                    if (!in_array($dbName, $block)) {
                        $this->dbName[] = $dbName;
                    }
                }
            } else {
                $this->throwException('没有任何数据库!');
            }
        } else {
            $this->dbName = func_get_args();
        }
    }

    private function getFile($fileName) {
        $this->content = '';
        $fileName = $this->trimPath($this->config['path'] . self::DIR_SEP . $fileName);
        if (is_file($fileName)) {
            $ext = strrchr($fileName, '.');
            if ($ext == '.sql') {
                $this->content = file_get_contents($fileName);
            } elseif ($ext == '.gz') {
                $this->content = implode('', gzfile($fileName));
            } else {
                $this->throwException('无法识别的文件格式!');
            }
        } else {
            $this->throwException('文件不存在!');
        }
    }

    private function setFile() {
        $recognize = '';
        $recognize = implode('_', $this->dbName);
        $fileName = $this->trimPath($this->config['path'] . self::DIR_SEP . $recognize . '_sql_' . date('YmdHis') . '.sql');
        $path = $this->setPath($fileName);
        if ($path !== true) {
            $this->throwException("无法创建备份目录目录 '$path'");
        }
        if ($this->config['isCompress'] == 0) {
            if (!file_put_contents($fileName, $this->content, LOCK_EX)) {
                $this->throwException('写入文件失败,请检查磁盘空间或者权限!');
            }
        } else {
            if (function_exists('gzwrite')) {
                $fileName .= '.gz';
                if ($gz = gzopen($fileName, 'wb')) {
                    gzwrite($gz, $this->content);
                    gzclose($gz);
                } else {
                    $this->throwException('写入文件失败,请检查磁盘空间或者权限!');
                }
            } else {
                $this->throwException('没有开启gzip扩展!');
            }
        }
        if ($this->config['isDownload']) {
            $this->downloadFile($fileName);
        }
    }

    private function trimPath($path) {
        return str_replace(array('/', '\\', '//', '\\\\'), self::DIR_SEP, $path);
    }

    private function setPath($fileName) {
        $dirs = explode(self::DIR_SEP, dirname($fileName));
        $tmp = '';
        foreach ($dirs as $dir) {
            $tmp .= $dir . self::DIR_SEP;
            if (!file_exists($tmp) && !@mkdir($tmp, 0777))
                return $tmp;
        }
        return true;
    }

    private function downloadFile($fileName) {
        ob_end_clean();
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Length: ' . filesize($fileName));
        header('Content-Disposition: attachment; filename=' . basename($fileName));
        readfile($fileName);
    }

    private function backquote($str) {
        return "`{$str}`";
    }

    private function getTables($dbName) {
        @$rs = mysql_list_tables($dbName);
        $rows = mysql_num_rows($rs);
        $dbprefix = $this->config['dbprefix'];
        for ($i = 0; $i < $rows; $i++) {
            $tbName = mysql_tablename($rs, $i);
            if (substr($tbName, 0, strlen($dbprefix)) == $dbprefix) {
                $tables[] = $tbName;
            }
        }
        return $tables;
    }

    private function chunkArrayByByte($array, $byte = 5120) {
        $i = 0;
        $sum = 0;
        foreach ($array as $v) {
            $sum += strlen($v);
            if ($sum < $byte) {
                $return[$i][] = $v;
            } elseif ($sum == $byte) {
                $return[++$i][] = $v;
                $sum = 0;
            } else {
                $return[++$i][] = $v;
                $i++;
                $sum = 0;
            }
        }
        return $return;
    }

    public function backup() {
    	$this->content  = "-- -----------------------------\n";
    	$this->content .= "-- Think MySQL Data Transfer \n";
    	$this->content .= "-- \n";
    	$this->content .= "-- Host     : " . C('DB_HOST') . "\n";
    	$this->content .= "-- Port     : " . C('DB_PORT') . "\n";
    	$this->content .= "-- Database : " . C('DB_NAME') . "\n";
    	$this->content .= "-- \n";
    	$this->content .= "-- Date : " . date("Y-m-d H:i:s") . "\n";
    	$this->content .= "-- -----------------------------\n\n";
    	$this->content .= "SET FOREIGN_KEY_CHECKS = 0;/* SqlEnd */\n";
       
        foreach ($this->dbName as $dbName) {
            $qDbName = $this->backquote($dbName);
            $rs = mysql_query("SHOW CREATE DATABASE {$qDbName}");
            if ($row = mysql_fetch_row($rs)) {
                mysql_select_db($dbName);
                $tables = $this->getTables($dbName);
                foreach ($tables as $table) {
                    $table = $this->backquote($table);
                    $tableRs = mysql_query("SHOW CREATE TABLE {$table}");
                    if ($tableRow = mysql_fetch_row($tableRs)) {
                    	
                    	$this->content .= "\n\n\n";
                    	$this->content .= "-- -----------------------------\n";
                    	$this->content .= "-- Table structure for {$table}\n";
                    	$this->content .= "-- -----------------------------\n";
                    	$this->content .= "DROP TABLE IF EXISTS {$table};/* SqlEnd */\n{$tableRow[1]};/* SqlEnd */\n\n";
                        
                        $tableDateRs = mysql_query("SELECT * FROM {$table}");
                        $valuesArr = array();
                        $values = '';
                        while ($tableDateRow = mysql_fetch_row($tableDateRs)) {
                            foreach ($tableDateRow as &$v) {
                                $v = "'" . addslashes($v) . "'";
                            }
                            $valuesArr[] = '(' . implode(',', $tableDateRow) . ')';
                        }
                       
                        $temp = $this->chunkArrayByByte($valuesArr);
                        
                        if (is_array($temp)) {
                        	$this->content .= "-- -----------------------------\n";
                        	$this->content .= "-- Records of `{$table}`\n";
                        	$this->content .= "-- -----------------------------\n";
                            foreach ($temp as $v) {
                                $values = implode(',', $v);
                                $values=str_replace(array("\r","\n"),array('\r','\n'),$values);
                                    $this->content .= "INSERT INTO {$table} VALUES {$values};/* SqlEnd */\n";
                            }
                        }
                    }
                }
            } else {
                $this->throwException('未能找到数据库!');
            }
        }
        if (!empty($this->content)) {
            $this->setFile();
        }
        return true;
    }

	public function recover($fileName) {
        $this->getFile($fileName);
        if (!empty($this->content)) {
            $content = explode(';/* SqlEnd */', $this->content);
            foreach ($content as $i => $sql) {
                $sql = trim($sql);
                
                if (!empty($sql)) {
                    $dbName = $this->dbName[0];
                    if (!mysql_select_db($dbName))
                        $this->throwException('不存在的数据库!' . mysql_error());
                    $rs = mysql_query($sql);
                    if ($rs) {
                        if (strstr($sql, 'CREATE DATABASE')) {
                            $dbNameArr = sscanf($sql, 'CREATE DATABASE %s');
                            $dbName = trim($dbNameArr[0], '`');
                            mysql_select_db($dbName);
                        }
                    } else {
                        $this->throwException('备份文件被损坏!' . mysql_error());
                    }
                }
            }
        } else {
            $this->throwException('无法读取备份文件!');
        }
        return true;
    }

    private function throwException($error) {
    	throw_exception($error);
    }

}

?>