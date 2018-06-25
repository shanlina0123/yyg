<?php
namespace app\index\controller;

use think\Db;
use think\facade\Config;

use think\View;

class Index extends Common
{

    public function index()
    {
        $cat_info["ename"]="index";
        $template = 'template/' . request()->module() . '/'. $this->theme .'/Index_index.html';
        $this->assign('cid',0);
        $this->assign('cate', $cat_info);
        $this->assign('title', "");
        return $this->fetch($template);
    }
    
}
