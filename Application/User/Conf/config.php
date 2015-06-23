<?php

/**
 * UCenter客户端配置文件
 * 注意：该配置文件请使用常量方式定义
 */

define('UC_APP_ID', 1); //应用ID
define('UC_API_TYPE', 'Model'); //可选值 Model / Service
define('UC_AUTH_KEY', '\Cu8nLv=VJcZ|6hNT@XD*+9;2>7P_]}^wa5-#%m`'); //加密KEY
define('UC_DB_DSN', 'mysql://root:yekz@localhost:3306/yekezhon_56daxue'); // 数据库连接，使用Model方式调用API必须配置此项
define('UC_TABLE_PREFIX', 'shop_'); // 数据表前缀，使用Model方式调用API必须配置此项
// define('UC_DB_DSN', 'mysql://yekezhon_yekz:15008348002@localhost:3306/yekezhon_56daxue'); // 数据库连接，使用Model方式调用API必须配置此项
