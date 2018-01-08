<?php
namespace Admin\Controller;
use Think\Controller;

class UploadController extends Controller {
	protected $ext_arr = array();
	protected $size_arr = array();

	function _initialize() {
		defined('UPLOAD_PATH') or define('UPLOAD_PATH', '');
		$ext_arr = array(
			'image' => explode('|', C('UPLOAD_IMG_EXTS')),
			'flash' => array('swf', 'flv'),
			'media' => array('swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb'),
			'file' => explode('|', C('UPLOAD_FILE_EXTS'))
		);
		$size_arr = array(
			'image' => C('UPLOAD_IMG_SIZE'),
			'flash' => 3,
			'media' => 3,
			'file' => C('UPLOAD_FILE_SIZE')
		);
		$this->ext_arr = $ext_arr;
		$this->size_arr = $size_arr;
	}

	/**
	 * +----------------------------------------------------------
	 * 调用上传
	 * +----------------------------------------------------------
	 */
	function index() {
		$dir_name = empty($_GET['dir']) ? 'image' : trim($_GET['dir']);
		$uploadPath = '/Uploads/' . $dir_name . '/';
		$returnPath = UPLOAD_PATH . '/Uploads/' . $dir_name . '/';    //上传文件返回虚拟路径
		$json = new \Library\ServicesJson();
		$upload = new \Think\Upload();
		//实例化上传类
		$upload->maxSize = $this->size_arr[$dir_name] * 1048576;// 设置附件上传大小
		$upload->autoSub = true;
		$upload->rootPath = SITE_PATH . $uploadPath;    //上传文件实际保存路径
		$upload->exts = $this->ext_arr[$dir_name]; // 设置附件上传类型
		$info = $upload->upload();
		if (!$info) {
			// 上传错误提示错误信息
			$err = $upload->getError();
			die($json->encode(array('error' => 1, 'message' => $err)));
		} else {
			// 上传成功 获取上传文件信息
			$file_info = array();
			foreach ($info as $k => $v) {
				foreach ($v as $kk => $vv) {
					$file_info[$kk] = $vv;
				}
			}
			$url = $returnPath . $file_info['savepath'] . $file_info['savename'];
			if (in_array($file_info['ext'], $this->ext_arr['image'])) {
				$img_info = getimagesize(SITE_PATH . $url);
				$data['is_img'] = 1;
				$data['img_w'] = $img_info[0];//图片宽度
				$data['img_h'] = $img_info[1];//图片高度
			} else {
				$data['is_img'] = 0;
			}
			$data['original_name'] = $file_info['name'];
			$data['file_name'] = $file_info['savename'];
			$data['file_ext'] = $file_info['ext'];
			$data['file_size'] = $file_info['size'];
			$data['file_sizes'] = byte_format($file_info['size']);
			$data['file_md5'] = $file_info['md5'];
			$data['file_sha1'] = $file_info['sha1'];
			$data['file_url'] = $url;
			$data['create_time'] = date('Y-m-d H:i:s');
			M('File')->add($data);
			die($json->encode(array('error' => 0, 'url' => $url)));
		}
	}

	/**
	 * +----------------------------------------------------------
	 * 文件空间列表
	 * +----------------------------------------------------------
	 * @return number
	+----------------------------------------------------------
	 */
	public function fileList() {
		$root_path = SITE_PATH . '/Uploads/';
		$root_url = '/Uploads/';
		$ext_arr = array('gif', 'jpg', 'jpeg', 'png', 'bmp');
		$dir_name = empty($_GET['dir']) ? '' : trim($_GET['dir']);
		if (!in_array($dir_name, array('', 'image', 'flash', 'media', 'file'))) {
			echo "Invalid Directory name.";
			exit;
		}
		if ($dir_name !== '') {
			$root_path .= $dir_name . "/";
			$root_url .= $dir_name . "/";
			if (!file_exists($root_path)) {
				mkdir($root_path);
			}
		}
		if (empty($_GET['path'])) {
			$current_path = realpath($root_path) . '/';
			$current_url = $root_url;
			$current_dir_path = '';
			$moveup_dir_path = '';
		} else {
			$current_path = realpath($root_path) . '/' . $_GET['path'];
			$current_url = $root_url . $_GET['path'];
			$current_dir_path = $_GET['path'];
			$moveup_dir_path = preg_replace('/(.*?)[^\/]+\/$/', '$1', $current_dir_path);
		}
		echo realpath($root_path);
		//排序形式，name or size or type
		$order = empty($_GET['order']) ? 'name' : strtolower($_GET['order']);
		//不允许使用..移动到上一级目录
		if (preg_match('/\.\./', $current_path)) {
			echo 'Access is not allowed.';
			exit;
		}
		//最后一个字符不是/
		if (!preg_match('/\/$/', $current_path)) {
			echo 'Parameter is not valid.';
			exit;
		}
		//目录不存在或不是目录
		if (!file_exists($current_path) || !is_dir($current_path)) {
			echo '目录不存在或不是目录。';
			exit;
		}

		$file_list = $this->getFileList($current_path, $ext_arr);

		$result = array();
		//相对于根目录的上一级目录
		$result['moveup_dir_path'] = $moveup_dir_path;
		//相对于根目录的当前目录
		$result['current_dir_path'] = $current_dir_path;
		//当前目录的URL
		$result['current_url'] = $current_url;
		//文件数
		$result['total_count'] = count($file_list);
		//文件列表数组
		$result['file_list'] = $file_list;
		//输出JSON字符串
		//header('Content-type: application/json; charset=UTF-8');

		$ServicesJson = new \Library\ServicesJson();
		echo $ServicesJson->encode($result);
		die;
	}

	/**
	 * +----------------------------------------------------------
	 * 获取文件列表
	 * +----------------------------------------------------------
	 * @param  $current_path 路径
	+----------------------------------------------------------
	 * @param  $ext_arr 图片后缀
	+----------------------------------------------------------
	 * @return number|Ambigous <multitype:, string>
	 * +----------------------------------------------------------
	 */
	function getFileList($current_path, $ext_arr) {
		//遍历目录取得文件信息
		$file_list = array();
		if ($handle = opendir($current_path)) {
			$i = 0;
			while (false !== ($filename = readdir($handle))) {
				if ($filename{0} == '.') continue;
				$file = $current_path . $filename;
				if (is_dir($file)) {
					$file_list[$i]['is_dir'] = true; //是否文件夹
					$file_list[$i]['has_file'] = (count(scandir($file)) > 2); //文件夹是否包含文件
					$file_list[$i]['filesize'] = 0; //文件大小
					$file_list[$i]['is_photo'] = false; //是否图片
					$file_list[$i]['filetype'] = ''; //文件类别，用扩展名判断
				} else {
					$file_list[$i]['is_dir'] = false;
					$file_list[$i]['has_file'] = false;
					$file_list[$i]['filesize'] = byte_format(filesize($file));
					$file_list[$i]['dir_path'] = '';
					$file_ext = strtolower(array_pop(explode('.', trim($file))));
					$file_list[$i]['is_photo'] = in_array($file_ext, $ext_arr);
					$file_list[$i]['filetype'] = $file_ext;
				}
				$file_list[$i]['filename'] = to_utf($filename); //文件名，包含扩展名
				$file_list[$i]['datetime'] = date('Y-m-d H:i:s', filemtime($file)); //文件最后修改时间
				$i++;
			}
			closedir($handle);
		}
		//排序
		function cmp_func($a, $b) {
			global $order;
			if ($a['is_dir'] && !$b['is_dir']) {
				return -1;
			} else if (!$a['is_dir'] && $b['is_dir']) {
				return 1;
			} else {
				if ($order == 'size') {
					if ($a['filesize'] > $b['filesize']) {
						return 1;
					} else if ($a['filesize'] < $b['filesize']) {
						return -1;
					} else {
						return 0;
					}
				} else if ($order == 'type') {
					return strcmp($a['filetype'], $b['filetype']);
				} else {
					return strcmp($a['filename'], $b['filename']);
				}
			}
		}

		usort($file_list, 'cmp_func');
		return $file_list;
	}
}