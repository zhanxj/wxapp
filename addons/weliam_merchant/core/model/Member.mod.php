<?php
defined('IN_IA')or exit('Access Denied');
class Member{
    static function wl_member_auth($openid = ''){
        global $_W, $_GPC;
        if (empty($openid)){
            $openid = $_W['openid'];
        }
        if (empty($openid)){
            if (!DEVELOPMENT){
                die("<!DOCTYPE html>
		        <html>
		            <head>
		                <meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'>
		                <title>抱歉，出错了</title><meta charset='utf-8'><meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'><link rel='stylesheet' type='text/css' href='https://res.wx.qq.com/connect/zh_CN/htmledition/style/wap_err1a9853.css'>
		            </head>
		            <body>
		            <div class='page_msg'><div class='inner'><span class='msg_icon_wrp'><i class='icon80_smile'></i></span><div class='msg_content'><h4>请在微信客户端打开链接</h4></div></div></div>
		            </body>
		        </html>");
            }
            return;
        }
        load() -> model('mc');
        $member = pdo_get(PDO_NAME . 'member', array('uniacid' => $_W['uniacid'], 'openid' => $openid));
        $userinfo = mc_oauth_userinfo();
        $uid = 0;
        if($_W['fans']['follow'] == 1){
            $uid = mc_openid2uid($openid);
        }
        if (empty($member)){
            $member = array('uid' => $uid, 'uniacid' => $_W['uniacid'], 'openid' => $userinfo['openid'], 'nickname' => $userinfo['nickname'], 'avatar' => $userinfo['avatar'], 'gender' => $userinfo['sex'], 'unionid' => $userinfo['unionid'], 'createtime' => time());
            pdo_insert(PDO_NAME . 'member', $member);
            $member['id'] = pdo_insertid();
        }else{
            $upgrade = array();
            if (!empty($uid)){
                if (0 < $member['credit1']){
                    $upgrade['credit1'] = 0;
                    mc_credit_update($uid, 'credit1', $member['credit1']);
                }
                if (0 < $member['credit2']){
                    $upgrade['credit2'] = 0;
                    mc_credit_update($uid, 'credit2', $member['credit2']);
                }
            }
            if (!empty($member['id'])){
                if ($userinfo['nickname'] != $member['nickname']){
                    $upgrade['nickname'] = $userinfo['nickname'];
                }
                if ($userinfo['avatar'] != $member['avatar']){
                    $upgrade['avatar'] = $userinfo['avatar'];
                }
                if ($userinfo['sex'] != $member['gender']){
                    $upgrade['gender'] = $userinfo['sex'];
                }
                if ($userinfo['unionid'] != $member['unionid']){
                    $upgrade['unionid'] = $userinfo['unionid'];
                }
                if ($member['uid'] != $uid){
                    $upgrade['uid'] = $uid;
                }
                if (!empty($upgrade)){
                    pdo_update(PDO_NAME . 'member', $upgrade, array('id' => $member['id']));
                }
            }
        }
        $lastviptime = self :: vip($member['id']);
        unset($member, $userinfo, $upgrade, $uid);
        return self :: getMemberByMid($openid);
    }
    static function getMemberByMid($id, $arr = ''){
        global $_W;
        $flag = intval($id);
        if(empty($flag)){
            $re = pdo_get(PDO_NAME . 'member', array('uniacid' => $_W['uniacid'], 'openid' => $id), $arr);
        }else{
            $re = pdo_get(PDO_NAME . 'member', array('uniacid' => $_W['uniacid'], 'id' => $id), $arr);
        }
        if (!empty($re['uid'])){
            $credits = self :: credit_get_by_uid($re['uid']);
            $re['credit1'] = $credits['credit1'];
            $re['credit2'] = $credits['credit2'];
        }
        return $re;
    }
    static function getAllMember($page = 0, $pagenum = 10, $isvip = 0){
        global $_W;
        if(empty($isvip))$isvip = 0;
        $re['data'] = pdo_fetchall("select * from" . tablename(PDO_NAME . 'member') . "where uniacid=:uniacid and isvip=:isvip order by createtime desc limit " . $page * $pagenum . "," . $pagenum, array(':uniacid' => $_W['uniacid'], ':isvip' => $isvip));
        $re['count'] = pdo_fetchcolumn("select count(*) from" . tablename(PDO_NAME . 'member') . "where uniacid=:uniacid and order by createtime desc limit " . $page * $pagenum . "," . $pagenum, array(':uniacid' => $_W['uniacid']));
        return $re;
    }
    static function getSelectMember($page = 0, $pagenum = 10, $arr, $params){
        global $_W;
        $re['data'] = pdo_fetchall("select * from" . tablename(PDO_NAME . 'member') . "$arr  order by createtime desc limit " . $page * $pagenum . "," . $pagenum, $params);
        $re['count'] = pdo_fetchcolumn("select count(*) from" . tablename(PDO_NAME . 'member') . "where uniacid=:uniacid  order by createtime desc limit " . $page * $pagenum . "," . $pagenum, array(':uniacid' => $_W['uniacid']));
        return $re;
    }
    static function creditGetByUid($uid){
        global $_W;
        $result = pdo_fetch("select credit1,credit2 from" . tablename(PDO_NAME . 'member') . "where uid=:uid and uniacid=:uniacid", array(':uid' => $uid, ':uniacid' => $_W['uniacid']));
        return $result;
    }
    static function creditUpdateCredit1($uid, $credit1 = 0, $remark){
        global $_W;
        $info = pdo_fetch("select credit1,credit2 from" . tablename(PDO_NAME . 'member') . "where uid=:uid and uniacid=:uniacid", array(':uid' => $uid, ':uniacid' => $_W['uniacid']));
        if(pdo_update(PDO_NAME . 'member', array('credit1' => $info['credit1'] + $credit1), array('uid' => $uid, 'uniacid' => $_W['uniacid']))){
            $data = array('uid' => $uid, 'uniacid' => $_W['uniacid'], 'openid' => '', 'num' => $credit1, 'createtime' => TIMESTAMP, 'status' => 1, 'type' => 1, 'paytype' => 1, 'table' => 1, 'remark' => $remark);
            pdo_insert(PDO_NAME . 'creditrecord', $data);
            return TRUE;
        }
        return FALSE;
    }
    static function creditUpdateCredit2($uid, $credit2 = 0, $remark){
        global $_W;
        $info = pdo_fetch("select credit1,credit2 from" . tablename(PDO_NAME . 'member') . "where uid=:uid and uniacid=:uniacid", array(':uid' => $uid, ':uniacid' => $_W['uniacid']));
        if(pdo_update(PDO_NAME . 'member', array('credit2' => $info['credit2'] + $credit2), array('uid' => $uid, 'uniacid' => $_W['uniacid']))){
            $data = array('uid' => $uid, 'uniacid' => $_W['uniacid'], 'openid' => '', 'num' => $credit2, 'createtime' => TIMESTAMP, 'status' => 2, 'type' => 2, 'paytype' => 2, 'table' => 1, 'remark' => $remark);
            pdo_insert(PDO_NAME . 'creditrecord', $data);
            return TRUE;
        }
        return FALSE;
    }
    static function creditUpdate($uid, $arr){
        global $_W;
        if(empty($arr))return FALSE;
        return pdo_update(PDO_NAME . 'member', $arr, array('uid' => $uid, 'uniacid' => $_W['uniacid']));
    }
    static function getSingleRecord($uid, $status){
        global $_W;
        $re = pdo_fetchall("select * from" . tablename(PDO_NAME . 'creditrecord') . "where uid=:uid and uniacid=:uniacid and status=:status order by createtime desc", array(':uid' => $uid, ':uniacid' => $_W['uniacid'], ':status' => $status));
        return $re;
    }
    static function getSingleUser($uid){
        global $_W;
        if(empty($uid))return FALSE;
        $re = pdo_get(PDO_NAME . 'member', array('uniacid' => $_W['uniacid'], 'uid' => $uid));
        return $re;
    }
    static function vip($id){
        global $_W;
        $vipInfo = Util :: getSingelData(' lastviptime ', PDO_NAME . "member", array('uniacid' => $_W['uniacid'], 'id' => $id));
        $viptime = $vipInfo['lastviptime'] - time();
        if($viptime < 0){
            pdo_update(PDO_NAME . 'member', array('vipstatus' => 0, 'vipleveldays' => 0), array('id' => $id));
            return FALSE;
        }else{
            $vipleveltime = floor($viptime / (24 * 60 * 60));
            pdo_update(PDO_NAME . 'member', array('vipstatus' => 1, 'vipleveldays' => $vipleveltime), array('id' => $id));
            return $vipInfo['lastviptime'];
        }
    }
    static function credit_get_by_uid($uid = '' , $credit_type = 1){
        global $_W;
        if($credit_type == 1){
            load() -> model('mc');
            $result = mc_fetch($uid, array('credit1', 'credit2'));
        }
        if($credit_type == 2){
            $result = pdo_fetch("select credit1,credit2 from" . tablename(PDO_NAME . "creditrecord") . "where uid=:uid and uniacid=:uniacid", array(':uid' => $uid, ':uniacid' => $_W['uniacid']));
        }
        return $result;
    }
    static function credit_update_credit1($uid , $credit1 = 0, $credit_type = 1, $remark = ''){
        global $_W;
        if(empty($uid))$credit_type = 2;
        if($credit_type == 1){
            load() -> model('mc');
            $f = mc_credit_update($uid, 'credit1', $credit1, array($uid, '智慧城市积分操作', 'weliam_merchant'));
            if($f){
                $data = array('uid' => $uid, 'uniacid' => $_W['uniacid'], 'openid' => '', 'num' => $credit1, 'createtime' => TIMESTAMP, 'status' => 1, 'type' => 1, 'paytype' => 2, 'table' => 1, 'remark' => $remark);
                pdo_insert(PDO_NAME . 'creditrecord', $data);
                return TRUE;
            }
            return FALSE;
        }
        if($credit_type == 2){
            $info = pdo_fetch("select credit1,credit2 from" . tablename(PDO_NAME . "creditrecord") . "where uid=:uid and uniacid=:uniacid", array(':uid' => $uid, ':uniacid' => $_W['uniacid']));
            $flag = pdo_update(PDO_NAME . "member", array('credit1' => $info['credit1'] + $credit1), array('uid' => $uid, 'uniacid' => $_W['uniacid']));
            if($flag){
                $data = array('uid' => $uid, 'uniacid' => $_W['uniacid'], 'openid' => '', 'num' => $credit1, 'createtime' => TIMESTAMP, 'status' => 1, 'type' => 1, 'paytype' => 2, 'table' => 2, 'remark' => $remark);
                pdo_insert(PDO_NAME . 'creditrecord', $data);
                return TRUE;
            }
            return FALSE;
        }
    }
    static function credit_update_credit2($uid , $credit2 = 0, $credit_type = 1, $remark = ''){
        global $_W;
        if(empty($uid))$credit_type = 2;
        if($credit_type == 1){
            load() -> model('mc');
            $f = mc_credit_update($uid, 'credit2', $credit2, array($uid, '智慧城市余额操作', 'weliam_merchant'));
            if($f){
                $data = array('uid' => $uid, 'uniacid' => $_W['uniacid'], 'openid' => '', 'num' => $credit2, 'createtime' => TIMESTAMP, 'status' => 2, 'type' => 2, 'paytype' => 2, 'table' => 1, 'remark' => $remark);
                pdo_insert(PDO_NAME . 'creditrecord', $data);
                return TRUE;
            }
            return FALSE;
        }
        if($credit_type == 2){
            $info = pdo_fetch("select credit1,credit2 from" . tablename(PDO_NAME . "creditrecord") . "where uid=:uid and uniacid=:uniacid", array(':uid' => $uid, ':uniacid' => $_W['uniacid']));
            if(pdo_update(PDO_NAME . 'member', array('credit2' => $info['credit2'] + $credit2), array('uid' => $uid, 'uniacid' => $_W['uniacid']))){
                $data = array('uid' => $uid, 'uniacid' => $_W['uniacid'], 'openid' => '', 'num' => $credit2, 'createtime' => TIMESTAMP, 'status' => 2, 'type' => 2, 'paytype' => 2, 'table' => 2, 'remark' => $remark);
                pdo_insert(PDO_NAME . 'creditrecord', $data);
                return TRUE;
            }
            return FALSE;
        }
    }
}
