<?php
/**
 * 合作加盟
 */
namespace app\admin\controller;

use think\Db;
use think\facade\Request;
use app\common\model\Comment as commentModel;
use think\Validate;

class Comment extends Common
{


    public function index()
    {
        $list = commentModel::where(['status' => 0])->order('id DESC')->paginate(20);
        $this->assign('page',$list->render());
        $this->assign('list', $list);
        return $this->fetch();
    }

    /**
     * 添加/回复留言
     */
    public function add(){
        if (request()->isPost()) {
            //新增处理
            $params = input('post.');
            $comment = new commentModel();
            $validate = new Validate([
                'title'=>'require|token',
                'content'=>'require'
            ]);
            if(!$validate->check($params)){
                return ['status' => 0, 'msg' => '添加失败,'.$validate->getError(), 'url' => ''];
            }
            if ($comment->data($params,true)->save()) {
                return ['status' => 1, 'msg' => '添加成功', 'url' => url('comment/index')];
            }else{
                return ['status' => 0, 'msg' => '添加失败', 'url' => ''];
            }
        }else{

            $id = input('param.id/d',0);
            $this->assign('item',commentModel::get($id));
            return $this->fetch();
        }
    }

    /**
     * 删除留言
     * @return [type] [description]
     */
    public function dele() {
        $id = input('param.id/d',0);

        $comment = new commentModel();
        //逻辑删除
        if ($comment->save(['status' => 1],['id' => $id])) {
            return ['status' => 1, 'msg' => '删除成功'];
        }else{
            return ['status' => 0, 'msg' => '删除失败'];
        }
    }




}
