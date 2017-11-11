<?php
defined('IN_IA')or exit('Access Denied');
class Dashboard{
    static function readSetting($key){
        global $_W;
        $settings = pdo_get(PDO_NAME . 'indexset', array('key' => $key, 'uniacid' => $_W['uniacid'], 'aid' => $_W['aid']), array('value'));
        if (is_array($settings)){
            $settings = iunserializer($settings['value']);
        }else{
            $settings = array();
        }
        return $settings;
    }
    static function saveSetting($data, $key){
        global $_W;
        if (empty($key))return FALSE;
        $record = array();
        $record['value'] = iserializer($data);
        $exists = pdo_getcolumn(PDO_NAME . 'indexset', array('key' => $key, 'uniacid' => $_W['uniacid'], 'aid' => $_W['aid']), 'id');
        if ($exists){
            $return = pdo_update(PDO_NAME . 'indexset', $record, array('key' => $key, 'uniacid' => $_W['uniacid'], 'aid' => $_W['aid']));
        }else{
            $record['key'] = $key;
            $record['uniacid'] = $_W['uniacid'];
            $record['aid'] = $_W['aid'];
            $return = pdo_insert(PDO_NAME . 'indexset', $record);
        }
        return $return;
    }
    static function getAllNotice($page = 0, $pagenum = 10, $enabled = ''){
        global $_W;
        $condition = '';
        if(!empty($enabled) && $enabled != '')$condition = " and enabled=" . $enabled;
        $re['data'] = pdo_fetchall("select * from" . tablename(PDO_NAME . 'notice') . "where uniacid=:uniacid and aid=:aid " . $condition . " order by enabled desc, createtime desc limit " . $page * $pagenum . "," . $pagenum, array(':uniacid' => $_W['uniacid'], ':aid' => $_W['aid']));
        $re['count'] = pdo_fetchcolumn("select count(*) from" . tablename(PDO_NAME . 'notice') . "where uniacid=:uniacid and aid=:aid " . $condition, array(':uniacid' => $_W['uniacid'], ':aid' => $_W['aid']));
        return $re;
    }
    static function editNotice($arr, $id = ''){
        global $_W;
        if(empty($arr))return false;
        if(!empty($id) && $id != '')return pdo_update(PDO_NAME . 'notice', $arr, array('id' => $id, 'uniacid' => $_W['uniacid'], 'aid' => $_W['aid']));
        $arr['aid'] = $_W['aid'];
        $arr['uniacid'] = $_W['uniacid'];
        return pdo_insert(PDO_NAME . 'notice', $arr);
    }
    static function getSingleNotice($id){
        global $_W;
        if(empty($id))return false;
        return pdo_get(PDO_NAME . 'notice', array('id' => $id, 'uniacid' => $_W['uniacid'], 'aid' => $_W['aid']));
    }
    static function deleteNotice($id){
        global $_W;
        if(empty($id))return false;
        return pdo_delete(PDO_NAME . 'notice', array('id' => $id, 'uniacid' => $_W['uniacid'], 'aid' => $_W['aid']));
    }
    static function getAllAdv($page = 0, $pagenum = 10, $enabled = ''){
        global $_W;
        $condition = '';
        if(!empty($enabled) && $enabled != '')$condition = " and enabled=" . $enabled;
        $re['data'] = pdo_fetchall("select * from" . tablename(PDO_NAME . 'adv') . "where uniacid=:uniacid and aid=:aid " . $condition . " order by enabled desc, displayorder desc limit " . $page * $pagenum . "," . $pagenum, array(':uniacid' => $_W['uniacid'], ':aid' => $_W['aid']));
        $re['count'] = pdo_fetchcolumn("select count(*) from" . tablename(PDO_NAME . 'adv') . "where uniacid=:uniacid and aid=:aid " . $condition, array(':uniacid' => $_W['uniacid'], ':aid' => $_W['aid']));
        return $re;
    }
    static function editAdv($arr, $id = ''){
        global $_W;
        if(empty($arr))return false;
        if(!empty($id) && $id != '')return pdo_update(PDO_NAME . 'adv', $arr, array('id' => $id, 'uniacid' => $_W['uniacid'], 'aid' => $_W['aid']));
        $arr['aid'] = $_W['aid'];
        $arr['uniacid'] = $_W['uniacid'];
        return pdo_insert(PDO_NAME . 'adv', $arr);
    }
    static function getSingleAdv($id){
        global $_W;
        if(empty($id))return false;
        return pdo_get(PDO_NAME . 'adv', array('id' => $id, 'uniacid' => $_W['uniacid'], 'aid' => $_W['aid']));
    }
    static function deleteAdv($id){
        global $_W;
        if(empty($id))return false;
        return pdo_delete(PDO_NAME . 'adv', array('id' => $id, 'uniacid' => $_W['uniacid'], 'aid' => $_W['aid']));
    }
    static function getAllNav($page = 0, $pagenum = 10, $enabled = ''){
        global $_W;
        $condition = '';
        if(!empty($enabled) && $enabled != '')$condition = " and enabled=" . $enabled;
        $re['data'] = pdo_fetchall("select * from" . tablename(PDO_NAME . 'nav') . "where uniacid=:uniacid and aid=:aid " . $condition . " order by enabled desc, displayorder desc limit " . $page * $pagenum . "," . $pagenum, array(':uniacid' => $_W['uniacid'], ':aid' => $_W['aid']));
        $re['count'] = pdo_fetchcolumn("select count(*) from" . tablename(PDO_NAME . 'nav') . "where uniacid=:uniacid and aid=:aid " . $condition, array(':uniacid' => $_W['uniacid'], ':aid' => $_W['aid']));
        return $re;
    }
    static function editNav($arr, $id = ''){
        global $_W;
        if(empty($arr))return false;
        if(!empty($id) && $id != '')return pdo_update(PDO_NAME . 'nav', $arr, array('id' => $id, 'uniacid' => $_W['uniacid'], 'aid' => $_W['aid']));
        $arr['aid'] = $_W['aid'];
        $arr['uniacid'] = $_W['uniacid'];
        return pdo_insert(PDO_NAME . 'nav', $arr);
    }
    static function getSingleNav($id){
        global $_W;
        if(empty($id))return false;
        return pdo_get(PDO_NAME . 'nav', array('id' => $id, 'uniacid' => $_W['uniacid'], 'aid' => $_W['aid']));
    }
    static function deleteNav($id){
        global $_W;
        if(empty($id))return false;
        return pdo_delete(PDO_NAME . 'nav', array('id' => $id, 'uniacid' => $_W['uniacid'], 'aid' => $_W['aid']));
    }
    static function getAllBanner($page = 0, $pagenum = 10, $enabled = ''){
        global $_W;
        $condition = '';
        if(!empty($enabled) && $enabled != '')$condition = " and enabled=" . $enabled;
        $re['data'] = pdo_fetchall("select * from" . tablename(PDO_NAME . 'banner') . "where uniacid=:uniacid and aid=:aid " . $condition . " order by enabled desc, displayorder desc limit " . $page * $pagenum . "," . $pagenum, array(':uniacid' => $_W['uniacid'], ':aid' => $_W['aid']));
        $re['count'] = pdo_fetchcolumn("select count(*) from" . tablename(PDO_NAME . 'banner') . "where uniacid=:uniacid and aid=:aid " . $condition, array(':uniacid' => $_W['uniacid'], ':aid' => $_W['aid']));
        return $re;
    }
    static function editBanner($arr, $id = ''){
        global $_W;
        if(empty($arr))return false;
        if(!empty($id) && $id != '')return pdo_update(PDO_NAME . 'banner', $arr, array('id' => $id, 'uniacid' => $_W['uniacid'], 'aid' => $_W['aid']));
        $arr['aid'] = $_W['aid'];
        $arr['uniacid'] = $_W['uniacid'];
        return pdo_insert(PDO_NAME . 'banner', $arr);
    }
    static function getSingleBanner($id){
        global $_W;
        if(empty($id))return false;
        return pdo_get(PDO_NAME . 'banner', array('id' => $id, 'uniacid' => $_W['uniacid'], 'aid' => $_W['aid']));
    }
    static function deleteBanner($id){
        global $_W;
        if(empty($id))return false;
        return pdo_delete(PDO_NAME . 'banner', array('id' => $id, 'uniacid' => $_W['uniacid'], 'aid' => $_W['aid']));
    }
    static function get_app_data(){
        global $_W;
        $default_page = array(array('on' => 1, 'sort' => 'search'), array('on' => 1, 'sort' => 'adv'), array('on' => 1, 'sort' => 'nav'), array('on' => 1, 'sort' => 'notice'), array('on' => 1, 'sort' => 'banner'), array('on' => 1, 'sort' => 'cube'), array('on' => 1, 'sort' => 'discard'), array('on' => 1, 'sort' => 'nearby'));
        $load_page = self :: readSetting('sort');
        $page = !empty($load_page)? $load_page : $default_page;
        $advs = pdo_getall(PDO_NAME . 'adv', array('enabled' => 1, 'uniacid' => $_W['uniacid'], 'aid' => $_W['aid']));
        foreach ($advs as & $adv){
            if (substr($adv['link'], 0, 5) != 'http:'){
                $adv['link'] = "http://" . $adv['link'];
            }
        }
        unset($adv);
        $nav = pdo_fetchall("SELECT * FROM " . tablename(PDO_NAME . 'nav') . " WHERE enabled = 1 and uniacid = '{$_W['uniacid']}' and aid = {$_W['aid']} ORDER BY displayorder DESC");
        $banner = pdo_fetchall("SELECT * FROM " . tablename(PDO_NAME . 'banner') . " WHERE enabled = 1 and uniacid = '{$_W['uniacid']}' and aid = {$_W['aid']} ORDER BY displayorder DESC");
        $notice = pdo_fetchall("SELECT * FROM " . tablename(PDO_NAME . 'notice') . " WHERE enabled = 1 and uniacid = '{$_W['uniacid']}' and aid = {$_W['aid']} ORDER BY id DESC");
        $cubes = self :: readSetting('cube');
        foreach($cubes as $k => $v){
            if(empty($v['thumb']) || $v['on'] == 0){
                unset($cubes[$k]);
            }
        }
        return array('page' => $page, 'adv' => $advs, 'nav' => $nav, 'banner' => $banner, 'notice' => $notice, 'cubes' => $cubes);
    }
}
