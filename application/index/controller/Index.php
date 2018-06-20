<?php
namespace app\index\controller;

use think\Db;
use think\facade\Config;

use think\View;

class Index extends Common
{

    public function index()
    {
        $template = 'template/' . request()->module() . '/'. $this->theme .'/Index_index.html';
        return $this->fetch($template);
    }
    
}
