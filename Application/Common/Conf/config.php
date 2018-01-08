<?php
return array(
    'LOAD_EXT_CONFIG'    => 'system',                  //加载扩展配置文件
    'LOAD_EXT_FILE'      => 'common',                        //加载公共函数
    'MODULE_ALLOW_LIST'  => array('Home', 'Admin', 'Mobile'),//设置访问列表
    'TMPL_STRIP_SPACE'   => false,                           //是否去除模板文件里面的html空格与换行
    'URL_MODEL'          => 2,                               //URL访问模式
    'ERROR_PAGE'         => './404.html',                    //错误定向页面
    /*注册新的命名空间*/
    'AUTOLOAD_NAMESPACE' => array(
        'Library'        => APP_PATH . 'Common/Library',     //定义公共库
        'Addon'          => APP_PATH . 'Common/Addon',       //定义公共插件库
    ),
    /*表单令牌*/
    'TOKEN_ON'           => false,                           //是否开启令牌验证 默认关闭
    'TOKEN_NAME'         => '__hash__',                      //令牌验证的表单隐藏字段名称，默认为__hash__
    'TOKEN_TYPE'         => 'md5',                           //令牌哈希验证规则 默认为MD5
    'TOKEN_RESET'        => true,                            //令牌验证出错后是否重置令牌 默认为true

    /*多语言切换*/
    'LANG_SWITCH_ON'     => true,                            //开启语言包功能
    'LANG_AUTO_DETECT'   => true,                            //自动侦测语言 开启多语言功能后有效
    'LANG_LIST'          => 'zh-cn',                         //允许切换的语言列表 用逗号分隔
    'VAR_LANGUAGE'       => 'l',                             //默认语言切换变量

    /*权限认证配置*/
    'USER_AUTH_ON'       => true,                            //是否开启认证
    /*无需验证模块*/
    'NOT_ACTION' => array(
        'Index/index',
        'Public/change_info',
        'Public/change_password',
        'Public/logout',
        'Clear/cache',
    ),
);