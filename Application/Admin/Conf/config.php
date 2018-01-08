<?php
return array(
    'LOAD_EXT_CONFIG'      => 'mysql',//加载扩展配置文件
    'URL_CASE_INSENSITIVE' => true,// 默认false 表示URL区分大小写 true则表示不区分大小写
    /*模板替换*/
    'TMPL_PARSE_STRING'    =>array(
        '__JS__'           => __ROOT__.'/Public/'.MODULE_NAME.'/js',
        '__CSS__'          => __ROOT__.'/Public/'.MODULE_NAME.'/css',
        '__IMAGES__'       => __ROOT__.'/Public/'.MODULE_NAME.'/images',
        '__PLUGIN__'       => __ROOT__.'/Public/Plugin',
        '__COMMON__'       => __ROOT__.'/Public/Common',
    ),
    'CONF_WRITE_PATH'      =>CONF_PATH.'system.php',//系统配置文件路径
);