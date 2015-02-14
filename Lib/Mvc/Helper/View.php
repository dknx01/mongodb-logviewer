<?php
/**
 *
 * @package Mvc\Helper
 * @author  dknx01 <e.witthauer@gmail.com>
 */

namespace Mvc\Helper;


class View
{
    public function render($path)
    {
        $return = '';
        ob_start();
        include_once APPDIR . '/' . $path;
        $return = ob_get_contents();
        ob_end_clean();
        return $return;
    }
}