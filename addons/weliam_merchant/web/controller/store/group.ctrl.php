<?php
defined('IN_IA')or exit('Access Denied');
class group{
    public function index(){
        global $_W, $_GPC;
        $pindex = max(1, intval($_GPC['page']));
        $psize = 10;
        $groupes = Store :: getAllGroup($pindex-1, $psize);
        $groups = $groupes['data'];
        $pager = pagination($agents['count'], $pindex, $psize);
        include wl_template('store/sgroupIndex');
    }
    public function edit(){
        global $_W, $_GPC;
        if(checksubmit('submit')){
            $group = $_GPC['group'];
            $group['createtime'] = time();
            $group['name'] = trim($group['name']);
            $group['enabled'] = $_GPC['enabled'];
            $group['isdefault'] = $_GPC['isdefault'];
            $group['package'] = $group['package'];
            if(!empty($_GPC['id'])){
                if(Store :: editGroup($group, $_GPC['id']))wl_message('保存成功', web_url('store/group/index'), 'success');
            }else{
                if(Store :: editGroup($group))wl_message('保存成功', web_url('store/group/index'), 'success');
            }
            wl_message('保存失败', referer(), 'error');
        }
        if(!empty($_GPC['id']))$group = Store :: getSingleGroup($_GPC['id']);
        include wl_template('store/sgroupEdit');
    }
    public function delete(){
        global $_W, $_GPC;
        if(Store :: deleteGroup($_GPC['id']))wl_message('删除成功', web_url('store/group/index'), 'success');
        wl_message('删除失败', referer(), 'error');
    }
}
