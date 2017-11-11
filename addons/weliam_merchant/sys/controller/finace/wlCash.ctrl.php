<?php
defined('IN_IA')or exit('Access Denied');
class wlCash{
    public function cashSurvey(){
        global $_W, $_GPC;
        $refresh = $_GPC['refresh']?1:0;
        $data = Merchant :: sysCashSurvey(1);
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
            pdo_update(PDO_NAME . 'settlement_record', array('status' => 3, 'updatetime' => TIMESTAMP), array('id' => $_GPC['id']));
            message('提交成功！', web_url('finace/wlCash/cashApply', array('status' => 3)), 'success');
        }else{
            $where = array();
            $where['status'] = $_GPC['status']?$_GPC['status']:2;
            $list = Util :: getNumData('*', PDO_NAME . 'settlement_record', $where);
            $list = $list[0];
            foreach($list as$key => & $value){
                $value['sName'] = Util :: idSwitch('sid', 'sName', $value['sid']);
                $value['aName'] = Util :: idSwitch('aid', 'aName', $value['aid']);
            }
        }
        include wl_template('finace/cashConfirm');
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
                if(empty($settlementRecord['aopenid'])){
                    $settlementRecord['aopenid'] = pdo_getcolumn(PDO_NAME . 'agentusers', array('id' => $settlementRecord['aid']), 'cashopenid');
                    if(empty($settlementRecord['aopenid'])){
                        message('该代理未绑定提现微信号！', referer(), 'error');
                    }
                }
                $money = $_GPC['money'];
                $smoney = !empty($_GPC['smoney'])?$_GPC['smoney']:1;
                $apercent = $_GPC['apercent']?$_GPC['apercent']:$settlementRecord['apercent'];
                $apercentMoney = $_GPC['apercentMoney']?$_GPC['apercentMoney']:$settlementRecord['apercentmoney'];
                if(is_numeric($money) && is_numeric($smoney)){
                    if($money < 1)message('到账金额需要大于1元！', referer(), 'error');
                    $result1 = wlPay :: finance($settlementRecord['sopenid'], $smoney, '结算给商家');
                    $result2 = wlPay :: finance($settlementRecord['aopenid'], $money, '结算给代理');
                    if ($result2['return_code'] == 'SUCCESS' && $result2['result_code'] == 'SUCCESS'){
                        pdo_update(PDO_NAME . 'settlement_record', array('status' => 4, 'updatetime' => TIMESTAMP, 'apercent' => $apercent, 'agetmoney' => $money, 'apercentmoney' => $apercentMoney, 'settletype' => 1), array('id' => $_GPC['id']));
                        if($settlementRecord['type'] == 2){
                            $ids = unserialize($settlementRecord['ids']);
                            foreach($ids as $key => $value){
                                pdo_update(PDO_NAME . 'vip_record', array('issettlement' => 2), array('id' => $value));
                            }
                        }
                        if($settlementRecord['type'] == 3){
                            $ids = unserialize($settlementRecord['ids']);
                            foreach($ids as $key => $value){
                                pdo_update(PDO_NAME . 'halfcard_record', array('issettlement' => 2), array('id' => $value));
                            }
                        }
                        if($result1['return_code'] == 'SUCCESS' && $result1['result_code'] == 'SUCCESS'){
                            pdo_update(PDO_NAME . 'settlement_record', array('status' => 5, 'updatetime' => TIMESTAMP, 'apercent' => $apercent, 'agetmoney' => $money, 'apercentmoney' => $apercentMoney, 'settletype' => 1), array('id' => $_GPC['id']));
                            if($settlementRecord['type'] == 1){
                                $orders = unserialize($settlementRecord['ids']);
                                foreach($orders as $iid){
                                    if($settlementRecord['type2'] == 1){
                                        pdo_update(PDO_NAME . 'order', array('issettlement' => 2), array('id' => $iid));
                                    }else{
                                        pdo_update(PDO_NAME . 'rush_order', array('issettlement' => 2), array('id' => $iid));
                                    }
                                }
                            }
                            message('已结算给代理和商家！', web_url('finace/wlCash/cashApply', array('status' => 5)), 'success');
                        }
                        message('已结算给代理！', web_url('finace/wlCash/cashApply', array('status' => 4)), 'success');
                    }else{
                        message('微信钱包提现失败: ' . $result['message'], '', 'error');
                    }
                }else{
                    message('结算金额输入错误！', referer(), 'error');
                }
                message('操作成功！', web_url('finace/wlCash/cashApply'), 'success');
            }
            if (checksubmit('submit') && $_GPC['accountType'] == 'f2f'){
                if($settlementRecord['status'] != 3)message('结算状态错误！', web_url('finace/wlCash/cashApply'), 'error');
                $money = $_GPC['money'];
                $apercent = $_GPC['apercent']?$_GPC['apercent']:$settlementRecord['apercent'];
                $apercentMoney = $_GPC['apercentMoney']?$_GPC['apercentMoney']:$settlementRecord['apercentmoney'];
                if(is_numeric($money)){
                    pdo_update(PDO_NAME . 'settlement_record', array('status' => 4, 'updatetime' => TIMESTAMP, 'apercent' => $apercent, 'agetmoney' => $money, 'apercentmoney' => $apercentMoney, 'settletype' => 1), array('id' => $_GPC['id']));
                    if($settlementRecord['type'] == 2){
                        $ids = unserialize($settlementRecord['ids']);
                        foreach($ids as $key => $value){
                            pdo_update(PDO_NAME . 'vip_record', array('issettlement' => 2), array('id' => $value));
                        }
                    }
                    if($settlementRecord['type'] == 3){
                        $ids = unserialize($settlementRecord['ids']);
                        foreach($ids as $key => $value){
                            pdo_update(PDO_NAME . 'halfcard_record', array('issettlement' => 2), array('id' => $value));
                        }
                    }
                    message('已结算给代理！', web_url('finace/wlCash/cashApply', array('status' => 4)), 'success');
                }else{
                    message('结算金额输入错误！', web_url('finace/wlCash/cashApply'), 'error');
                }
                message('操作成功！', web_url('finace/wlCash/cashApply'), 'success');
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
        $str = '未结算订单_' . time();
        header('Content-type:text/csv');
        header("Content-Disposition:attachment; filename={$str}.csv");
        echo $html;
        exit();
    }
}
