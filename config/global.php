<?php
global $config;

/** bind host */
$config['host'] = '0.0.0.0';

/** bind port */
$config['port'] = 20001;

/** 框架开到公网或外部的HTTP访问链接，通过 DataProvider::getFrameworkLink() 获取 */
$config['http_reverse_link'] = "http://127.0.0.1:".$config['port'];

/** 存放框架内文件数据的目录 */
$config['zm_data'] = WORKING_DIR.'/zm_data/';

/** 存放各个模块配置文件的目录 */
$config['config_dir'] = $config['zm_data'].'config/';

/** 存放崩溃和运行日志的目录 */
$config['crash_dir'] = $config['zm_data'].'crash/';

/** 对应swoole的server->set参数 */
$config['swoole'] = [
    'log_file' => $config['crash_dir'].'swoole_error.log',
    'worker_num' => 1,
    'dispatch_mode' => 2,
    'task_worker_num' => 0
];

/** MySQL数据库连接信息，host留空则启动时不创建sql连接池 */
$config['sql_config'] = [
    'sql_host' => '',
    'sql_port' => 3306,
    'sql_username' => 'name',
    'sql_database' => 'db_name',
    'sql_password' => '',
    'sql_enable_cache' => true,
    'sql_reset_cache' => '0300'
];

/** CQHTTP连接约定的token */
$config["access_token"] = "";

/** HTTP服务器固定请求头的返回 */
$config['http_header'] = [
    'X-Powered-By' => 'zhamao-framework',
    'Content-Type' => 'text/html; charset=utf-8'
];

/** HTTP服务器在指定状态码下回复的页面（默认） */
$config['http_default_code_page'] = [
    '404' => '404.html'
];

/** zhamao-framework在框架启动时初始化的atomic们 */
$config['init_atomics'] = [
    'in_count' => 0,        //消息接收message的统计数量
    'out_count' => 0,       //消息发送（调用send_*_msg的统计数量）
    'reload_time' => 0,     //调用reload功能统计数量
    'wait_msg_id' => 0,     //协程挂起id自增
    'info_level' => 0,      //终端显示的log等级
];

/** 自动保存的缓存保存时间（秒） */
$config['auto_save_interval'] = 900;

return $config;