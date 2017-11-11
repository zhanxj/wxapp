<?php
defined('IN_IA')or exit('Access Denied');
class merchant{
    public function index(){
        global $_W, $_GPC;
        $pindex = max(1, intval($_GPC['page']));
        $psize = 10;
        $where = array('uniacid' => $_W['uniacid'], 'status' => 2, 'aid' => $_W['aid']);
        if($_GPC['keyword']){
            $where['id^storename^mobile^realname^tel'] = $_GPC['keyword'];
        }
        $where['enabled'] = $_GPC['enabled'] = $_GPC['enabled'] != ''?$_GPC['enabled']:1;
        $storesData = Util :: getNumData("*", PDO_NAME . 'merchantdata', $where, 'id desc', $pindex, $psize, 1);
        $stores = $storesData[0];
        foreach($stores as $key => & $value){
            $value['logo'] = tomedia($value['logo']);
            if($value['endtime'] < time() && !empty($value['endtime']))pdo_update(PDO_NAME . 'merchantdata', array('enabled' => 3), array('uniacid' => $_W['uniacid'], 'id' => $value[id]));
            $value['onelevel'] = Util :: idSwitch('cateParentId', 'cateParentName', $value['onelevel']);
            $value['twolevel'] = Util :: idSwitch('cateChildId', 'cateChildName', $value['twolevel']);
        }
        $pager = $storesData[1];
        $status0 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename(PDO_NAME . 'merchantdata') . " WHERE enabled = 0 and uniacid={$_W['uniacid']} and status=2 and aid={$_W['aid']}");
        $status1 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename(PDO_NAME . 'merchantdata') . " WHERE enabled = 1 and uniacid={$_W['uniacid']} and status=2 and aid={$_W['aid']}");
        $status2 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename(PDO_NAME . 'merchantdata') . " WHERE enabled = 2 and uniacid={$_W['uniacid']} and status=2 and aid={$_W['aid']}");
        $status3 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename(PDO_NAME . 'merchantdata') . " WHERE enabled = 3 and uniacid={$_W['uniacid']} and status=2 and aid={$_W['aid']}");
        $status4 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename(PDO_NAME . 'merchantdata') . " WHERE enabled = 4 and uniacid={$_W['uniacid']} and status=2 and aid={$_W['aid']}");
        include wl_template('store/userIndex');
    }
    public function edit(){
        global $_W, $_GPC;
        $id = intval($_GPC['id']);
        $categoryes = pdo_getall(PDO_NAME . 'category_store', array('uniacid' => $_W['uniacid'], 'aid' => $_W['aid']));
        if(empty($categoryes))wl_message("请先添加商家类别!", web_url('store/category/Edit'));
        $allgroups = Store :: getAllGroup(0, 100, 1);
        $allgroup = $allgroups['data'];
        if(empty($allgroup))wl_message("请先添加商户分组!", web_url('store/group/edit'));
        if(checksubmit('submit')){
            $uid = intval($_GPC['uid']);
            $member = Member :: getMemberByMid($_GPC['openid'], 'id');
            $register = $_GPC['register'];
            $register['enabled'] = intval($_GPC['enabled']);
            $register['location'] = Util :: Convert_BD09_To_GCJ02($register['location']['lat'], $register['location']['lng']);
            $register['location'] = serialize($register['location']);
            $register['storename'] = trim($register['storename']);
            $register['endtime'] = strtotime($register['endtime']);
            $register['introduction'] = htmlspecialchars_decode($register['introduction']);
            $register['onelevel'] = intval($_GPC['category']['parentid']);
            $register['twolevel'] = intval($_GPC['category']['childid']);
            $register['uniacid'] = $_W['uniacid'];
            $register['aid'] = $_W['aid'];
            $user = $_GPC['user'];
            $user['name'] = $register['realname'];
            $user['mobile'] = $register['tel'];
            $user['mid'] = $member['id'];
            $user['enabled'] = 1;
            $user['uniacid'] = $_W['uniacid'];
            $user['aid'] = $_W['aid'];
            $registerdate = $_GPC['registerdate'];
            $register['storehours'] = serialize($registerdate);
            if($id){
                $result = Store :: registerEditData($register, $id);
                $result = Store :: registerEditUser($user, $uid);
            }else{
                $register['aid'] = $_W['aid'];
                $register['status'] = 2;
                $register['createtime'] = time();
                $uid = Store :: registerEditData($register);
                $user['storeid'] = $uid;
                $user['ismain'] = 1;
                $user['status'] = 2;
                $user['createtime'] = time();
                $result = Store :: registerEditUser($user);
            }
            if($result){
                wl_message('商家信息保存成功', web_url('store/merchant/index', array('enabled' => $register['enabled'])), 'success');
            }else{
                wl_message('商家信息保存失败，请重试', web_url('store/merchant/index', array('enabled' => $register['enabled'])), 'success');
            }
        }
        if (!empty($categoryes)){
            $parent = $children = array();
            foreach ($categoryes as $cid => $cate){
                if (!empty($cate['parentid'])){
                    $children[$cate['parentid']][] = $cate;
                }else{
                    $parent[$cate['id']] = $cate;
                }
            }
        }
        $register = Store :: getSingleStore($id);
        $register['onelevelname'] = Util :: idSwitch('cateParentId', 'cateParentName', $register['onelevel']);
        $register['twolevelname'] = Util :: idSwitch('cateChildId', 'cateChildName', $register['twolevel']);
        $register['member'] = Store :: getSingleRegister(array('uniacid' => $_W['uniacid'], 'storeid' => $id, 'ismain' => 1));
        $member = Member :: getMemberByMid($register['member']['mid'], array('id', 'nickname', 'openid'));
        $register['location'] = unserialize($register['location']);
        $register['location'] = Util :: Convert_GCJ02_To_BD09($register['location']['lat'], $register['location']['lng']);
        $register['storehours'] = unserialize($register['storehours']);
        $register['endtime'] = !empty($register['endtime'])?$register['endtime']:time() + 31536000;
        $allArea = json_encode(Area :: get_all_in_use());
        include wl_template('store/userEdit');
    }
    public function delete(){
        global $_W, $_GPC;
        if(pdo_update(PDO_NAME . 'merchantdata', array('enabled' => 4), array('id' => $_GPC['id'])))wl_message('删除成功', web_url('store/merchant/index'), 'success');
        wl_message('删除失败', referer(), 'error');
    }
    public function sureDelete(){
        global $_W, $_GPC;
        if(pdo_delete(PDO_NAME . 'merchantdata', array('id' => $_GPC['id']))){
            pdo_delete(PDO_NAME . 'merchantuser', array('uniacid' => $_W['uniacid'], 'storeid' => $_GPC['id']));
            wl_message('彻底删除成功', web_url('store/merchant/index'), 'success');
        }
        wl_message('删除失败', referer(), 'error');
    }
    function account(){
        global $_W, $_GPC;
        $id = $_GPC['id'];
        $m = SingleMerchant :: getSingleMerchant($id, 'logo,storename,percent');
        $_GPC['type'] = $_GPC['type']?$_GPC['type']:'moneyRecord';
        if($_GPC['type'] == 'moneyRecord'){
            $pindex = max(1, intval($_GPC['page']));
            $psize = 15;
            $moneyRecordData = SingleMerchant :: getMoneyRecord($id, $pindex, $psize, 1);
            $moneyRecord = $moneyRecordData[0];
            $pager = $moneyRecordData[1];
            foreach($moneyRecord as & $item){
                if($item['orderid'])$item['order'] = Rush :: getSingleOrder($item['orderid'], '*');
            }
        }
        if($_GPC['type'] == 'settlementRecord'){
            $listData = Util :: getNumData("*", PDO_NAME . 'settlement_record', array('sid' => $id));
            $list = $listData[0];
        }
        include wl_template('store/account');
    }
    function keeper(){
        global $_W, $_GPC;
        $id = intval($_GPC['id']);
        $register = Store :: getSingleStore($id);
        $register['onelevel'] = Util :: idSwitch('cateParentId', 'cateParentName', $register['onelevel']);
        $register['twolevel'] = Util :: idSwitch('cateChildId', 'cateChildName', $register['twolevel']);
        $where['storeid'] = $id;
        $keeperData = Util :: getNumData("*", PDO_NAME . 'merchantuser', $where, 'ismain asc');
        $keeper = $keeperData[0];
        foreach($keeper as $key => & $value){
            $value['member'] = Member :: getMemberByMid($value['mid']);
        }
        include wl_template('store/userEdit');
    }
}
