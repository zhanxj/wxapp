<?php
defined('IN_IA')or exit('Access Denied');
class Merchant{
    static function payVipNotify($params){
        global $_W;
        Util :: wl_log('vip_notify', PATH_DATA . 'merchant/data/', $params);
        $data = self :: getVipPayData($params);
        pdo_update(PDO_NAME . 'vip_record', $data, array('orderno' => $params['tid']));
        $order_out = pdo_get(PDO_NAME . 'vip_record', array('orderno' => $params['tid']));
        $memberData = array('level' => 1, 'vipstatus' => 1, 'vipleveldays' => $order_out['howlong'] * 30, 'lastviptime' => $order_out['limittime'], 'areaid' => $order_out['areaid'], 'aid' => $order_out['aid']);
        Message :: paySuccess($order_out['openid'], $order_out['price'], '购买VIP服务', '');
        $url = app_url('member/vip/open');
        Message :: beVip($order_out['openid'], $order_out['id'], $url);
        pdo_update(PDO_NAME . 'member', $memberData, array('id' => $order_out['mid']));
    }
    static function payVipReturn($params){
        global $_W;
        Util :: wl_log('Vip_return', PATH_DATA . 'merchant/data/', $params);
        $order_out = pdo_get(PDO_NAME . 'vip_record', array('orderno' => $params['tid']), array('id'));
        header('location:' . app_url('member/vip/vipSuccess', array('orderid' => $order_out['id'])));
    }
    static function payHalfcardNotify($params){
        global $_W;
        Util :: wl_log('vip_notify', PATH_DATA . 'merchant/data/', $params);
        $data = self :: getVipPayData($params);
        pdo_update(PDO_NAME . 'halfcard_record', $data, array('orderno' => $params['tid']));
        $order_out = pdo_get(PDO_NAME . 'halfcard_record', array('orderno' => $params['tid']));
        $res = pdo_get(PDO_NAME . 'halfcardmember', array('mid' => $order_out['mid']));
        $halfcarddata = array('uniacid' => $_W['uniacid'], 'aid' => $order_out['aid'], 'mid' => $order_out['mid'], 'expiretime' => $order_out['limittime'], 'createtime' => time());
        if($res){
            pdo_update(PDO_NAME . 'halfcardmember', $halfcarddata, array('mid' => $order_out['mid']));
        }else{
            pdo_insert(PDO_NAME . 'halfcardmember', $halfcarddata);
        }
    }
    static function payHalfcardReturn($params){
        global $_W;
        Util :: wl_log('Vip_return', PATH_DATA . 'merchant/data/', $params);
        $order_out = pdo_get(PDO_NAME . 'halfcard_record', array('orderno' => $params['tid']), array('id'));
        header('location:' . app_url('halfcard/halfcardopen/openSuccess', array('orderid' => $order_out['id'])));
    }
    static function getVipPayData($params){
        global $_W;
        $data = array('status' => $params['result'] == 'success' ? 1 : 0);
        if($params['is_usecard'] == 1){
            $fee = $params['card_fee'];
            $data['is_usecard'] = 1;
        }else{
            $fee = $params['fee'];
        }
        $paytype = array('credit' => 1, 'wechat' => 2, 'alipay' => 3, 'delivery' => 4);
        $data['paytype'] = $paytype[$params['type']];
        if ($params['type'] == 'wechat')$data['transid'] = $params['tag']['transaction_id'];
        $data['paytime'] = TIMESTAMP;
        return $data;
    }
    static function sysSurvey($refresh = 0){
        global $_W;
        $data = Cache :: getCache('sysSurvey', 'allData');
        if($data && !$refresh)return $data;
        $agentUsers = Util :: getNumData('id', PDO_NAME . 'agentusers', array());
        $members = Util :: getNumData("*", PDO_NAME . 'member', array('vipstatus' => 1));
        $time = date("Y-m-d H:i:s", time());
        $merchantNumData = Util :: getNumData("*", PDO_NAME . 'member', array(), 'id desc', 0, 0, 1);
        $today = strtotime(date('Ymd'));
        $firstday = strtotime(date('Y-m-01'));
        $yestoday = $today - 86400;
        $d = date('Ymd');
        $uv = pdo_fetchall("select distinct mid from" . tablename(PDO_NAME . 'puvrecord') . "where uniacid = {$_W['uniacid']} and date='{$d}'");
        $todaypuv = pdo_get(PDO_NAME . 'puv', array('uniacid' => $_W['uniacid'], 'date' => date('Ymd')), array('pv', 'uv'));
        $todaypuv['uv'] = count($uv);
        $allpuv = pdo_getall(PDO_NAME . 'puv', array('uniacid' => $_W['uniacid']), array('pv', 'uv'));
        $numPv = 0;
        $numUv = 0;
        foreach($allpuv as $k => $v){
            $numPv += $v['pv'];
            $numUv += $v['uv'];
        }
        $newfans = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename(PDO_NAME . 'member') . " WHERE uniacid = '{$_W['uniacid']}' and createtime >= {$firstday}");
        $totalInMoney = $totalOutMoney = $rushMoney = $vipMoney = $halfMoney = $refundMoney = $settlementMoney = $waitSettlementMoney = $spercentMoney = $halfPercentMoney = $vipPercentMoney = 0;
        $rushOrders = Util :: getNumData('actualprice,status', PDO_NAME . 'rush_order', array('#status#' => '(1,2,3,4,6,7)'));
        foreach($rushOrders[0] as $item){
            $rushMoney += $item['actualprice'];
            if($item['status'] == 7)$refundMoney += $item['actualprice'];
        }
        $vipOrders = Util :: getNumData('price', PDO_NAME . 'vip_record', array('#status#' => '(1)'));
        foreach($vipOrders[0] as $item){
            $vipMoney += $item['price'];
        }
        $halfOrders = Util :: getNumData('price', PDO_NAME . 'halfcard_record', array('#status#' => '(1)'));
        foreach($vipOrders[0] as $item){
            $halfMoney += $item['price'];
        }
        $settlementOrders = Util :: getNumData('*', PDO_NAME . 'settlement_record', array('#status#' => '(1,2,3,4,5)'));
        foreach($settlementOrders[0] as $item){
            if($item['status'] == 4 || $item['status'] == 5){
                $settlementMoney += $item['agetmoney'];
            }else{
                $waitSettlementMoney += $item['aapplymoney'];
            }
            if($item['type'] == 1)$spercentMoney += $item['apercentmoney'];
            if($item['type'] == 2)$halfPercentMoney += $item['apercentmoney'];
            if($item['type'] == 3)$vipPercentMoney += $item['apercentmoney'];
        }
        $totalInMoney = sprintf("%.2f", $rushMoney + $vipMoney + $halfMoney);
        $totalOutMoney = sprintf("%.2f", $refundMoney + $settlementMoney);
        $spercentMoney = sprintf("%.2f", $spercentMoney);
        $halfPercentMoney = sprintf("%.2f", $halfPercentMoney);
        $vipPercentMoney = sprintf("%.2f", $vipPercentMoney);
        $settlementMoney = sprintf("%.2f", $settlementMoney);
        $waitSettlementMoney = sprintf("%.2f", $waitSettlementMoney);
        $data = array(count($agentUsers[0]), count($members[0]), $address_arr, $time, $merchantNumData[2], $todaypuv, $numPv, $numUv, $newfans, $totalInMoney, $totalOutMoney, $spercentMoney, $halfPercentMoney, $vipPercentMoney, $settlementMoney, $waitSettlementMoney);
        Cache :: setCache('sysSurvey', 'allData', $data);
        return $data;
    }
    static function sysCashSurvey($refresh = 0){
        global $_W;
        $data = Cache :: getCache('sysCashSurvey', 'allData');
        if($data && !$refresh)return $data;
        $where = array();
        $agentsData = Util :: getNumData("id,agentname", PDO_NAME . 'agentusers', $where);
        $agents = $agentsData[0];
        $children = array();
        if (!empty($agents)){
            $allMoney = 0;
            foreach ($agents as $index => & $row){
                $aMoney = 0;
                $where2['aid'] = $row['id'];
                $data = Util :: getNumData("id,storename,logo", PDO_NAME . 'merchantdata', $where2);
                foreach($data[0] as$k => & $v){
                    $sMoney = 0;
                    $where3['#status#'] = '(1,2,3,4,6,7)';
                    $where3['sid'] = $v['id'];
                    $rush_orders = Util :: getNumData("actualprice", PDO_NAME . 'rush_order', $where3);
                    foreach($rush_orders[0] as $order){
                        $sMoney += $order['actualprice'];
                    }
                    $v['sMoney'] = $sMoney;
                    $aMoney += $sMoney;
                }
                foreach($data[0] as & $money){
                    $money['forpercent'] = sprintf('%.2f', ($money['sMoney'] / $aMoney) * 100);
                }
                $children[$row['id']] = $data[0];
                $row['aMoney'] = $aMoney;
                $allMoney += $aMoney;
            }
        }
        $max = 0;
        foreach ($agents as $index => & $percent){
            $percent['forpercent'] = sprintf('%.2f', ($percent['aMoney'] / $allMoney) * 100);
            $allMoney = sprintf('%.2f', $allMoney);
            $max = $percent['aMoney'] > $max?$max = $percent['aMoney']:$max;
            $max = sprintf('%.2f', $max);
        }
        $time = date('Y-m-d H:i:s', time());
        $data = array($agents, $children, $max, $allMoney, $time);
        Cache :: setCache('sysCashSurvey', 'allData', $data);
        return $data;
    }
    static function agentCashSurvey($refresh = 0){
        global $_W;
        $data = Cache :: getCache('agentCashSurvey', 'allData');
        if($data && !$refresh)return $data;
        $where = array();
        $where['id'] = $_W['agent']['id'];
        $agentsData = Util :: getNumData("id,agentname", PDO_NAME . 'agentusers', $where);
        $agents = $agentsData[0];
        $children = array();
        if (!empty($agents)){
            $allMoney = 0;
            foreach ($agents as $index => & $row){
                $aMoney = 0;
                $where2['aid'] = $row['id'];
                $data = Util :: getNumData("id,storename,logo", PDO_NAME . 'merchantdata', $where2);
                $max = 0;
                foreach($data[0] as$k => & $v){
                    $sMoney = 0;
                    $where3['#status#'] = '(1,2,3,4,6,7)';
                    $where3['sid'] = $v['id'];
                    $rush_orders = Util :: getNumData("actualprice", PDO_NAME . 'rush_order', $where3);
                    foreach($rush_orders[0] as $order){
                        $sMoney += $order['actualprice'];
                    }
                    $v['sMoney'] = $sMoney;
                    $aMoney += $sMoney;
                }
                foreach($data[0] as & $money){
                    $money['forpercent'] = sprintf('%.2f', ($money['sMoney'] / $aMoney) * 100);
                    $max = $money['sMoney'] > $max?$max = $money['sMoney']:$max;
                    $max = sprintf('%.2f', $max);
                }
                $children[$row['id']] = $data[0];
                $row['aMoney'] = $aMoney;
                $allMoney += $aMoney;
            }
        }
        foreach ($agents as $index => & $percent){
            $percent['forpercent'] = sprintf('%.2f', ($percent['aMoney'] / $allMoney) * 100);
            $allMoney = sprintf('%.2f', $allMoney);
        }
        $time = date('Y-m-d H:i:s', time());
        $data = array($agents, $children, $max, $allMoney, $time);
        Cache :: setCache('agentCashSurvey', 'allData', $data);
        return $data;
    }
    static function sysMemberSurvey($refresh = 0){
        $data = Cache :: getCache('sysMemberSurvey', 'allData');
        if($data && !$refresh)return $data;
        $members = Util :: getNumData("*", PDO_NAME . 'member', array('vipstatus' => 1));
        $address_arr['beijing'] = 0;
        $address_arr['tianjing'] = 0;
        $address_arr['shanghai'] = 0;
        $address_arr['chongqing'] = 0;
        $address_arr['hebei'] = 0;
        $address_arr['yunnan'] = 0;
        $address_arr['liaoning'] = 0;
        $address_arr['heilongjiang'] = 0;
        $address_arr['hunan'] = 0;
        $address_arr['anhui'] = 0;
        $address_arr['shandong'] = 0;
        $address_arr['xingjiang'] = 0;
        $address_arr['jiangshu'] = 0;
        $address_arr['zhejiang'] = 0;
        $address_arr['jiangxi'] = 0;
        $address_arr['hubei'] = 0;
        $address_arr['guangxi'] = 0;
        $address_arr['ganshu'] = 0;
        $address_arr['shanxi'] = 0;
        $address_arr['neimenggu'] = 0;
        $address_arr['sanxi'] = 0;
        $address_arr['jiling'] = 0;
        $address_arr['fujian'] = 0;
        $address_arr['guizhou'] = 0;
        $address_arr['guangdong'] = 0;
        $address_arr['qinghai'] = 0;
        $address_arr['xizhang'] = 0;
        $address_arr['shichuan'] = 0;
        $address_arr['ningxia'] = 0;
        $address_arr['hainan'] = 0;
        foreach($members[0] as$key => $value){
            $thisArea = pdo_get(PDO_NAME . 'area', array('id' => $value['areaid']));
            $name = pdo_get(PDO_NAME . 'area', array('id' => $thisArea['pid']));
            $address_name = mb_strcut($name['name'], 0, 6, 'utf-8');
            switch($address_name){
            case '北京':$address_arr['beijing'] += 1;
                break;
            case '天津':$address_arr['tianjing'] += 1;
                break;
            case '上海':$address_arr['shanghai'] += 1;
                break;
            case '重庆':$address_arr['chongqing'] += 1;
                break;
            case '河北':$address_arr['hebei'] += 1;
                break;
            case '河南':$address_arr['henan'] += 1;
                break;
            case '云南':$address_arr['yunnan'] += 1;
                break;
            case '辽宁':$address_arr['liaoning'] += 1;
                break;
            case '黑龙':$address_arr['heilongjiang'] += 1;
                break;
            case '湖南':$address_arr['hunan'] += 1;
                break;
            case '安徽':$address_arr['anhui'] += 1;
                break;
            case '山东':$address_arr['shandong'] += 1;
                break;
            case '新疆':$address_arr['xingjiang'] += 1;
                break;
            case '江苏':$address_arr['jiangshu'] += 1;
                break;
            case '浙江':$address_arr['zhejiang'] += 1;
                break;
            case '江西':$address_arr['jiangxi'] += 1;
                break;
            case '湖北':$address_arr['hubei'] += 1;
                break;
            case '广西':$address_arr['guangxi'] += 1;
                break;
            case '甘肃':$address_arr['ganshu'] += 1;
                break;
            case '山西':$address_arr['shanxi'] += 1;
                break;
            case '内蒙':$address_arr['neimenggu'] += 1;
                break;
            case '陕西':$address_arr['sanxi'] += 1;
                break;
            case '吉林':$address_arr['jiling'] += 1;
                break;
            case '福建':$address_arr['fujian'] += 1;
                break;
            case '贵州':$address_arr['guizhou'] += 1;
                break;
            case '广东':$address_arr['guangdong'] += 1;
                break;
            case '青海':$address_arr['qinghai'] += 1;
                break;
            case '西藏':$address_arr['xizhang'] += 1;
                break;
            case '四川':$address_arr['shichuan'] += 1;
                break;
            case '宁夏':$address_arr['ningxia'] += 1;
                break;
            case '海南':$address_arr['hainan'] += 1;
                break;
            }
        }
        $where = array();
        $stime = strtotime(date('Y-m-d'))-86400;
        $etime = strtotime(date('Y-m-d'));
        $where['createtime>'] = $stime;
        $where['createtime<'] = $etime;
        $where2['paytime>'] = $stime;
        $where2['paytime<'] = $etime;
        $where2['status'] = 1;
        $yesterdayMember = Util :: getNumData("*", PDO_NAME . 'member', $where, 'id desc', 0, 0, 1);
        $yesterdayVip = Util :: getNumData("*", PDO_NAME . 'vip_record', $where2, 'id desc', 0, 0, 1);
        $yesterday[0] = $yesterdayMember[2];
        $yesterday[1] = $yesterdayVip[2];
        $stime = strtotime(date('Y-m-d'));
        $etime = strtotime(date('Y-m-d')) + 86400;
        $where['createtime>'] = $stime;
        $where['createtime<'] = $etime;
        $where2['paytime>'] = $stime;
        $where2['paytime<'] = $etime;
        $where2['status'] = 1;
        $todayMember = Util :: getNumData("*", PDO_NAME . 'member', $where, 'id desc', 0, 0, 1);
        $todayVip = Util :: getNumData("*", PDO_NAME . 'vip_record', $where2, 'id desc', 0, 0, 1);
        $today[0] = $todayMember[2];
        $today[1] = $todayVip[2];
        $stime = strtotime(date('Y-m-d'))-6 * 86400;
        $etime = strtotime(date('Y-m-d')) + 86400;
        $where['createtime>'] = $stime;
        $where['createtime<'] = $etime;
        $where2['paytime>'] = $stime;
        $where2['paytime<'] = $etime;
        $where2['status'] = 1;
        $weekMember = Util :: getNumData("*", PDO_NAME . 'member', $where, 'id desc', 0, 0, 1);
        $weekVip = Util :: getNumData("*", PDO_NAME . 'vip_record', $where2, 'id desc', 0, 0, 1);
        $week[0] = $weekMember[2];
        $week[1] = $weekVip[2];
        $wek_num = array();
        for($i = 1;$i <= 7;$i++){
            $stime = mktime(0, 0 , 0, date("m"), date("d") - date("w") + $i, date("Y"));
            $etime = mktime(23, 59, 59, date("m"), date("d") - date("w") + $i, date("Y"));
            $where['paytime>'] = $stime;
            $where['paytime<'] = $etime;
            $where['status'] = 1;
            $numData = Util :: getNumData("*", PDO_NAME . 'vip_record', $where, 'id desc', 0, 0, 1);
            $wek_num[] = $numData[2];
        }
        $mon_num = array();
        for($i = 1;$i <= 12;$i++){
            $y = date("Y");
            if (in_array($i, array(1, 3, 5, 7, 8, 10, 12))){
                $text = '31';
            }elseif ($i == 2){
                if ($y % 400 == 0 || ($y % 4 == 0 && $y % 100 !== 0)){
                    $text = '29';
                }else{
                    $text = '28';
                }
            }else{
                $text = '30';
            }
            $stime = mktime(0, 0 , 0, $i, 1, date("Y"));
            $etime = mktime(23, 59, 59, $i, $text, date("Y"));
            $where['paytime>'] = $stime;
            $where['paytime<'] = $etime;
            $where['status'] = 1;
            $s = pdo_fetchall("select distinct mid from" . tablename(PDO_NAME . 'vip_record') . "where paytime>'{$stime}' and paytime<'{$etime}' and status=1");
            $mon_num[] = count($s);
            $where3['createtime>'] = $stime;
            $where3['createtime<'] = $etime;
            $noVipMembersData = Util :: getNumData("*", PDO_NAME . 'member', $where3, 'id desc', 0, 0, 1);
            $noVipMembers[] = $noVipMembersData[2];
        }
        $Vip1 = Util :: getNumData("*", PDO_NAME . 'member', array('level' => 1, 'vipstatus' => 1), 'id desc', 0, 0, 1);
        $Vip2 = Util :: getNumData("*", PDO_NAME . 'member', array('level' => 2, 'vipstatus' => 1), 'id desc', 0, 0, 1);
        $Vip3 = Util :: getNumData("*", PDO_NAME . 'member', array('level' => 3, 'vipstatus' => 1), 'id desc', 0, 0, 1);
        $Vip0 = Util :: getNumData("*", PDO_NAME . 'member', array('vipstatus' => 0), 'id desc', 0, 0, 1);
        $time = date("Y-m-d H:i:s", time());
        $Vip[1] = $Vip1[2];
        $Vip[2] = $Vip2[2];
        $Vip[3] = $Vip3[2];
        $Vip[0] = $Vip0[2];
        $merchantNumData = Util :: getNumData("*", PDO_NAME . 'member', array(), 'id desc', 0, 0, 1);
        $firstday = strtotime(date('Y-m-01'));
        $allfans = Util :: getNumData("*", PDO_NAME . 'member', array());
        $data = array(count($members[0]), $address_arr, $yesterday, $week, $wek_num, $mon_num, $noVipMembers, $Vip, $time, $today, $merchantNumData[2], count($allfans[0]));
        Cache :: setCache('sysMemberSurvey', 'allData', $data);
        return $data;
    }
    static function sysAgentSurvey($refresh = 0){
        global $_W, $_GPC;
        $data = Cache :: getCache('sysAgentSurvey', 'allData');
        if($data && !$refresh)return $data;
        $agentsData = Util :: getNumData("id", PDO_NAME . 'agentusers', array('status' => 1));
        $agents = $agentsData[0];
        foreach($agents as $key => & $value){
            $roles = Area :: get_agent_area($value['id']);
            foreach($roles as $k => $v){
                $provs[$k] = intval($v / 10000);
            }
            $nodes = Area :: address_tree_in_use($value['id']);
            foreach($nodes as$kk => $vv){
                if(!in_array(intval($vv['id'] / 10000), $provs))unset($nodes[$kk]);
            }
            $value['nodes'] = $nodes;
            $value['provs'] = $provs;
            $value['roles'] = $roles;
        }
        Cache :: setCache('sysAgentSurvey', 'allData', $agents);
        return $agents;
    }
    static function agentSurvey($refresh = 0){
        global $_W;
        $data = Cache :: getCache('agentSurvey', 'allData');
        if($data && !$refresh)return $data;
        $members = Util :: getNumData("*", PDO_NAME . 'member', array('vipstatus' => 1, 'aid' => $_W['agent']['id']));
        $time = date("Y-m-d H:i:s", time());
        $merchants = Util :: getNumData('id', PDO_NAME . 'merchantdata', array('aid' => $_W['agent']['id']), 'id desc', 0, 0, 1);
        $areaids = Util :: idSwitch('aid', 'areaid', $_W['agent']['id']);
        $s = "(0";
        foreach($areaids as $k => $v){
            $s .= "," . $v['areaid'];
        }
        $s .= ")";
        $today = strtotime(date('Ymd'));
        $firstday = strtotime(date('Y-m-01'));
        $yestoday = $today - 86400;
        $where = array();
        $where['date'] = date('Ymd');
        $where['#areaid#'] = $s;
        $todaypuv = Util :: getSingelData('pv,uv', PDO_NAME . 'puv', $where);
        unset($where['date']);
        $allpuv = Util :: getNumData('pv,uv', PDO_NAME . 'puv', $where);
        $numPv = 0;
        $numUv = 0;
        foreach($allpuv[0] as $k => $v){
            $numPv += $v['pv'];
            $numUv += $v['uv'];
        }
        $newfans = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename(PDO_NAME . 'member') . " WHERE uniacid = '{$_W['uniacid']}' and createtime >= {$firstday}");
        $totalInMoney = $totalOutMoney = $rushMoney = $vipMoney = $halfMoney = $refundMoney = $settlementMoney = $waitSettlementMoney = $spercentMoney = $halfPercentMoney = $vipPercentMoney = 0;
        $rushOrders = Util :: getNumData('actualprice,status', PDO_NAME . 'rush_order', array('#status#' => '(1,2,3,4,6,7)', 'aid' => $_W['agent']['id']));
        foreach($rushOrders[0] as $item){
            $rushMoney += $item['actualprice'];
            if($item['status'] == 7)$refundMoney += $item['actualprice'];
        }
        $vipOrders = Util :: getNumData('price', PDO_NAME . 'vip_record', array('#status#' => '(1)', 'aid' => $_W['agent']['id']));
        foreach($vipOrders[0] as $item){
            $vipMoney += $item['price'];
        }
        $halfOrders = Util :: getNumData('price', PDO_NAME . 'halfcard_record', array('#status#' => '(1)', 'aid' => $_W['agent']['id']));
        foreach($vipOrders[0] as $item){
            $halfMoney += $item['price'];
        }
        $settlementOrders = Util :: getNumData('*', PDO_NAME . 'settlement_record', array('#status#' => '(1,2,3,4,5)', 'aid' => $_W['agent']['id']));
        foreach($settlementOrders[0] as $item){
            if($item['status'] == 5){
                $settlementMoney += $item['sgetmoney'];
            }else{
                $waitSettlementMoney += $item['sapplymoney'];
            }
            if($item['type'] == 1)$spercentMoney += $item['spercentmoney'];
            if($item['type'] == 2)$halfPercentMoney += $item['agetmoney'];
            if($item['type'] == 3)$vipPercentMoney += $item['agetmoney'];
        }
        $totalInMoney = sprintf("%.2f", $rushMoney + $vipMoney + $halfMoney);
        $totalOutMoney = sprintf("%.2f", $refundMoney + $settlementMoney);
        $spercentMoney = sprintf("%.2f", $spercentMoney);
        $halfPercentMoney = sprintf("%.2f", $halfPercentMoney);
        $vipPercentMoney = sprintf("%.2f", $vipPercentMoney);
        $settlementMoney = sprintf("%.2f", $settlementMoney);
        $waitSettlementMoney = sprintf("%.2f", $waitSettlementMoney);
        $data = array(count($merchants[0]), count($members[0]), 0, $time, $todaypuv, $numPv, $numUv, $newfans, $totalInMoney, $totalOutMoney, $spercentMoney, $halfPercentMoney, $vipPercentMoney, $settlementMoney, $waitSettlementMoney);
        Cache :: setCache('agentSurvey', 'allData', $data);
        return $data;
    }
    static function agentMemberSurvey($refresh = 0){
        global $_W;
        $data = Cache :: getCache('memberSurvey', 'allData');
        if($data && !$refresh)return $data;
        $members = Util :: getNumData("*", PDO_NAME . 'member', array('vipstatus' => 1, 'aid' => $_W['agent']['id']));
        $address_arr['beijing'] = 0;
        $address_arr['tianjing'] = 0;
        $address_arr['shanghai'] = 0;
        $address_arr['chongqing'] = 0;
        $address_arr['hebei'] = 0;
        $address_arr['yunnan'] = 0;
        $address_arr['liaoning'] = 0;
        $address_arr['heilongjiang'] = 0;
        $address_arr['hunan'] = 0;
        $address_arr['anhui'] = 0;
        $address_arr['shandong'] = 0;
        $address_arr['xingjiang'] = 0;
        $address_arr['jiangshu'] = 0;
        $address_arr['zhejiang'] = 0;
        $address_arr['jiangxi'] = 0;
        $address_arr['hubei'] = 0;
        $address_arr['guangxi'] = 0;
        $address_arr['ganshu'] = 0;
        $address_arr['shanxi'] = 0;
        $address_arr['neimenggu'] = 0;
        $address_arr['sanxi'] = 0;
        $address_arr['jiling'] = 0;
        $address_arr['fujian'] = 0;
        $address_arr['guizhou'] = 0;
        $address_arr['guangdong'] = 0;
        $address_arr['qinghai'] = 0;
        $address_arr['xizhang'] = 0;
        $address_arr['shichuan'] = 0;
        $address_arr['ningxia'] = 0;
        $address_arr['hainan'] = 0;
        foreach($members[0] as$key => $value){
            $thisArea = pdo_get(PDO_NAME . 'area', array('id' => $value['areaid']));
            $name = pdo_get(PDO_NAME . 'area', array('id' => $thisArea['pid']));
            $address_name = mb_strcut($name['name'], 0, 6, 'utf-8');
            switch($address_name){
            case '北京':$address_arr['beijing'] += 1;
                break;
            case '天津':$address_arr['tianjing'] += 1;
                break;
            case '上海':$address_arr['shanghai'] += 1;
                break;
            case '重庆':$address_arr['chongqing'] += 1;
                break;
            case '河北':$address_arr['hebei'] += 1;
                break;
            case '河南':$address_arr['henan'] += 1;
                break;
            case '云南':$address_arr['yunnan'] += 1;
                break;
            case '辽宁':$address_arr['liaoning'] += 1;
                break;
            case '黑龙':$address_arr['heilongjiang'] += 1;
                break;
            case '湖南':$address_arr['hunan'] += 1;
                break;
            case '安徽':$address_arr['anhui'] += 1;
                break;
            case '山东':$address_arr['shandong'] += 1;
                break;
            case '新疆':$address_arr['xingjiang'] += 1;
                break;
            case '江苏':$address_arr['jiangshu'] += 1;
                break;
            case '浙江':$address_arr['zhejiang'] += 1;
                break;
            case '江西':$address_arr['jiangxi'] += 1;
                break;
            case '湖北':$address_arr['hubei'] += 1;
                break;
            case '广西':$address_arr['guangxi'] += 1;
                break;
            case '甘肃':$address_arr['ganshu'] += 1;
                break;
            case '山西':$address_arr['shanxi'] += 1;
                break;
            case '内蒙':$address_arr['neimenggu'] += 1;
                break;
            case '陕西':$address_arr['sanxi'] += 1;
                break;
            case '吉林':$address_arr['jiling'] += 1;
                break;
            case '福建':$address_arr['fujian'] += 1;
                break;
            case '贵州':$address_arr['guizhou'] += 1;
                break;
            case '广东':$address_arr['guangdong'] += 1;
                break;
            case '青海':$address_arr['qinghai'] += 1;
                break;
            case '西藏':$address_arr['xizhang'] += 1;
                break;
            case '四川':$address_arr['shichuan'] += 1;
                break;
            case '宁夏':$address_arr['ningxia'] += 1;
                break;
            case '海南':$address_arr['hainan'] += 1;
                break;
            }
        }
        $where = array();
        $stime = strtotime(date('Y-m-d'))-86400;
        $etime = strtotime(date('Y-m-d'));
        $where['paytime>'] = $stime;
        $where['paytime<'] = $etime;
        $where['status'] = 1;
        $where['aid'] = $_W['agent']['id'];
        $yesterdayVip = Util :: getNumData("*", PDO_NAME . 'vip_record', $where, 'id desc', 0, 0, 1);
        $stime = strtotime(date('Y-m-d'));
        $etime = strtotime(date('Y-m-d')) + 86400;
        $where['paytime>'] = $stime;
        $where['paytime<'] = $etime;
        $where['status'] = 1;
        $where['aid'] = $_W['agent']['id'];
        $todayVip = Util :: getNumData("*", PDO_NAME . 'vip_record', $where, 'id desc', 0, 0, 1);
        $stime = strtotime(date('Y-m-d'))-6 * 86400;
        $etime = strtotime(date('Y-m-d')) + 86400;
        $where['paytime>'] = $stime;
        $where['paytime<'] = $etime;
        $where['status'] = 1;
        $where['aid'] = $_W['agent']['id'];
        $weekVip = Util :: getNumData("*", PDO_NAME . 'vip_record', $where, 'id desc', 0, 0, 1);
        $data = array(count($members), $address_arr, $yesterdayVip, $todayVip, $weekVip);
        Cache :: setCache('agentMemberSurvey', 'allData', $data);
        return $data;
    }
}
