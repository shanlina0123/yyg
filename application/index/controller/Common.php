<?php

namespace app\index\controller;

use app\common\model\Category;
use think\Controller;
use think\Db;
use think\facade\Request;
use think\facade\Session;
use think\facade\Config;
use app\common\model\System;
class Common extends Controller
{
    /*
     * 数据表前缀
     */
    protected $prefix = '';

    /*
     * 网站主题
     */
    protected $theme = 'default';


    public function initialize()
    {

        parent::initialize(); // TODO: Change the autogenerated stub
        //站点是否已经关闭
        if (get_system_value('site_closed') == 1) {
            echo "<h1 align='center'>站点已临时关闭！</h1>";exit;
        }
        if (Request::isMobile()) $this->redirect('mobile/index/index');

        $this->prefix = Config('database.prefix');
        $this->theme = get_system_value('site_theme');
        //查询文章分类
        $cate = Category::get(['modelid' => 1, 'status' => 1]);
        $this->assign('rcate', $cate);


    }

    /*
     * 空操作
     */
    public function _empty()
    {
        abort(404,'页面不存在');
    }
}
