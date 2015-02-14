<?php
/**
 * some prepare work for the mvc application
 * @author  dknx01 <e.witthauer@gmail.com>
 * @package Prepare
 */

/**
 * check if all needed constants are set
 * @throws Exception
 */
function checkConstants()
{
    if (!defined('APPDIR')) {
        throw new Exception('APPDIR not defined.');
        exit;
    }
    if (!defined('ROOTDIR')) {
        throw new Exception('ROOTDIR not defined.');
        exit;
    }
}

checkConstants();
if (PHP_SAPI != 'cli' && $_SERVER['APP_ENV'] != 'online') {
    require_once ROOTDIR . '/Lib/Mvc/php_error.php';
    $options = array('background_text' => 'MVC', 'application_root' => ROOTDIR);
    \php_error\reportErrors($options);
}
