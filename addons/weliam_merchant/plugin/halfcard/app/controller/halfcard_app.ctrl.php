<?php
defined('IN_IA')or exit('Access Denied');
class halfcard_app{
    public function halfcardList(){
        global $_W, $_GPC;
        $base = Setting :: agentsetting_read('halfcard');
        $pagetitle = !empty($_W['wlsetting']['base']['name'])? $_W['agentset']['halfcard']['halftext'] . '商户 - ' . $_W['wlsetting']['base']['name'] : $_W['agentset']['halfcard']['halftext'] . '商户';
        $week = date('w');
        $day = date('j');
        if($week == 0){
            $week = 7;
        }
        $week1 = date('w', strtotime("+1 day"));
        $day1 = date('j', strtotime("+1 day"));
        $week2 = date('w', strtotime("+2 day"));
        $day2 = date('j', strtotime("+2 day"));
        $week3 = date('w', strtotime("+3 day"));
        $day3 = date('j', strtotime("+3 day"));
        $week4 = date('w', strtotime("+4 day"));
        $day4 = date('j', strtotime("+4 day"));
        $week5 = date('w', strtotime("+5 day"));
        $day5 = date('j', strtotime("+5 day"));
        $week6 = date('w', strtotime("+6 day"));
        $day6 = date('j', strtotime("+6 day"));
        $week7 = date('w', strtotime("+7 day"));
        $day7 = date('j', strtotime("+7 day"));
        if($week1 == 0){
            $week1 = 7;
        }
        if($week2 == 0){
            $week2 = 7;
        }
        if($week3 == 0){
            $week3 = 7;
        }
        if($week4 == 0){
            $week4 = 7;
        }
        if($week5 == 0){
            $week5 = 7;
        }
        if($week6 == 0){
            $week6 = 7;
        }
        if($week7 == 0){
            $week7 = 7;
        }
        $num = $num1 = $num2 = $num3 = $num4 = $num5 = $num6 = $num7 = 0;
        $halfcardlist = pdo_getall('wlmerchant_halfcardlist', array('uniacid' => $_W['uniacid'], 'status' => 1));
        foreach ($halfcardlist as $key => & $v){
            if($v['datestatus'] == 1){
                $v['week'] = unserialize($v['week']);
                if(in_array($week, $v['week'])){
                    $num = $num + 1;
                }
                if(in_array($week1, $v['week'])){
                    $num1 = $num1 + 1;
                }
                if(in_array($week2, $v['week'])){
                    $num2 = $num2 + 1;
                }
                if(in_array($week3, $v['week'])){
                    $num3 = $num3 + 1;
                }
                if(in_array($week4, $v['week'])){
                    $num4 = $num4 + 1;
                }
                if(in_array($week5, $v['week'])){
                    $num5 = $num5 + 1;
                }
                if(in_array($week6, $v['week'])){
                    $num6 = $num6 + 1;
                }
                if(in_array($week7, $v['week'])){
                    $num7 = $num7 + 1;
                }
            }else{
                $v['day'] = unserialize($v['day']);
                if(in_array($day, $v['day'])){
                    $num = $num + 1;
                }
                if(in_array($day1, $v['day'])){
                    $num1 = $num1 + 1;
                }
                if(in_array($day2, $v['day'])){
                    $num2 = $num2 + 1;
                }
                if(in_array($day3, $v['day'])){
                    $num3 = $num3 + 1;
                }
                if(in_array($day4, $v['day'])){
                    $num4 = $num4 + 1;
                }
                if(in_array($day5, $v['day'])){
                    $num5 = $num5 + 1;
                }
                if(in_array($day6, $v['day'])){
                    $num6 = $num6 + 1;
                }
                if(in_array($day7, $v['day'])){
                    $num7 = $num7 + 1;
                }
            }
        }
        if($_W['wlsetting']['halfcard']['halfcardtype'] == 1){
            $where = array('mid' => $_W['mid']);
        }else{
            $where = array('mid' => $_W['mid'], 'aid' => $_W['aid']);
        }
        $member = pdo_getcolumn('wlmerchant_halfcardmember', $where, 'id');
        if($member){
            $halfcardflag = 1;
        }
        $share = Setting :: agentsetting_read('halfcard');
        $_W['wlsetting']['share']['share_title'] = !empty($share['share_title'])? $share['share_title'] : $_W['wlsetting']['share']['share_title'];
        $_W['wlsetting']['share']['share_desc'] = !empty($share['share_desc'])? $share['share_desc'] : $_W['wlsetting']['share']['share_desc'];
        $_W['wlsetting']['share']['share_image'] = !empty($share['share_image'])? $share['share_image'] : $_W['wlsetting']['share']['share_image'];
        include wl_template('halfcardhtml/halfcardlist');
    }
    public function todaliylist(){
        global $_W, $_GPC;
        $pagetitle = !empty($_W['wlsetting']['base']['name'])? "非" . $_W['agentset']['halfcard']['halftext'] . '日 - ' . $_W['wlsetting']['base']['name'] : "非" . $_W['agentset']['halfcard']['halftext'] . '日';
        include wl_template('halfcardhtml/todaliylist');
    }
    public function getstore(){
        global $_W, $_GPC;
        $flag = $_GPC['flag'];
        if(!$flag){
            $weekflag = date('w');
            $dayflag = 'today';
            $dayflag2 = date('j');
        }else{
            $weekflag = date('w', strtotime("+$flag day"));
            $dayflag = date('m-j', strtotime("+$flag day"));
            $dayflag2 = date('j', strtotime("+$flag day"));
        }
        if($weekflag == 0){
            $weekflag = 7;
        }
        $lng = !empty($_GPC['lng'])? $_GPC['lng'] : '105.015615';
        $lat = !empty($_GPC['lat'])? $_GPC['lat'] : '31.57425';
        $parm = array('uniacid' => $_W['uniacid'], 'status' => 2, 'enabled' => 1, 'aid' => $_W['aid']);
        $pindex = max(1, intval($_GPC['page']));
        $psize = 10;
        $halfcardlist = pdo_fetchall("SELECT * FROM " . tablename('wlmerchant_halfcardlist') . "WHERE uniacid = {$_W['uniacid']} AND aid = {$_W['aid']}");
        if($halfcardlist){
            $ids = "(";
            foreach ($halfcardlist as $key => $v){
                if($key == 0){
                    $ids .= $v['merchantid'];
                }else{
                    $ids .= "," . $v['merchantid'];
                }
            }
            $ids .= ")";
            $parm['id#'] = $ids;
        }else{
            $parm['id#'] = "(0)";
        }
        if(!empty($_GPC['cid'])){
            $parm['onelevel'] = intval($_GPC['cid']);
        }
        if(!empty($_GPC['pid'])){
            $parm['twolevel'] = intval($_GPC['pid']);
        }
        if(!empty($_GPC['distid'])){
            $parm['distid'] = intval($_GPC['distid']);
        }
        $locations = Halfcard :: getNumstore('*', $parm, 'ID DESC', 0, 0, 0);
        $locations = $locations[0];
        if($locations){
            $locations = Halfcard :: getstores($locations, $lng, $lat);
            foreach ($locations as $key => & $v){
                $active = pdo_get('wlmerchant_halfcardlist', array('merchantid' => $v['id'], 'status' => 1));
                if($active){
                    if($active['datestatus'] == 1){
                        $active['week'] = unserialize($active['week']);
                        if(in_array($weekflag, $active['week'])){
                            $active['logo'] = tomedia($v['logo']);
                            $active['dayflag'] = $dayflag;
                            $active['href'] = app_url('halfcard/halfcard_app/halfcarddetail', array('id' => $active['id'], 'flag' => $flag));
                            $v['active'] = $active;
                            $newlocations[] = $v;
                        }
                    }else{
                        $active['day'] = unserialize($active['day']);
                        if(in_array($dayflag2, $active['day'])){
                            $active['logo'] = tomedia($v['logo']);
                            $active['dayflag'] = $dayflag;
                            $active['href'] = app_url('halfcard/halfcard_app/halfcarddetail', array('id' => $active['id'], 'flag' => $flag));
                            $v['active'] = $active;
                            $newlocations[] = $v;
                        }
                    }
                }
            }
            if($newlocations){
                die(json_encode($newlocations));
            }else{
                die(json_encode(0));
            }
        }else{
            die(json_encode(0));
        }
    }
    public function getdailystore(){
        global $_W, $_GPC;
        $lng = !empty($_GPC['lng'])? $_GPC['lng'] : '105.015615';
        $lat = !empty($_GPC['lat'])? $_GPC['lat'] : '31.57425';
        $parm = array('uniacid' => $_W['uniacid'], 'status' => 2, 'enabled' => 1, 'aid' => $_W['aid']);
        $pindex = max(1, intval($_GPC['page']));
        $psize = 10;
        $halfcardlist = pdo_fetchall("SELECT * FROM " . tablename('wlmerchant_halfcardlist') . "WHERE uniacid = {$_W['uniacid']} AND aid = {$_W['aid']} AND daily = 1");
        if($halfcardlist){
            $ids = "(";
            foreach ($halfcardlist as $key => $v){
                if($key == 0){
                    $ids .= $v['merchantid'];
                }else{
                    $ids .= "," . $v['merchantid'];
                }
            }
            $ids .= ")";
            $parm['id#'] = $ids;
        }else{
            $parm['id#'] = "(0)";
        }
        if(!empty($_GPC['cid'])){
            $parm['onelevel'] = intval($_GPC['cid']);
        }
        if(!empty($_GPC['pid'])){
            $parm['twolevel'] = intval($_GPC['pid']);
        }
        if(!empty($_GPC['distid'])){
            $parm['distid'] = intval($_GPC['distid']);
        }
        $locations = Halfcard :: getNumstore('*', $parm, 'ID DESC', 0, 0, 0);
        $locations = $locations[0];
        if($locations){
            $locations = Halfcard :: getstores($locations, $lng, $lat);
            foreach ($locations as $key => & $v){
                $active = pdo_get('wlmerchant_halfcardlist', array('merchantid' => $v['id'], 'status' => 1));
                $active['logo'] = tomedia($v['logo']);
                $active['href'] = app_url('store/merchant/detail', array('id' => $v['id']));
                $v['active'] = $active;
                $v['storehours'] = unserialize($v['storehours']);
                $newlocations[] = $v;
            }
            die(json_encode($newlocations));
        }else{
            die(json_encode(0));
        }
    }
    public function halfcarddetail(){
        global $_W, $_GPC;
        $pagetitle = !empty($_W['wlsetting']['base']['name'])? '商户详情 - ' . $_W['wlsetting']['base']['name'] : '商户详情';
        $base = Setting :: agentsetting_read('halfcard');
        $id = $_GPC['id'];
        $flag = $_GPC['flag'];
        if(!$id){
            message('参数错误，请重试', app_url('halfcard/halfcard_app/halfcardList'), 'error');
        }
        $halfcard = pdo_get('wlmerchant_halfcardlist', array('id' => $id));
        $merchant = pdo_get('wlmerchant_merchantdata', array('id' => $halfcard['merchantid']));
        $halfcard['pv'] = $halfcard['pv'] + 1;
        $res = pdo_update('wlmerchant_halfcardlist', array('pv' => $halfcard['pv']), array('id' => $id));
        $advs = unserialize($halfcard['adv']);
        $merchantid = $merchant['id'];
        if($flag){
            $month = date('m', strtotime("+$flag day"));
            $day = date('j', strtotime("+$flag day"));
            $dayflag = date('Ymd', strtotime("+$flag day"));
        }else{
            $month = date('m');
            $day = date('j');
            $dayflag = date('Ymd');
        }
        $times = pdo_fetchcolumn('SELECT count(id) FROM ' . tablename('wlmerchant_halfcardrecord') . " WHERE mid = {$_W['mid']} AND date = '{$dayflag}' AND aid = {$_W['aid']}");
        if($_W['wlsetting']['halfcard']['halfcardtype'] == 1){
            $where['expiretime>'] = time();
            $member = Halfcard :: getSingleMember($_W['mid'], '*', $where);
            if($member){
                if($base['daytimes']){
                    if($times < $base['daytimes']){
                        $timeflag = 1;
                    }else{
                        $timeflag = 3;
                    }
                }else{
                    $timeflag = 1;
                }
            }else{
                $timeflag = 2;
            }
        }else{
            $where['expiretime>'] = time();
            $where['aid'] = $_W['aid'];
            $member = Halfcard :: getSingleMember($_W['mid'], '*', $where);
            if($member){
                if($base['daytimes']){
                    if($times < $base['daytimes']){
                        $timeflag = 1;
                    }else{
                        $timeflag = 3;
                    }
                }else{
                    $timeflag = 1;
                }
            }else{
                $timeflag = 2;
            }
        }
        $_W['wlsetting']['share']['share_title'] = !empty($halfcard['title'])? $halfcard['title'] : $merchant['storename'];
        $_W['wlsetting']['share']['share_desc'] = !empty($merchant['introduction'])? $merchant['introduction'] : $base['share_desc'];
        $_W['wlsetting']['share']['share_image'] = !empty($merchant['logo'])? $merchant['logo'] : $base['share_image'];
        include wl_template('halfcardhtml/halfcarddetail');
    }
    public function createqrcode(){
        global $_W, $_GPC;
        $id = $_GPC['id'];
        $flag = $_GPC['flag'];
        $merchantid = $_GPC['merchantid'];
        $base = Setting :: agentsetting_read('halfcard');
        if($flag){
            $date = date('Ymd', strtotime("+$flag day"));
            $date2 = date('Y-m-d', strtotime("+$flag day"));
            $dayflag = date('Ymd', strtotime("+$flag day"));
        }else{
            $date = date('Ymd');
            $date2 = date('Y-m-d');
            $dayflag = date('Ymd');
        }
        $times = pdo_fetchcolumn('SELECT count(id) FROM ' . tablename('wlmerchant_halfcardrecord') . " WHERE mid = {$_W['mid']} AND date = '{$dayflag}'");
        if(!empty($base['daytimes']) && $times > $base['daytimes'] - 1){
            die(json_encode(array('flag' => 0, 'message' => '您当日已使用过' . $base['daytimes'] . '次' . $_W['agentset']['halfcard']['halftext'] . '特权')));
        }else{
            $qrcode = Util :: createConcode(2);
            $data = array('uniacid' => $_W['uniacid'], 'aid' => $_W['aid'], 'status' => 1, 'activeid' => $id, 'merchantid' => $merchantid, 'mid' => $_W['mid'], 'date' => $date, 'qrcode' => $qrcode, 'createtime' => time());
            $res = pdo_insert('wlmerchant_halfcardrecord', $data);
            $rid = pdo_insertid();
            $url = app_url('halfcard/halfcard_app/hexiaohalfcard', array('id' => $rid));
            $qrurl = app_url('halfcard/halfcard_app/qrcodeimg', array('url' => $url));
            if($res){
                die(json_encode(array('flag' => 1, 'qrcode' => $qrcode, 'datetime' => $date2, 'qrsrc' => $qrurl)));
            }else{
                die(json_encode(array('flag' => 0, 'qrcode' => $qrcode)));
            }
        }
    }
    public function userhalfcard(){
        global $_W, $_GPC;
        $pagetitle = !empty($_W['wlsetting']['base']['name'])? '我的' . $_W['agentset']['halfcard']['halftext'] . '优惠 - ' . $_W['wlsetting']['base']['name'] : '我的' . $_W['agentset']['halfcard']['halftext'] . '优惠';
        $status = $_GPC['status'];
        if(!$status){
            $status = 1;
        }
        $date = date('Ymd');
        $todays = pdo_fetchall("SELECT * FROM " . tablename('wlmerchant_halfcardrecord') . "WHERE uniacid = {$_W['uniacid']} AND mid = {$_W['mid']} AND aid = {$_W['aid']} AND date = '{$date}' ORDER BY createtime DESC");
        foreach ($todays as $k => & $v){
            $active = pdo_get('wlmerchant_halfcardlist', array('id' => $v['activeid']));
            $merchant = pdo_get('wlmerchant_merchantdata', array('id' => $v['merchantid']));
            $v['logo'] = tomedia($merchant['logo']);
            $v['storename'] = $merchant['storename'];
            $v['address'] = $merchant['address'];
            $v['title'] = $active['title'];
            $v['date'] = substr($v['date'], 0, 4) . "-" . substr($v['date'], 4, 2) . '-' . substr($v['date'], -2, 2);
            $v['createtime'] = date('Y-m-d H:i:s', $v['createtime']);
            $v['limit'] = $active['limit'];
        }
        $overdues = pdo_fetchall("SELECT * FROM " . tablename('wlmerchant_halfcardrecord') . "WHERE uniacid = {$_W['uniacid']} AND mid = {$_W['mid']} AND aid = {$_W['aid']} AND date < '{$date}' ORDER BY createtime DESC");
        foreach ($overdues as $k => & $v){
            $active = pdo_get('wlmerchant_halfcardlist', array('id' => $v['activeid']));
            $merchant = pdo_get('wlmerchant_merchantdata', array('id' => $v['merchantid']));
            $v['logo'] = tomedia($merchant['logo']);
            $v['storename'] = $merchant['storename'];
            $v['title'] = $active['title'];
            $v['date'] = substr($v['date'], 0, 4) . "-" . substr($v['date'], 4, 2) . '-' . substr($v['date'], -2, 2);
            $v['createtime'] = date('Y-m-d H:i:s', $v['createtime']);
            $v['limit'] = $active['limit'];
        }
        $base = Setting :: agentsetting_read('halfcard');
        if($_W['wlsetting']['halfcard']['halfcardtype'] == 1){
            $hcprice = unserialize($_W['wlsetting']['halfcard']['hcprice']);
            $member = pdo_get('wlmerchant_halfcardmember', array('mid' => $_W['mid']), array('expiretime'));
            if($member){
                $halfcardflag = 1;
            }else{
                $halfcardflag = 2;
            }
            $listData = Util :: getNumData("*", PDO_NAME . 'halfcard_type', array('aid' => 0));
            $hcprice = $listData[0];
        }else{
            $hcprice = unserialize($base['hcprice']);
            $member = pdo_get('wlmerchant_halfcardmember', array('mid' => $_W['mid'], 'aid' => $_W['aid']), array('expiretime'));
            if($member){
                $halfcardflag = 1;
            }else{
                $halfcardflag = 2;
            }
            $listData = Util :: getNumData("*", PDO_NAME . 'halfcard_type', array('aid' => $_W['aid']));
            $hcprice = $listData[0];
        }
        $user = pdo_get('wlmerchant_member', array('id' => $_W['mid'], 'uniacid' => $_W['uniacid']));
        include wl_template('halfcardhtml/userhalfcard');
    }
    public function createqrcodeimg(){
        global $_W, $_GPC;
        $id = $_GPC['id'];
        $url = app_url('halfcard/halfcard_app/hexiaohalfcard', array('id' => $id));
        $src = app_url('halfcard/halfcard_app/qrcodeimg', array('url' => $url));
        $datetime = date('Y-m-d');
        die(json_encode(array('flag' => 1, 'qrsrc' => $src, 'datetime' => $datetime)));
    }
    public function qrcodeimg(){
        global $_W, $_GPC;
        $url = $_GPC['url'];
        m('qrcode/QRcode') -> png($url, false, QR_ECLEVEL_H, 4);
    }
    public function hexiaohalfcard(){
        global $_W, $_GPC;
        $id = $_GPC['id'];
        $order = pdo_get('wlmerchant_halfcardrecord', array('id' => $id), array('merchantid'));
        $verifier = SingleMerchant :: verifier($order['merchantid'], $_W['mid']);
        if($verifier){
            $res = pdo_update('wlmerchant_halfcardrecord', array('status' => 2), array('id' => $id));
            if($res){
                $res2 = pdo_update('wlmerchant_halfcardrecord', array('hexiaotime' => time(), 'verfmid' => $_W['mid']), array('id' => $id));
                if($res2){
                    wl_message('核销成功', 'close', 'success');
                }else{
                    wl_message('核销失败,时间参数错误，请联系管理员！', 'close', 'error');
                }
            }else{
                wl_message('核销失败,请勿二次核销。', 'close', 'error');
            }
        }else{
            wl_message('非管理员无法核销', 'close', 'error');
        }
    }
    public function activation(){
        global $_W, $_GPC;
        $pagetitle = !empty($_W['wlsetting']['base']['name'])? '激活' . $_W['agentset']['halfcard']['halfcardtext'] . ' - ' . $_W['wlsetting']['base']['name'] : '激活' . $_W['agentset']['halfcard']['halfcardtext'];
        $cardpa = $_GPC['cardpa'];
        if($cardpa){
            $type = Util :: getSingelData("*", PDO_NAME . 'token', array('number' => $cardpa));
            if(empty($type))wl_message('激活码不存在！');
            if($type['status'] != 0)wl_message('该激活码已使用！');
            $dayNum = $type['days'];
            $mdata = array('uniacid' => $_W['uniacid'], 'mid' => $_W['mid']);
            $vipInfo = Util :: getSingelData('*', PDO_NAME . "halfcardmember", $mdata);
            $lastviptime = $vipInfo['expiretime'];
            if($lastviptime && $lastviptime > time()){
                $limittime = $lastviptime + $dayNum * 24 * 60 * 60;
            }else{
                $limittime = time() + $dayNum * 24 * 60 * 60;
            }
            $aid = Util :: idSwitch('areaid', 'aid', $_W['areaid']);
            $halfcarddata = array('uniacid' => $_W['uniacid'], 'aid' => $_W['aid'], 'mid' => $_W['mid'], 'expiretime' => $limittime, 'createtime' => time());
            $member = pdo_get(PDO_NAME . 'halfcardmember', array('mid' => $_W['mid']));
            if($member){
                if(pdo_update(PDO_NAME . 'halfcardmember', $halfcarddata, array('mid' => $_W['mid']))){
                    pdo_update(PDO_NAME . 'token', array('status' => 1, 'mid' => $_W['mid'], 'openid' => $_W['openid']), array('number' => $cardpa));
                    $member['expiretime'] = date('Y-m-d H:i:s', $limittime);
                    include wl_template('halfcardhtml/open_success');
                    exit;
                }
            }else{
                if(pdo_insert(PDO_NAME . 'halfcardmember', $halfcarddata)){
                    pdo_update(PDO_NAME . 'token', array('status' => 1, 'mid' => $_W['mid'], 'openid' => $_W['openid']), array('number' => $cardpa));
                    $member['expiretime'] = date('Y-m-d H:i:s', $limittime);
                    include wl_template('halfcardhtml/open_success');
                    exit;
                }
            }
        }
        include wl_template('halfcardhtml/activation');
    }
    public function checkuse(){
        global $_W, $_GPC;
        $id = $_GPC['id'];
        $merchantid = $_GPC['merchantid'];
        $dayflag = date('Ymd');
        $daydate = date('Y-m-d');
        $merchanttime = pdo_fetch('SELECT * FROM ' . tablename('wlmerchant_halfcardrecord') . " WHERE mid = {$_W['mid']} AND date = '{$dayflag}' AND merchantid = {$merchantid}");
        if($merchanttime){
            $url = app_url('halfcard/halfcard_app/hexiaohalfcard', array('id' => $merchanttime['id']));
            $qrurl = app_url('halfcard/halfcard_app/qrcodeimg', array('url' => $url));
            die(json_encode(array('err' => 0, 'qrcode' => $merchanttime['qrcode'], 'datetime' => $daydate, 'qrsrc' => $qrurl)));
        }else{
            die(json_encode(array('err' => 1)));
        }
    }
}
?>