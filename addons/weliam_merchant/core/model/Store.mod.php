<?php
defined('IN_IA')or exit('Access Denied');
class Store{
    static function getAllRegister($page = 0, $pagenum = 10, $status = 1){
        global $_W;
        $re['data'] = pdo_fetchall("select * from" . tablename(PDO_NAME . 'merchantuser') . "where uniacid=:uniacid and aid=:aid and status=:status order by createtime desc limit " . $page * $pagenum . "," . $pagenum, array(':uniacid' => $_W['uniacid'], ':aid' => $_W['aid'], ':status' => $status));
        $re['count'] = pdo_fetchcolumn("select count(*) from" . tablename(PDO_NAME . 'merchantuser') . "where uniacid=:uniacid and aid=:aid and status=:status order by createtime desc limit " . $page * $pagenum . "," . $pagenum, array(':uniacid' => $_W['uniacid'], ':aid' => $_W['aid'], ':status' => $status));
        return $re;
    }
    static function getSingleRegister($mid){
        global $_W;
        if (empty($mid))return '';
        if(is_array($mid)){
            return pdo_get(PDO_NAME . 'merchantuser', $mid);
        }
        return pdo_get(PDO_NAME . 'merchantuser', array('mid' => $mid, 'aid' => $_W['aid'], 'uniacid' => $_W['uniacid']));
    }
    static function saveSingleRegister($arr, $mid = ''){
        global $_W;
        if (!empty($mid))return pdo_update(PDO_NAME . 'merchantuser', $arr, array('uniacid' => $_W['uniacid'], 'aid' => $_W['aid'], 'mid' => $mid));
        $arr['mid'] = $_W['mid'];
        $user = self :: getSingleRegister($arr['mid']);
        if (!empty($user))return false;
        return pdo_insert(PDO_NAME . 'merchantuser', $arr);
    }
    static function editSingleRegister($id, $arr){
        global $_W;
        if (empty($id))return false;
        return pdo_update(PDO_NAME . 'merchantuser', $arr, array('id' => $id, 'uniacid' => $_W['uniacid']));
    }
    static function getAllGroup($page = 0, $pagenum = 10, $enabled = '', $aid = ''){
        global $_W;
        $condition = '';
        if (!empty($aid))$condition .= " and aid=" . $aid;
        if (!empty($enabled) && $enabled != '')$condition .= " and enabled=" . $enabled;
        $re['data'] = pdo_fetchall("select * from" . tablename(PDO_NAME . 'storeusers_group') . "where uniacid=:uniacid and aid=:aid  " . $condition . " order by enabled desc, createtime desc limit " . $page * $pagenum . "," . $pagenum, array(':uniacid' => $_W['uniacid'], ':aid' => $_W['aid']));
        $re['count'] = pdo_fetchcolumn("select count(*) from" . tablename(PDO_NAME . 'storeusers_group') . "where uniacid=:uniacid and aid=:aid  " . $condition, array(':uniacid' => $_W['uniacid'], ':aid' => $_W['aid']));
        return $re;
    }
    static function getSingleGroup($id){
        global $_W;
        if (empty($id))return false;
        return pdo_get(PDO_NAME . 'storeusers_group', array('id' => $id, 'uniacid' => $_W['uniacid']));
    }
    static function editGroup($arr, $id = ""){
        global $_W;
        if (empty($arr))return false;
        if ($arr['isdefault'] == 1)pdo_update(PDO_NAME . 'storeusers_group', array('isdefault' => 0), array('uniacid' => $_W['uniacid'], 'isdefault' => 1));
        if (!empty($id) && $id != '')return pdo_update(PDO_NAME . 'storeusers_group', $arr, array('id' => $id, 'uniacid' => $_W['uniacid']));
        $arr['uniacid'] = $_W['uniacid'];
        $arr['aid'] = $_W['aid'];
        return pdo_insert(PDO_NAME . 'storeusers_group', $arr);
    }
    static function deleteGroup($id){
        global $_W;
        if (empty($id))return false;
        return pdo_delete(PDO_NAME . 'storeusers_group', array('id' => $id, 'uniacid' => $_W['uniacid']));
    }
    static function getSingleCategory($id){
        global $_W;
        if (empty($id))return false;
        return pdo_get(PDO_NAME . 'category_store', array('id' => $id, 'uniacid' => $_W['uniacid']));
    }
    static function getAllCategory($page = 0, $pagenum = 10, $parentid = 0){
        global $_W;
        $re['data'] = pdo_fetchall("select * from" . tablename(PDO_NAME . 'category_store') . "where uniacid=:uniacid and aid=:aid and parentid=:parentid order by displayorder desc limit " . $page * $pagenum . "," . $pagenum, array(':uniacid' => $_W['uniacid'], ':aid' => $_W['aid'], ':parentid' => $parentid));
        $re['count'] = pdo_fetchcolumn("select count(*) from" . tablename(PDO_NAME . 'category_store') . "where uniacid=:uniacid and aid=:aid and parentid=:parentid", array(':uniacid' => $_W['uniacid'], ':aid' => $_W['aid'], ':parentid' => $parentid));
        return $re;
    }
    static function categoryEdit($arr, $id = ''){
        global $_W;
        if (empty($arr))return false;
        if (!empty($id) && $id != '')return pdo_update(PDO_NAME . 'category_store', $arr, array('id' => $id, 'uniacid' => $_W['uniacid'], 'aid' => $_W['aid']));
        $arr['aid'] = $_W['aid'];
        $arr['uniacid'] = $_W['uniacid'];
        return pdo_insert(PDO_NAME . 'category_store', $arr);
    }
    static function categoryDelete($id){
        global $_W;
        if (empty($id))return false;
        $arr = pdo_getall(PDO_NAME . 'category_store', array('uniacid' => $_W['uniacid'], 'parentid' => $id));
        if (empty($arr))return pdo_delete(PDO_NAME . 'category_store', array('uniacid' => $_W['uniacid'], 'id' => $id));
        foreach ($arr as $key => $value){
            if (!self :: categoryDelete($value['id']))return false;
        }
        return pdo_delete(PDO_NAME . 'category_store', array('uniacid' => $_W['uniacid'], 'id' => $id));
    }
    static function registerEdit($arr){
        global $_W;
        if (empty($arr))return false;
        $arr['uniacid'] = $_W['uniacid'];
        return pdo_insert(PDO_NAME . 'merchantuser', $arr);
    }
    static function registerCheck(){
        global $_W;
        return pdo_fetchall('select * from' . tablename(PDO_NAME . 'storeusers_group'));
    }
    static function registerNickname($arr){
        global $_W;
        $con = $arr;
        return pdo_fetchall('select * from' . tablename(PDO_NAME . 'member') . "where $con");
    }
    static function getAllUser($page = 0, $pagenum = 10, $enabled = 0){
        global $_W;
        $re['data'] = pdo_fetchall("select * from" . tablename(PDO_NAME . 'merchantuser') . "where uniacid=:uniacid and status=:status and enabled=:enabled order by createtime desc limit " . $page * $pagenum . "," . $pagenum, array(':uniacid' => $_W['uniacid'], ':status' => 2, ':enabled' => $enabled));
        foreach ($re['data'] as $key => $value){
            if (strtotime($re['data'][$key]['endtime']) < time()){
                $re['data'][$key]['enabled'] = 3;
                pdo_update(PDO_NAME . 'merchantuser', $re['data'][$key], array('id' => $re['data'][$key]['id'], 'uniacid' => $_W['uniacid']));
            }
        }
        $re['count'] = pdo_fetchcolumn("select count(*) from" . tablename(PDO_NAME . 'merchantuser') . "where uniacid=:uniacid and status=:status and enabled=:enabled order by createtime desc limit " . $page * $pagenum . "," . $pagenum, array(':uniacid' => $_W['uniacid'], ':status' => 2, ':enabled' => $enabled));
        return $re;
    }
    static function registerEditUser($arr, $id = ''){
        global $_W;
        if (empty($arr))return false;
        if (!empty($id) && $id != ''){
            pdo_update(PDO_NAME . 'merchantuser', $arr, array('id' => $id, 'uniacid' => $_W['uniacid']));
            return $id;
        }else{
            $arr['uniacid'] = $_W['uniacid'];
            $arr['aid'] = $_W['aid'];
            pdo_insert(PDO_NAME . 'merchantuser', $arr);
            $uid = pdo_insertid();
            return $uid;
        }
    }
    static function registerEditData($arr, $id = ''){
        global $_W;
        if (empty($arr))return false;
        if (!empty($id) && $id != ''){
            pdo_update(PDO_NAME . 'merchantdata', $arr, array('id' => $id, 'uniacid' => $_W['uniacid']));
            return $id;
        }else{
            $arr['uniacid'] = $_W['uniacid'];
            $arr['aid'] = $_W['aid'];
            pdo_insert(PDO_NAME . 'merchantdata', $arr);
            $uid = pdo_insertid();
            return $uid;
        }
    }
    static function deleteUser($id){
        global $_W;
        if (empty($id))return false;
        $arr = pdo_get(PDO_NAME . 'merchantuser', array('uniacid' => $_W['uniacid'], 'id' => $id));
        if ($arr['storeid'] != 0){
            pdo_delete(PDO_NAME . 'merchantdata', array('id' => $arr['storeid'], 'uniacid' => $_W['uniacid']));
        }
        return pdo_delete(PDO_NAME . 'merchantuser', array('id' => $id, 'uniacid' => $_W['uniacid']));
    }
    static function getSingleStore($id){
        global $_W;
        if (empty($id))return '';
        return pdo_get(PDO_NAME . 'merchantdata', array('id' => $id, 'uniacid' => $_W['uniacid']));
    }
    static function deleteStoreByMid($mid){
        global $_W;
        if (empty($mid))return false;
        $arr = pdo_get(PDO_NAME . 'merchantuser', array('uniacid' => $_W['uniacid'], 'mid' => $mid));
        if (!empty($arr['storeid'])){
            pdo_delete(PDO_NAME . 'merchantdata', array('id' => $arr['storeid'], 'uniacid' => $_W['uniacid']));
        }
        return pdo_delete(PDO_NAME . 'merchantuser', array('mid' => $mid, 'uniacid' => $_W['uniacid']));
    }
    static function getstores($locations, $lng, $lat){
        global $_W;
        if (empty($lat) || empty($lng))return false;
        foreach ($locations as $key => $val){
            $loca = unserialize($val['location']);
            $storehours = unserialize($val['storehours']);
            $locations[$key]['distance'] = self :: getdistance($loca['lng'], $loca['lat'], $lng, $lat);
            $locations[$key]['logo'] = tomedia($val['logo']);
            $locations[$key]['url'] = app_url('store/merchant/detail', array('id' => $val['id']));
            $locations[$key]['storehours'] = $storehours['startTime'] . "—" . $storehours['endTime'] . "&nbsp;营业";
            $cate = '';
            if($val['onelevel']){
                $cate .= pdo_getcolumn(PDO_NAME . 'category_store', array('id' => $val['onelevel']), 'name');
            }
            if($val['twolevel']){
                $cate .= ' | ';
                $cate .= pdo_getcolumn(PDO_NAME . 'category_store', array('id' => $val['twolevel']), 'name');
            }
            $locations[$key]['cate'] = $cate;
        }
        for($i = 0;$i < count($locations)-1;$i++){
            for($j = 0;$j < count($locations)-1 - $i;$j++){
                if($locations[$j]['distance'] > $locations[$j + 1]['distance']){
                    $temp = $locations[$j + 1];
                    $locations[$j + 1] = $locations[$j];
                    $locations[$j] = $temp;
                }
            }
        }
        foreach ($locations as $key => $value){
            if($value['distance'] > 1000){
                $locations[$key]['distance'] = (floor(($value['distance'] / 1000) * 10) / 10) . "km";
            }else{
                $locations[$key]['distance'] = round($value['distance']) . "m";
            }
        }
        return $locations;
    }
    static function getdistance($lng1, $lat1, $lng2, $lat2){
        $radLat1 = @deg2rad($lat1);
        $radLat2 = @deg2rad($lat2);
        $radLng1 = @deg2rad($lng1);
        $radLng2 = @deg2rad($lng2);
        $a = $radLat1 - $radLat2;
        $b = $radLng1 - $radLng2;
        $s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2))) * 6378.137 * 1000;
        return $s;
    }
}
