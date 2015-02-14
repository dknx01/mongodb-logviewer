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

$short = 'c::a::q::';
$long = array('controller::', 'action::', 'query::');
$cliArguments = getopt($short, $long);
require_once ROOTDIR .  '/Lib/Mvc/System.php';
\Mvc\System::getInstance()->set('cliArgs', $cliArguments);
\Mvc\System::getInstance()->set('isCli', true);
