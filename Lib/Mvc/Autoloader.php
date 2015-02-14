<?php
/**
 * all needed autoloader
 * @author  dknx01 <e.witthauer@gmail.com>
 * @package Autoloader
 */

/**
 * application autoloader
 * @param string $classname
 */
function AppAutoloader($classname)
{
    if (strpos($classname, '\\')) {
        $appdir = realpath(APPDIR . '/..');
        $classname = ltrim($classname, '\\');
        $filename = $appdir . '/' . str_replace(array('\\', '_'), '/', $classname);
    } else {
        $filename  = APPDIR . '/' . str_replace('_', '/', $classname);
    }
    if (file_exists($filename . '.php')) {
        require_once $filename . '.php';
    }
}

/**
 * mvc autoloader
 * @param string $classname
 */
function MvcAutoloader($classname)
{
    if (strpos($classname, '\\')) {
        $classname = ltrim($classname, '\\');
        $filename = realpath(__DIR__ . '/..') . '/' . str_replace(array('\\', '_'), '/', $classname);
    } else {
        $filename  = realpath(__DIR__)  . '/' . str_replace('_', '/', $classname);
    }
    if (file_exists($filename . '.php')) {
        require_once $filename . '.php';
    }
}
/**
 * external Libs autoloader
 * @param string $classname
 */
function LibAutoloader($classname)
{
    if (strpos($classname, '\\')) {
        $filename = ROOTDIR . '/Lib/Libs/' . str_replace(array('\\', '_'), '/', $classname);
    } {
        $filename  = ROOTDIR  . '/Lib/Libs/' . str_replace('_', '/', $classname);
    }
    if (file_exists($filename . '.php')) {
        require_once $filename . '.php';
    }
}
spl_autoload_extensions('.php'); // comma-separated list
spl_autoload_register('MvcAutoloader');
spl_autoload_register('AppAutoloader');
spl_autoload_register('LibAutoloader');
