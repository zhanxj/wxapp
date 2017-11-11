<?php
defined('IN_IA')or exit('Access Denied');
class home{
    public function index(){
        global $_W, $_GPC;
        $pagetitle = !empty($_W['wlsetting']['base']['name'])? '首页 - ' . $_W['wlsetting']['base']['name'] : '首页';
        $data = Dashboard :: get_app_data();
        $area = Area :: get_all_area(1);
        $halfcardbase = Setting :: agentsetting_read('halfcard');
        include wl_template('dashboard/index');
    }
    public function noticelist(){
        global $_W, $_GPC;
        $pagetitle = !empty($_W['wlsetting']['base']['name'])? '消息列表 - ' . $_W['wlsetting']['base']['name'] : '消息列表';
        $notice = pdo_fetchall("SELECT * FROM " . tablename(PDO_NAME . 'notice') . " WHERE enabled = 1 and uniacid = '{$_W['uniacid']}' and aid = {$_W['aid']} ORDER BY id DESC");
        include wl_template('dashboard/noticelist');
    }
    public function noticedetail(){
        global $_W, $_GPC;
        $pagetitle = !empty($_W['wlsetting']['base']['name'])? '公告详情 - ' . $_W['wlsetting']['base']['name'] : '公告详情';
        $id = intval($_GPC['id']);
        if(empty($id)){
            wl_message('缺少关键参数');
        }
        $notice = Dashboard :: getSingleNotice($id);
        include wl_template('dashboard/noticedetail');
    }
}
