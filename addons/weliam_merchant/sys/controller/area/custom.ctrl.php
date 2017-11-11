<?php
defined('IN_IA')or exit('Access Denied');
class custom{
    public function index(){
        global $_W, $_GPC;
        $categorys = pdo_getall(PDO_NAME . 'area', array('displayorder' => $_W['uniacid'], 'level' => 1));
        if(!empty($categorys)){
            foreach($categorys as $key => $value){
                $childrens = pdo_getall(PDO_NAME . 'area', array('displayorder' => $_W['uniacid'], 'pid' => $value['id']));
                $categorys[$key]['children'] = $childrens;
                foreach ($childrens as $k => $val){
                    $districts = pdo_getall(PDO_NAME . 'area', array('displayorder' => $_W['uniacid'], 'pid' => $val['id']));
                    $categorys[$key]['children'][$k]['children'] = $districts;
                }
            }
        }
        include wl_template('area/customarea');
    }
    public function edit(){
        global $_W, $_GPC;
        if(checksubmit('submit')){
            if(!empty($_GPC['parentid'])){
                $category['pid'] = intval($_GPC['parentid']);
                if($_GPC['level'] == 3){
                    $category['level'] = 3;
                }else{
                    $category['level'] = 2;
                }
            }else{
                $category['pid'] = 0;
                $category['level'] = 1;
            }
            $category['name'] = trim($_GPC['name']);
            $category['displayorder'] = $_W['uniacid'];
            $category['visible'] = intval($_GPC['visible']);
            if(!empty($_GPC['id'])){
                if(pdo_update(PDO_NAME . 'area', $category, array('id' => $_GPC['id'])))wl_message('保存成功', web_url('area/custom/index'), 'success');
            }else{
                if(pdo_insert(PDO_NAME . 'area', $category))wl_message('保存成功', web_url('area/custom/index'), 'success');
            }
            wl_message('保存失败', referer(), 'error');
        }
        if(!empty($_GPC['id']))$category = pdo_get(PDO_NAME . 'area', array('id' => $_GPC['id']));
        if(!empty($_GPC['parentid']))$pidname = pdo_getcolumn(PDO_NAME . 'area', array('id' => $_GPC['parentid']), 'name');
        include wl_template('area/customedit');
    }
    public function delete(){
        global $_W, $_GPC;
        $pid = pdo_getcolumn(PDO_NAME . 'area', array('id' => $_GPC['id']), 'pid');
        if(empty($pid)){
            pdo_delete(PDO_NAME . 'area', array('pid' => $_GPC['id']));
        }
        if(pdo_delete(PDO_NAME . 'area', array('id' => $_GPC['id'])))wl_message('删除成功', web_url('area/custom/index'), 'success');
        wl_message('删除失败', referer(), 'error');
    }
}
