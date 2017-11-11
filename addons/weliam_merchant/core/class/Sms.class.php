<?php
if (!defined('IN_IA')){
    exit('Access Denied');
}
class Sms{
    static function sendSms($note_code, $param, $mobile){
        global $_W;
        m('alidayu/topclient') -> appkey = $_W['wlsetting']['sms']['note_appkey'];
        m('alidayu/topclient') -> secretKey = $_W['wlsetting']['sms']['note_secretKey'];
        m('alidayu/smsnum') -> setSmsType('normal');
        m('alidayu/smsnum') -> setSmsFreeSignName($_W['wlsetting']['sms']['note_sign']);
        m('alidayu/smsnum') -> setSmsParam(json_encode($param));
        m('alidayu/smsnum') -> setRecNum($mobile);
        m('alidayu/smsnum') -> setSmsTemplateCode($note_code);
        $resp = m('alidayu/topclient') -> execute(m('alidayu/smsnum'), '6100e23657fb0b2d0c78568e55a3031134be9a3a5d4b3a365753805');
        $res = Util :: object_array($resp);
        return $res;
    }
    static function replaceTemplate($str, $datas = array()){
        foreach ($datas as $d){
            $str = str_replace('【' . $d['name'] . '】', $d['value'], $str);
        }
        return $str;
    }
    static function create_apirecord($sendmid, $sendmobile = '', $takemid, $takemobile, $type, $remark){
        global $_W;
        $data = array('uniacid' => $_W['uniacid'], 'sendmid' => $sendmid, 'sendmobile' => $sendmobile, 'takemid' => $takemid, 'takemobile' => $takemobile, 'type' => $type, 'remark' => $remark, 'createtime' => time());
        pdo_insert(PDO_NAME . 'apirecord', $data);
    }
    static function smsSF($code, $mobile){
        global $_W;
        $smses = pdo_fetch("select * from" . tablename(PDO_NAME . 'smstpl') . "where uniacid=:uniacid and id=:id", array(':uniacid' => $_W['uniacid'], ':id' => $_W['wlsetting']['smsset']['dy_sf']));
        $param = unserialize($smses['data']);
        $datas = array(array('name' => '系统名称', 'value' => $_W['wlsetting']['base']['name']), array('name' => '版权信息', 'value' => $_W['wlsetting']['base']['copyright']), array('name' => '验证码', 'value' => $code));
        foreach ($param as $d){
            $params[$d['data_temp']] = self :: replaceTemplate($d['data_shop'], $datas);
        }
        return self :: sendSms($smses['smstplid'], $params, $mobile);
    }
}
