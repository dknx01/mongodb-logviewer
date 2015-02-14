<?php
/**
 * some typically html doctypes
 * 
 * PHP version >=5.3
 * 
 * @package Mvc\View
 * @author  dknx01 <e.witthauer@gmail.com>
 */
namespace Mvc\View;

class DocTypes
{
    /**
     * @var string function name for HTML 4.01 Transitional doctype
     */
    const HTML401TRANSITIONAL = 'html401Transitional';
    /**
     * @var string function name for HTML 4.01 Strict doctype
     */
    const HTML401STRICT = 'html401Strict';
    /**
     * @var string function name for HTML 5 doctype
     */
    const HTML5 = 'html5';
    /**
     * @var string function name for XHTML 1.0 Transitional doctype
     */
    const XHTML10TRANSITIONAL = 'xhtml10Transitional';
    /**
     * @var string function name for XHTML 1.0 Stract doctype
     */
    const XHTML10STRICT = 'xhtml10Strict';
    /**
     * @var string function name for XHTML 1.1 doctype
     */
    const XHTML11 = 'xhtml11';
    /**
     * doctype definition for HTML 4.01 Transitional
     * 
     * @return string
     */
    static function html401Transitional()
    {
        return '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">' . PHP_EOL;
    }
    /**
     * doctype definition for HTML 4.01 Strict
     * 
     * @return string
     */
    static function html401Strict()
    {
        return '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">' . PHP_EOL;
    }
    /**
     * doctype definition for HTML 5
     * 
     * @return string
     */
    static function html5()
    {
        return '<!DOCTYPE html>' . PHP_EOL;
    }
    /**
     * doctype definition for XHTML 1.0 Transitional
     * 
     * @return string
     */
    static function xhtml10Transitional()
    {
        return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">' . PHP_EOL;
    }
    /**
     * doctype definition for XHTML 1.0 Strict
     * 
     * @return string
     */
    static function xhtml10Strict()
    {
        return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">' . PHP_EOL;
    }
    /**
     * doctype definition for XHTML 1.1
     * 
     * @return string
     */
    static function xhtml11()
    {
        return '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">' . PHP_EOL;
    }
}
