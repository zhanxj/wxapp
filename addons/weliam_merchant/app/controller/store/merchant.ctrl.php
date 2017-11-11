<?php
defined('IN_IA')or exit('Access Denied');
class merchant{
    public function index(){
        global $_W, $_GPC;
        $pagetitle = !empty($_W['wlsetting']['base']['name'])? '商户列表 - ' . $_W['wlsetting']['base']['name'] : '商户列表';
        if(!empty($_GPC['cid'])){
            $cid = intval($_GPC['cid']);
            $cname = pdo_getcolumn(PDO_NAME . "category_store", array('id' => $cid), 'name');
        }
        if(!empty($_GPC['pid'])){
            $pid = intval($_GPC['pid']);
            $cname = pdo_getcolumn(PDO_NAME . "category_store", array('id' => $pid), 'name');
        }
        $keyword = $_GPC['keyword'];
        include wl_template('store/index');
    }
    public function detail(){
        global $_W, $_GPC;
        $pagetitle = !empty($_W['wlsetting']['base']['name'])? '商户详情 - ' . $_W['wlsetting']['base']['name'] : '商户详情';
        $id = intval($_GPC['id']);
        $store = Store :: getSingleStore($id);
        $storehours = unserialize($store['storehours']);
        $location = unserialize($store['location']);
        $store['storehours'] = $storehours['startTime'] . "—" . $storehours['endTime'] . "&nbsp;营业";
        $collects = pdo_get(PDO_NAME . 'collect', array('uniacid' => $_W['uniacid'], 'mid' => $_W['mid'], 'storeid' => $id), 'id');
        $active = Rush :: getNumActive('*', array('sid' => $id, '#status#' => "(1,2)"), 'id DESC');
        foreach($active[0] as $key => & $v){
            $v['a'] = app_url('rush/home/detail', array('id' => $v['id']));
            $v['thumb'] = tomedia($v['thumb']);
        }
        $active = $active[0];
        $halfcardset = Setting :: agentsetting_read('halfcard');
        if($halfcardset['status']){
            $today = strtotime(date('Y-m-d', time()));
            $halfcard = pdo_get(PDO_NAME . 'halfcardlist', array('uniacid' => $_W['uniacid'], 'merchantid' => $id, 'status' => 1), array('id', 'title', 'datestatus', 'week', 'day'));
            if(!empty($halfcard)){
                if($halfcard['datestatus'] == 1){
                    $week = date('w');
                    if($week == 0)$week = 7;
                    $hweek = unserialize($halfcard['week']);
                    foreach ($hweek as $key => $value){
                        if($value >= $week){
                            $needweek = $value;
                            break;
                        }
                    }
                    if(empty($needweek))$needweek = $hweek[0];
                    if($needweek >= $week){
                        $needtime = $today + abs($needweek - $week) * 24 * 60 * 60;
                    }else{
                        $needtime = $today + abs(($needweek + 7) - $week) * 24 * 60 * 60;
                    }
                    $halfcard['usetime'] = date('Y-m-d', $needtime);
                }else{
                    $day = date('j');
                    $hday = unserialize($halfcard['day']);
                    foreach ($hday as $key => $value){
                        if($value >= $day){
                            $needday = $value;
                            break;
                        }
                    }
                    if(empty($needday))$needday = $hday[0];
                    if($needday >= $day){
                        $needtime = $today + abs($needday - $day) * 24 * 60 * 60;
                    }else{
                        $needtime = mktime(0, 0, 0, date('m') + 1, 1, date('Y')) + abs($needday - 1) * 24 * 60 * 60;
                    }
                    $halfcard['usetime'] = date('Y-m-d', $needtime);
                }
                if($needtime < time()){
                    $flag = 0;
                }else{
                    $flag = ceil(($needtime - time()) / (24 * 3600));
                }
                $halfcard['times'] = pdo_fetchcolumn("select count(id) from" . tablename(PDO_NAME . 'halfcardrecord') . "where uniacid=:uniacid and merchantid=:merchantid and status=:status ", array(':uniacid' => $_W['uniacid'], ':merchantid' => $id, ':status' => 2));
                $halfcard['url'] = app_url('halfcard/halfcard_app/halfcarddetail', array('id' => $halfcard['id'], 'flag' => $flag));
            }
        }
        $scoupon = pdo_getall(PDO_NAME . 'couponlist', array('merchantid' => $id, 'uniacid' => $_W['uniacid']));
        if($scoupon){
            foreach ($scoupon as $sk => & $sval){
            }
        }
        $_W['wlsetting']['share']['share_title'] = !empty($store['storename'])? $store['storename'] : $_W['wlsetting']['share']['share_title'];
        $_W['wlsetting']['share']['share_image'] = !empty($store['logo'])? $store['logo'] : $_W['wlsetting']['share']['share_image'];
        include wl_template('store/detail');
    }
    public function getstore(){
        global $_W, $_GPC;
        $lng = !empty($_GPC['lng'])? $_GPC['lng'] : '105.015615';
        $lat = !empty($_GPC['lat'])? $_GPC['lat'] : '31.57425';
        $parm = array('uniacid' => $_W['uniacid'], 'status' => 2, 'enabled' => 1, 'areaid' => $_W['areaid']);
        if(!empty($_GPC['cid'])){
            $parm['onelevel'] = intval($_GPC['cid']);
        }
        if(!empty($_GPC['pid'])){
            $parm['twolevel'] = intval($_GPC['pid']);
        }
        if(!empty($_GPC['distid'])){
            $parm['distid'] = intval($_GPC['distid']);
        }
        if(!empty($_GPC['keyword'])){
            $parm['storename like'] = "%" . trim($_GPC['keyword']) . "%";
        }
        $locations = pdo_getall(PDO_NAME . 'merchantdata', $parm, array('id', 'storename', 'logo', 'location', 'storehours', 'onelevel', 'twolevel'));
        $locations = Store :: getstores($locations, $lng, $lat);
        foreach($locations as $key => & $v){
            $halfcard = pdo_get(PDO_NAME . 'halfcardlist', array('aid' => $_W['aid'], 'uniacid' => $_W['uniacid'], 'merchantid' => $v['id'], 'status' => 1), array('title'));
            $v['halfcard'] = $halfcard['title'];
            $v['rush'] = pdo_getall(PDO_NAME . 'rush_activity', array('aid' => $_W['aid'], 'uniacid' => $_W['uniacid'], 'sid' => $v['id'], 'status' => 2), array('name'));
            $v['coupon'] = pdo_getall(PDO_NAME . 'couponlist', array('aid' => $_W['aid'], 'uniacid' => $_W['uniacid'], 'merchantid' => $v['id'], 'status' => 1), array('title'));
            if($halfcard){
                if(count($v['rush']) > 0){
                    if(count($v['rush']) > 1){
                        $v['rushnum'] = 2;
                        $v['couponnum'] = 1;
                    }else{
                        if(count($v['coupon']) > 1){
                            $v['rushnum'] = 2;
                            $v['couponnum'] = 1;
                        }else{
                            $v['rushnum'] = 2;
                            $v['couponnum'] = 1;
                        }
                    }
                }else{
                    $v['couponnum'] = 2;
                }
            }else{
                if(count($v['rush']) == 0){
                    $v['couponnum'] = 3;
                }else if(count($v['rush']) == 1){
                    $v['rushnum'] = 1;
                    $v['couponnum'] = 2;
                }else if(count($v['rush']) == 2){
                    $v['rushnum'] = 2;
                    $v['couponnum'] = 1;
                }else{
                    if(count($v['coupon'] > 0)){
                        $v['rushnum'] = 2;
                        $v['couponnum'] = 1;
                    }else{
                        $v['rushnum'] = 3;
                    }
                }
            }
        }
        die(json_encode($locations));
    }
    public function getcategory(){
        global $_W, $_GPC;
        $parentid = intval($_GPC['pid']);
        if($parentid){
            $categoryes = Util :: getNumData("id,name", PDO_NAME . 'category_store', array('uniacid' => $_W['uniacid'], 'aid' => $_W['aid'], 'parentid' => $parentid), 'displayorder DESC');
        }else{
            $categoryes = Util :: getNumData("id,name", PDO_NAME . 'category_store', array('uniacid' => $_W['uniacid'], 'aid' => $_W['aid'], 'parentid' => 0), 'displayorder DESC');
        }
        die(json_encode($categoryes[0]));
    }
    public function getarea(){
        global $_W, $_GPC;
        $areas = pdo_getall(PDO_NAME . 'area', array('pid' => $_W['areaid']), array('id', 'name'));
        die(json_encode($areas));
    }
    public function collect(){
        global $_W, $_GPC;
        $storeid = intval($_GPC['id']);
        $collects = pdo_get(PDO_NAME . 'collect', array('uniacid' => $_W['uniacid'], 'mid' => $_W['mid'], 'storeid' => $storeid), 'id');
        if($collects){
            $re = pdo_delete(PDO_NAME . 'collect', array('id' => $collects));
        }else{
            $fanss = pdo_getcolumn(PDO_NAME . 'storefans', array('uniacid' => $_W['uniacid'], 'mid' => $_W['mid'], 'sid' => $storeid), 'id');
            if(empty($fanss)){
                pdo_insert(PDO_NAME . 'storefans', array('uniacid' => $_W['uniacid'], 'mid' => $_W['mid'], 'sid' => $storeid, 'createtime' => time(), 'source' => 1));
            }
            $re = pdo_insert(PDO_NAME . 'collect', array('uniacid' => $_W['uniacid'], 'mid' => $_W['mid'], 'storeid' => $storeid, 'createtime' => time()));
        }
        if($re){
            die(json_encode(array("result" => 1)));
        }
        die(json_encode(array('result' => 2)));
    }
    public function comment(){
        global $_W, $_GPC;
        $id = $_GPC['id'];
        $type = $_GPC['type'];
        $content = $_GPC['comment'];
        if($type == 'rush'){
            $order = Rush :: getSingleOrder($id, "*");
            $images = $_GPC['images'];
            $data = array('uniacid' => $_W['uniacid'], 'mid' => $_W['mid'], 'sid' => $order['sid'], 'text' => $content, 'headimg' => $_W['wlmember']['avatar'], 'nickname' => $_W['wlmember']['nickname'], 'createtime' => TIMESTAMP, 'plugin' => 'rush', 'pic' => $images[0]);
            pdo_insert(PDO_NAME . 'comment', $data);
            pdo_update(PDO_NAME . 'rush_order', array('comment' => 2), array('id' => $id));
        }
        include wl_template('home/index');
    }
}
