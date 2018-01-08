<?php
// +------------------------------------------------------------------------
// 无限分类自定义排序
// +------------------------------------------------------------------------
namespace Library;
class Tree {
    static protected $arr = array();            //排序数组
    static protected $tree = array();          //存放生成类数组
    static protected $parent_field = 'pid';
    static protected $sort_field = 'sort';
    static protected $level_field = 'level';
    static protected $name_field = 'name';

    public function __construct($pid, $sort, $level) {
        if (!empty($pid)) self::$parent_field = $pid;
        if (!empty($sort)) self::$sort_field = $sort;
        if (!empty($level)) self::$level_field = $level;
        self::$tree = array();
        self::$arr = array();

    }

    //得到数据
    static public function list_to_tree($arr, $fid = 0) {
        self::$arr = $arr;
        self::chindAll($fid);
        return self::$tree;
    }

    //获得儿子
    static private function getChind($fid) {
        static $num = 0;
        $arr = array();
        foreach (self::$arr as $key => $row) {
            if ($row[self::$parent_field] == $fid) {
                $arr[] = $row;
                unset(self::$arr[$key]);
            }
        }
        if (!empty($arr)) {
            $num++;
            return self::sortArr($arr);
        } else {
            return null;
        }
    }

    //获取本人儿子孙子
    static private function chindAll($fid, $input = null) {
        static $n = 0;
        $n++;
        $arr = self::getChind($fid);
        if (!empty($arr)) {
            $count = count($arr);
            if (empty($input)) {
                for ($i = 0; $i < $count; $i++) {
                    self::$tree[$i] = $arr[$i];
                }
            } else {
                array_splice(self::$tree, $input, 0, $arr);
            }
            $num = 1;
            foreach (self::$tree as $row) {
                self::chindAll($row['id'], $num);
                $num++;
            }
        }
    }

    //对同辈进行排序
    static public function sortArr($arr) {
        foreach ($arr as $key => $row) {
            $id[$key] = $row['id'];
            $order[$key] = $row[self::$sort_field];
        }
        array_multisort($order, SORT_ASC, $id, SORT_ASC, $arr);
        return $arr;
    }

}

?>