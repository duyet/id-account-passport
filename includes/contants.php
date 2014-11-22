<?php
/**
* @ Project: ID Account System 1.5.0
* @ Author: Yplitgroup (c)2012
* @ Email: yplitgroup@gmail.com
* @ Website: http://lemon9x.com 
* @ Phone: 0166.26.26.009
* @ Project ID: 876609683c4c7e392848e94d9f62e149
**/

// ############### CHECK ##############
if( !defined('IS_MAIN') ) die(" Stop!!! ");

// ############### MAIN ###############
define('IS_INCLUDE_CONTANTS', true);
if( !defined( 'TIMENOW' ) ) define( 'TIMENOW', time() );

// Ten file cau hinh
define( 'CONFIG_FILE', 'config.php' );

// Table Prefix cua database. Ban vui long xem trong file config.php cua Forum
define( 'TABLE_PREFIX', $config['table_prefix'] );

// Cookie salt. Ban co the xem trong file config.php cua Forum
define( 'COOKIE_SALT', '' );

// Time het han Cookie. Vui long khong sua muc nay. ( 31536000 = 1 nam )
define( 'COOKIE_LIVE_TIME', TIMENOW + 31536000 );

// Thu muc Tmp
define( 'YPLITGROUP_TMP_DIR', 'tmp' );

// Thu muc chua file Logs cua trong Contact
define( 'YPLITGROUP_CONTACT_LOGS_DIR', 'tmp/contact_logs' );

// Define Type Input
define('TYPE_BOOL',     1); // force boolean
define('TYPE_INT',      2); // force integer
define('TYPE_UINT',     3); // force unsigned integer
define('TYPE_NUM',      4); // force number
define('TYPE_UNUM',     5); // force unsigned number
define('TYPE_UNIXTIME', 6); // force unix datestamp (unsigned integer)
define('TYPE_STR',      7); // force trimmed string
define('TYPE_NOTRIM',   8); // force string - no trim
define('TYPE_NOHTML',   9); // force trimmed string with HTML made safe
define('TYPE_ARRAY',   10); // force array
define('TYPE_FILE',    11); // force file
define('TYPE_BINARY',  12); // force binary string
define('TYPE_NOHTMLCOND', 13); // force trimmed string with HTML made safe if determined to be unsafe