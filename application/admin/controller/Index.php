<?php

namespace app\admin\controller;

use app\common\model\System;
use think\facade\Config;
use think\Controller;
use think\Db;
use think\Exception;
use think\facade\Env;
use think\facade\Session;
use think\facade\Request;
use think\facade\Cache;

class Index extends Common
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $userid = Session::get('userinfo.id');
        $this->assign('userid', $userid);
        return $this->fetch();
    }

    /**
     * 系统设置
     */
    function system()
    {
        if (!request()->isAjax()) {
            //获取系统设置项
            $list = System::all();
            $slist = [];
            //获取pc端主题
            $theme_list = scandir('template/index');
            foreach ($theme_list as $k => $vo) {
                if ($vo == '.' || $vo == '..') {
                    unset($theme_list[$k]);
                }
            }
            //获取pc端主题
            $theme_mobile_list = scandir('template/mobile');
            foreach ($theme_mobile_list as $k => $vo) {
                if ($vo == '.' || $vo == '..') {
                    unset($theme_mobile_list[$k]);
                }
            }
            foreach ($list as $key => $item) {
                list($pk, $ck) = explode('_', $item['name']);
                $slist[$pk][$ck] = ['name' => $item['name'], 'title' => $item['title'], 'tvalue' => $item['tvalue'], 'value' => $item['value'], 'remark' => $item['remark']];
                //如果select类型
                switch ($item['name']) {
                    case 'site_theme':
                        $slist[$pk][$ck]['svalue'] = $theme_list;
                        break;
                    case 'site_mobile_theme':
                        $slist[$pk][$ck]['svalue'] = $theme_mobile_list;
                        break;
                    case 'site_language':
                        $slist[$pk][$ck]['svalue'] = array('zh_cn');
                        break;
                }
            }
            $this->assign('slist', $slist);
            return $this->fetch();
        } else {
            //插入、更新操作
            try {
                $params = input('post.');
                foreach ($params as $name => $value) {
                    if($name=="pic_url")
                    {
                        $name="site_img";
                        $value=$value[0];
                    }
                    $flag = Db::name('system')->where('name', $name)->update(['value' => $value]);
                }
            } catch (Exception $e) {
                exit(json_encode(['status' => 0, 'msg' => '更新操作异常，请稍后重试', 'url' => '']));
            }
            exit(json_encode(['status' => 1, 'msg' => '更新成功', 'url' => '']));
        }

    }

    /**
     * 清除缓存
     */
    function clear()
    {
        //临时文件
        $temp = Env::get('runtime_path') . '/temp/';
        if (file_exists($temp)) {
            if ($handle = opendir($temp)) {
                while (false !== ($file = readdir($handle))) {
                    if ($file != "." && $file != "..") {
                        $flag = unlink($temp . $file);
                    }
                }
                closedir($handle);
            }

            if (!$flag) {
                return ['status' => 0, 'msg' => '缓存清除失败！'];
            }
        }
        return ['status' => 1, 'msg' => '缓存清除成功！'];
    }

}
