<?php
defined('IN_IA')or exit('Access Denied');
class adv{
    public function index(){
        global $_W, $_GPC;
        $pindex = max(1, intval($_GPC['page']));
        $psize = 10;
        $adves = Dashboard :: getAllAdv($pindex-1, $psize);
        $advs = $adves['data'];
        $pager = pagination($adves['count'], $pindex, $psize);
        include wl_template('dashboard/advIndex');
    }
    public function edit(){
        global $_W, $_GPC;
        if(checksubmit('submit')){
            $adv = $_GPC['adv'];
            $adv['advname'] = trim($adv['advname']);
            $adv['displayorder'] = intval($adv['displayorder']);
            $adv['enabled'] = intval($_GPC['enabled']);
            if(!empty($_GPC['id'])){
                if(Dashboard :: editAdv($adv, $_GPC['id']))wl_message('保存成功', web_url('dashboard/adv/index'), 'success');
            }else{
                if(Dashboard :: editAdv($adv))wl_message('保存成功', web_url('dashboard/adv/index'), 'success');
            }
            wl_message('保存失败', referer(), 'error');
        }
        if(!empty($_GPC['id']))$adv = Dashboard :: getSingleAdv($_GPC['id']);
        include wl_template('dashboard/advEdit');
    }
    public function delete(){
        global $_W, $_GPC;
        if(Dashboard :: deleteAdv($_GPC['id']))wl_message('删除成功', web_url('dashboard/adv/index'), 'success');
        wl_message('删除失败', referer(), 'error');
    }
}
