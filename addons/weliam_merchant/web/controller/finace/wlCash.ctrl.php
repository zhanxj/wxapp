<?php
class wlCash{
    public function cashSurvey(){
        global $_W, $_GPC;
        $refresh = $_GPC['refresh']?1:0;
        $data = Merchant :: agentCashSurvey($refresh);
        $agents = $data[0];
        $children = $data[1];
        $max = $data[2];
        $allMoney = $data[3];
        $time = $data[4];
        include wl_template('finace/cashSurvey');
    }
    public function cashApply(){
        global $_W, $_GPC;
        if($_GPC['type'] == 'submit' && !empty($_GPC['id'])){
            pdo_update(PDO_NAME . 'settlement_record', array('status' => 2, 'updatetime' => TIMESTAMP), array('id' => $_GPC['id']));
            message('提交成功！', web_url('finace/wlCash/cashApply', array('status' => 2)), 'success');
        }else{
            $where = array();
            $status = $_GPC['status']?$_GPC['status']:1;
            if($status == 1)$where['status'] = 1;
            if($status == 2)$where['status'] = 2;
            if($status == 3)$where['#status#'] = '(-1,-2)';
            if($status == 4)$where['status'] = 4;
            if($status == 5)$where['status'] = 5;
            $where['type'] = 1;
            $where['aid'] = $_W['aid'];
            $list = Util :: getNumData('*', PDO_NAME . 'settlement_record', $where);
            $list = $list[0];
            foreach($list as$key => & $value){
                $value['sName'] = Util :: idSwitch('sid', 'sName', $value['sid']);
                $value['aName'] = Util :: idSwitch('aid', 'aName', $value['aid']);
            }
        }
        include wl_template('finace/cashConfirm');
    }
    public function cashApplyAgent(){
        global $_W, $_GPC;
        $_GPC['type'] = $_GPC['type']?$_GPC['type']:'vip';
        $a = Util :: getSingelData('percent,cashopenid', PDO_NAME . 'agentusers', array('id' => $_W['aid']));
        $p = !empty($a['percent'])?unserialize($a['percent']):array();
        $psize = 0;
        if($_GPC['num'])$psize = $_GPC['num'];
        $where = array();
        $where['aid'] = $_W['aid'];
        $where['issettlement'] = 0;
        $where['status'] = 1;
        $money = $num = 0;
        if($_GPC['type'] == 'vip'){
            if($_GPC['num'] > 0 && $_GPC['money'] > 0 && !empty($_GPC['ids'])){
                if(!empty($_GPC['ids']) && is_array($_GPC['ids'])){
                    $data = array('ids' => serialize($_GPC['ids']), 'uniacid' => $_W['uniacid'], 'aid' => $_W['aid'], 'status' => 2, 'type' => 2, 'ordernum' => $_GPC['num'], 'aapplymoney' => $_GPC['money'], 'applytime' => TIMESTAMP, 'updatetime' => TIMESTAMP, 'apercent' => $p['vippercent'], 'apercentmoney' => sprintf("%.2f", $p['vippercent'] * $_GPC['money'] / 100), 'aopenid' => $a['cashopenid']);
                    if(pdo_insert(PDO_NAME . 'settlement_record', $data)){
                        foreach($_GPC['ids'] as $key => $value){
                            pdo_update(PDO_NAME . 'vip_record', array('issettlement' => 1), array('id' => $value));
                        }
                        die(json_encode(array('errno' => 0, 'message' => '申请成功')));
                    }
                }
                die(json_encode(array('errno' => 1, 'message' => '申请失败！')));
            }
            $listData = Util :: getNumData("id,price", PDO_NAME . 'vip_record', $where, 'paytime asc', 1, $psize, 1);
            $list = $listData[0];
        }
        if($_GPC['type'] == 'half'){
            if($_GPC['num'] > 0 && $_GPC['money'] > 0 && !empty($_GPC['ids'])){
                if(!empty($_GPC['ids']) && is_array($_GPC['ids'])){
                    $data = array('ids' => serialize($_GPC['ids']), 'uniacid' => $_W['uniacid'], 'aid' => $_W['aid'], 'status' => 2, 'type' => 3, 'ordernum' => $_GPC['num'], 'aapplymoney' => $_GPC['money'], 'applytime' => TIMESTAMP, 'updatetime' => TIMESTAMP, 'apercent' => $p['halfpercent'], 'apercentmoney' => sprintf("%.2f", $p['halfpercent'] * $_GPC['money'] / 100), 'aopenid' => $a['cashopenid']);
                    if(pdo_insert(PDO_NAME . 'settlement_record', $data)){
                        foreach($_GPC['ids'] as $key => $value){
                            pdo_update(PDO_NAME . 'halfcard_record', array('issettlement' => 1), array('id' => $value));
                        }
                        die(json_encode(array('errno' => 0, 'message' => '申请成功')));
                    }
                }
                die(json_encode(array('errno' => 1, 'message' => '申请失败！')));
            }
            $listData = Util :: getNumData("id,price", PDO_NAME . 'halfcard_record', $where, 'paytime asc', 1, $psize, 1);
            $list = $listData[0];
        }
        foreach ($list as $k => & $v){
            $money += $v['price'];
            $ids[$num] = $v['id'];
            $num++;
        }
        if($_GPC['type'] == 'vip')$percentMoney = sprintf("%.2f", $p['vippercent'] * $money / 100);
        if($_GPC['type'] == 'half')$percentMoney = sprintf("%.2f", $p['halfpercent'] * $money / 100);
        if($_GPC['num'])die(json_encode(array('errno' => 0, 'num' => $num, 'percentMoney' => $percentMoney, 'money' => $money, 'ids' => $ids)));
        include wl_template('finace/agentApply');
    }
    public function cashApplyAgentRecord(){
        global $_W, $_GPC;
        $where = array();
        $where['#status#'] = '(2,3,4)';
        $where['#type#'] = '(2,3)';
        $where['aid'] = $_W['aid'];
        $list = Util :: getNumData('*', PDO_NAME . 'settlement_record', $where);
        $list = $list[0];
        foreach($list as$key => & $value){
            $value['aName'] = Util :: idSwitch('aid', 'aName', $value['aid']);
        }
        include wl_template('finace/cashApplyAgentRecord');
    }
    public function detail(){
        global $_W, $_GPC;
        $id = $_GPC['id'];
        $where = array();
        $where['id'] = $id;
        $settlementRecord = Util :: getSingelData('*', PDO_NAME . 'settlement_record', $where);
        $settlementRecord['sName'] = Util :: idSwitch('sid', 'sName', $settlementRecord['sid']);
        $settlementRecord['aName'] = Util :: idSwitch('aid', 'aName', $settlementRecord['aid']);
        $orders = unserialize($settlementRecord['ids']);
        $list = array();
        foreach($orders as $id){
            if($settlementRecord['type'] == 1){
                if($settlementRecord['type2'] == 1){
                    $v = Util :: getSingelData('*', PDO_NAME . 'order', array('id' => $id));
                    $coupon = pdo_get('wlmerchant_couponlist', array('id' => $v['fkid']), array('title', 'logo'));
                    $merchant = pdo_get('wlmerchant_merchantdata', array('id' => $v['sid']), array('storename'));
                    $member = pdo_get('wlmerchant_member', array('id' => $v['mid']), array('nickname', 'avatar', 'mobile'));
                    $v['title'] = $coupon['title'];
                    $v['gimg'] = tomedia($coupon['logo']);
                    $v['storename'] = $merchant['storename'];
                    $v['nickname'] = $member['nickname'];
                    $v['headimg'] = $member['avatar'];
                    $v['mobile'] = $member['mobile'];
                    $list[] = $v;
                }else{
                    $list[] = Rush :: getSingleOrder($id, "*");
                }
            }
            if($settlementRecord['type'] == 2)$list[] = Util :: getSingelData("*", PDO_NAME . 'vip_record', array('id' => $id));
            if($settlementRecord['type'] == 3)$list[] = Util :: getSingelData("*", PDO_NAME . 'halfcard_record', array('id' => $id));
        }
        if($settlementRecord['type'] == 2){
            foreach($list as$key => & $value){
                $value['areaName'] = Util :: idSwitch('areaid', 'areaName', $value['areaid']);
                $value['member'] = Member :: getMemberByMid($value['mid']);
            }
        }
        if($settlementRecord['type'] == 3){
            foreach($list as$key => & $v){
                $user = pdo_get('wlmerchant_member', array('id' => $v['mid']));
                $v['nickname'] = $user['nickname'];
                $v['avatar'] = $user['avatar'];
                $v['mobile'] = $user['mobile'];
            }
        }
        include wl_template('finace/cashDetail');
    }
    public function settlement(){
        global $_W, $_GPC;
        $id = $_GPC['id'];
        $where = array();
        $where['id'] = $id;
        $settlementRecord = Util :: getSingelData('*', PDO_NAME . 'settlement_record', $where);
        $settlementRecord['sName'] = Util :: idSwitch('sid', 'sName', $settlementRecord['sid']);
        $settlementRecord['aName'] = Util :: idSwitch('aid', 'aName', $settlementRecord['aid']);
        $_GPC['type'] = $_GPC['type']?$_GPC['type']:'settlement';
        if($_GPC['type'] == 'money_record'){
            $pindex = max(1, intval($_GPC['page']));
            $psize = 15;
            $moneyRecordData = SingleMerchant :: getMoneyRecord($id, $pindex, $psize, 1);
            $moneyRecord = $moneyRecordData[0];
            $pager = $moneyRecordData[1];
            foreach($moneyRecord as & $item){
                if($item['orderid'])$item['order'] = Rush :: getSingleOrder($item['orderid'], '*');
            }
        }
        if($_GPC['type'] == 'settlement_record'){
            $id = $_GPC['id'];
            $merchant = model_merchant :: getSingleMerchant($id, 'thumb,name,openid,percent');
            $account = pdo_fetch("SELECT * FROM " . tablename('tg_merchant_account') . " WHERE uniacid = {$_W['uniacid']} and merchantid={$id}");
            $merchant['amount'] = $account['amount'];
            $merchant['no_money'] = $account['no_money'];
            $merchant['no_money_doing'] = $account['no_money_doing'];
            $list = pdo_fetchall("select * from" . tablename('tg_merchant_record') . "where merchantid='{$id}' and uniacid={$_W['uniacid']} ");
        }
        if($_GPC['type'] == 'settlement'){
            $_GPC['accountType'] = $_GPC['accountType']?$_GPC['accountType']:'f2f';
            if (checksubmit('submit') && $_GPC['accountType'] == 'weixin'){
            }
            if (checksubmit('submit') && $_GPC['accountType'] == 'f2f'){
                if($settlementRecord['status'] != 4)message('结算状态错误！', web_url('finace/wlCash/cashApply'), 'error');
                $money = $_GPC['money'];
                $spercent = $_GPC['spercent']?$_GPC['spercent']:$settlementRecord['spercent'];
                $spercentMoney = $_GPC['spercentMoney'];
                if(is_numeric($money)){
                    if(pdo_update(PDO_NAME . 'settlement_record', array('status' => 5, 'updatetime' => TIMESTAMP, 'spercentmoney' => $spercentMoney, 'spercent' => $spercent, 'sgetmoney' => $money), array('id' => $_GPC['id']))){
                        $orders = unserialize($settlementRecord['ids']);
                        foreach($orders as $iid){
                            if($settlementRecord['type2'] == 1){
                                pdo_update(PDO_NAME . 'order', array('issettlement' => 2), array('id' => $iid));
                            }else{
                                pdo_update(PDO_NAME . 'rush_order', array('issettlement' => 2), array('id' => $iid));
                            }
                        }
                    }
                    message('已结算给商家！', web_url('finace/wlCash/cashApply', array('status' => 5)), 'success');
                }else{
                    message('结算金额输入错误！', referer(), 'error');
                }
                message('操作成功！', referer(), 'success');
            }
        }
        include wl_template('finace/account');
    }
    public function output(){
        global $_W, $_GPC;
        $where['id'] = $_GPC['id'];
        $settlementRecord = Util :: getSingelData('*', PDO_NAME . 'settlement_record', $where);
        $orders = unserialize($settlementRecord['ids']);
        $list = array();
        if($settlementRecord['type'] == 1){
            foreach($orders as $id){
                if($settlementRecord['type2'] == 1){
                    $v = Util :: getSingelData('*', PDO_NAME . 'order', array('id' => $id));
                    $coupon = pdo_get('wlmerchant_couponlist', array('id' => $v['fkid']), array('title', 'logo'));
                    $merchant = pdo_get('wlmerchant_merchantdata', array('id' => $v['sid']), array('storename'));
                    $member = pdo_get('wlmerchant_member', array('id' => $v['mid']), array('nickname', 'avatar', 'mobile'));
                    $v['title'] = $coupon['title'];
                    $v['gimg'] = tomedia($coupon['logo']);
                    $v['storename'] = $merchant['storename'];
                    $v['nickname'] = $member['nickname'];
                    $v['headimg'] = $member['avatar'];
                    $v['mobile'] = $member['mobile'];
                    $v['actualprice'] = $v['price'];
                    $v['gname'] = $v['title'];
                    $list[] = $v;
                }else{
                    $list[] = Rush :: getSingleOrder($id, "*");
                }
            }
        }
        if($settlementRecord['type'] == 2){
            foreach($orders as $id){
                $order = Util :: getSingelData("*", PDO_NAME . 'vip_record', array('id' => $id));
                $member = Member :: getMemberByMid($order['mid']);
                $order['nickname'] = $member['nickname'];
                $order['actualprice'] = $order['price'];
                $order['mobile'] = $member['mobile'];
                $order['gname'] = 'VIP充值';
                $list[] = $order;
            }
        }
        if($settlementRecord['type'] == 3){
            foreach($orders as $id){
                $order = Util :: getSingelData("*", PDO_NAME . 'halfcard_record', array('id' => $id));
                $member = Member :: getMemberByMid($order['mid']);
                $order['nickname'] = $member['nickname'];
                $order['actualprice'] = $order['price'];
                $order['mobile'] = $member['mobile'];
                $order['gname'] = '五折卡充值';
                $list[] = $order;
            }
        }
        $orders = $list;
        if ($settlementRecord['status'] == 1)$settleStatus = '代理审核中';
        if ($settlementRecord['status'] == 2)$settleStatus = '系统审核中';
        if ($settlementRecord['status'] == 3)$settleStatus = '系统审核通过，待结算';
        if ($settlementRecord['status'] == 4)$settleStatus = '已结算到代理';
        if ($settlementRecord['status'] == 5)$settleStatus = '已结算到商家';
        if ($settlementRecord['status'] == -1)$settleStatus = '系统审核不通过';
        if ($settlementRecord['status'] == -2)$settleStatus = '代理审核不通过';
        $html = "\xEF\xBB\xBF";
        $filter = array('aa' => '商户单号', 'bb' => '昵称', 'cc' => '电话', 'dd' => '支付金额', 'ee' => '订单状态', 'jj' => '结算状态', 'ff' => '支付时间', 'gg' => '商品名称', 'hh' => '微信订单号');
        foreach ($filter as $key => $title){
            $html .= $title . "\t,";
        }
        $html .= "\n";
        foreach ($orders as $k => $v){
            if ($v['status'] == '0')$thisstatus = '未支付';
            if ($v['status'] == '1')$thisstatus = '已支付';
            if ($v['status'] == '2')$thisstatus = '已消费';
            $time = date('Y-m-d H:i:s', $v['paytime']);
            $orders[$k]['aa'] = $v['orderno'];
            $orders[$k]['bb'] = $v['nickname'];
            $orders[$k]['cc'] = $v['mobile'];
            $orders[$k]['dd'] = $v['actualprice'];
            $orders[$k]['ee'] = $thisstatus;
            $orders[$k]['jj'] = $settleStatus;
            $orders[$k]['ff'] = $time;
            $orders[$k]['gg'] = $v['gname'];
            $orders[$k]['hh'] = $v['transid'];
            foreach ($filter as $key => $title){
                $html .= $orders[$k][$key] . "\t,";
            }
            $html .= "\n";
        }
        header('Content-type:text/csv');
        header('Content-Disposition:attachment; filename=未结算订单.csv');
        echo $html;
        exit();
    }
}
?>