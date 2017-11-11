<?php
 class SingleMerchant{
    static function getSingleMerchant($id, $select, $where = array()){
        $id = intval($id);
        $where['id'] = $id;
        return Util :: getSingelData($select, PDO_NAME . 'merchantdata', $where);
    }
    static function getMoneyRecord($sid, $pindex, $psize, $ifpage){
        return Util :: getNumData('*', PDO_NAME . 'merchant_money_record', array('sid' => $sid), 'createtime desc', $pindex, $psize, $ifpage);
    }
    static function updateAmount($money, $sid, $orderid, $type = 1, $detail = ''){
        global $_W;
        if(empty($sid))return FALSE;
        $merchant = pdo_fetch("select amount from" . tablename(PDO_NAME . 'merchant_account') . "where uniacid={$_W['uniacid']} and sid={$sid} ");
        pdo_insert(PDO_NAME . 'merchant_money_record', array('sid' => $sid, 'uniacid' => $_W['uniacid'], 'money' => $money, 'orderid' => $orderid, 'createtime' => TIMESTAMP, 'type' => $type, 'detail' => $detail));
        $order = pdo_get(PDO_NAME . 'rush_order', array('id' => $orderid), 'mid');
        pdo_query('UPDATE ' . tablename(PDO_NAME . 'member') . " SET `dealmoney` = `dealmoney` + {$money}  WHERE id={$order['mid']}");
        pdo_query('UPDATE ' . tablename(PDO_NAME . 'member') . " SET `dealnum` = `dealnum` + 1  WHERE id={$order['mid']}");
        if(empty($merchant)){
            return pdo_insert(PDO_NAME . 'merchant_account', array('no_money' => 0, 'sid' => $sid, 'uniacid' => $_W['uniacid'], 'uid' => $_W['uid'], 'amount' => $money, 'updatetime' => TIMESTAMP));
        }else{
            return pdo_update(PDO_NAME . 'merchant_account', array('amount' => $merchant['amount'] + $money), array('sid' => $sid));
        }
    }
    static function updateNoSettlementMoney($money, $sid){
        global $_W;
        if(empty($sid))return FALSE;
        $merchant = pdo_fetch("select no_money from" . tablename(PDO_NAME . 'merchant_account') . "where uniacid={$_W['uniacid']} and sid={$sid} ");
        if(empty($merchant)){
            return pdo_insert(PDO_NAME . 'merchant_account', array('no_money' => 0, 'sid' => $sid, 'uniacid' => $_W['uniacid'], 'uid' => $_W['uid'], 'amount' => 0, 'updatetime' => TIMESTAMP));
        }else{
            $m = $merchant['no_money'] + $money;
            if($m < 0)return FALSE;
            else return pdo_update(PDO_NAME . 'merchant_account', array('no_money' => $merchant['no_money'] + $money, 'updatetime' => TIMESTAMP), array('sid' => $sid));
        }
    }
    static function getNoSettlementMoney($sid){
        global $_W;
        $merchant = pdo_fetch("select no_money from" . tablename(PDO_NAME . 'merchant_account') . "where uniacid={$_W['uniacid']} and sid={$sid} ");
        return $merchant['no_money'];
    }
    static function finance($openid = '', $money = 0, $desc = ''){
        global $_W;
        load() -> func('communication');
        $setting = uni_setting($_W['uniacid'], array('payment'));
        if (empty($openid))return error(-1, 'openid不能为空');
        if (!is_array($setting['payment']))return error(1, '没有设定支付参数');
        $wechat = $setting['payment']['wechat'];
        $sql = 'SELECT `key`,`secret` FROM ' . tablename('account_wechats') . ' WHERE `uniacid`=:uniacid limit 1';
        $row = pdo_fetch($sql, array(':uniacid' => $_W['uniacid']));
        $url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
        $pars = array();
        $pars['mch_appid'] = $row['key'];
        $pars['mchid'] = $wechat['mchid'];
        $pars['nonce_str'] = random(32);
        $pars['partner_trade_no'] = time() . random(4, true);
        $pars['openid'] = $openid;
        $pars['check_name'] = 'NO_CHECK';
        $pars['amount'] = $money;
        $pars['desc'] = empty($desc)? '商家佣金提现' : $desc;
        $pars['spbill_create_ip'] = gethostbyname($_SERVER["HTTP_HOST"]);
        ksort($pars, SORT_STRING);
        $string1 = '';
        foreach ($pars as $k => $v){
            $string1 .= "{$k}={$v}&";
        }
        $string1 .= "key=" . $wechat['apikey'];
        $pars['sign'] = strtoupper(md5($string1));
        $xml = array2xml($pars);
        $path_cert = IA_ROOT . '/attachment/feng_fightgroups/cert/' . $_W['uniacid'] . '/apiclient_cert.pem';
        $path_key = IA_ROOT . '/attachment/feng_fightgroups/cert/' . $_W['uniacid'] . '/apiclient_key.pem';
        if (!file_exists($path_cert) || !file_exists($path_key)){
            $path_cert = IA_ROOT . '/addons/feng_fightgroups/cert/' . $_W['uniacid'] . '/apiclient_cert.pem';
            $path_key = IA_ROOT . '/addons/feng_fightgroups/cert/' . $_W['uniacid'] . '/apiclient_key.pem';
        }
        $extras = array();
        $extras['CURLOPT_SSLCERT'] = $path_cert;
        $extras['CURLOPT_SSLKEY'] = $path_key;
        $resp = ihttp_request($url, $xml, $extras);
        if (empty($resp['content'])){
            return error(-2, '网络错误');
        }else{
            $arr = json_decode(json_encode((array) simplexml_load_string($resp['content'])), true);
            $xml = '<?xml version="1.0" encoding="utf-8"?>' . $resp['content'];
            $dom = new \DOMDocument();
            if ($dom -> loadXML($xml)){
                $xpath = new \DOMXPath($dom);
                $code = $xpath -> evaluate('string(//xml/return_code)');
                $ret = $xpath -> evaluate('string(//xml/result_code)');
                if (strtolower($code) == 'success' && strtolower($ret) == 'success'){
                    return true;
                }else{
                    $error = $xpath -> evaluate('string(//xml/err_code_des)');
                    return error(-2, $error);
                }
            }else{
                return error(-1, '未知错误');
            }
        }
    }
    static function verifier($sid, $mid){
        global $_W;
        if(empty($sid) || empty($mid))return FALSE;
        $merchantuser = Util :: getSingelData("*", PDO_NAME . 'merchantuser', array('storeid' => $sid, 'mid' => $mid));
        if($merchantuser['ismain'] == 2 || $merchantuser['ismain'] == 1){
            return TRUE;
        }
        return FALSE;
    }
}
