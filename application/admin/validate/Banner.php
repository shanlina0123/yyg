<?php
/**
 * Created by PhpStorm.
 * User: nango
 * Date: 2018/1/3
 * Time: 16:11
 */

namespace app\admin\validate;

use think\Validate;

class Banner extends Validate {
    protected $rule = [
        'cid' => 'require|token',
    ];

    protected $message = [
        'cid.require' => '栏目不能为空',
    ];
}