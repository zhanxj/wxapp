<?php
defined('IN_IA')or exit('Access Denied');
class Area{
    static function getAllAgent($page = 0, $pagenum = 10, $con = ''){
        global $_W;
        $condition = '';
        if(!empty($con) && is_array($con)){
            foreach($con as $key => $val){
                if($key == 'username')$condition .= " and " . $key . " like '%" . $val . "%'";
                if($key == 'groupid')$condition .= " and " . $key . "=" . $val;
                if($key == 'status')$condition .= " and " . $key . "=" . $val;
            }
        }
        $re['data'] = pdo_fetchall("select * from" . tablename(PDO_NAME . 'agentusers') . "where uniacid=:uniacid  " . $condition . " order by groupid desc, starttime desc limit " . $page * $pagenum . "," . $pagenum, array(':uniacid' => $_W['uniacid']));
        $re['count'] = pdo_fetchcolumn("select count(*) from" . tablename(PDO_NAME . 'agentusers') . "where uniacid=:uniacid  " . $condition, array(':uniacid' => $_W['uniacid']));
        return $re;
    }
    static function getSingleAgent($id){
        global $_W;
        if(empty($id))return false;
        $re = pdo_get(PDO_NAME . 'agentusers', array('id' => $id, 'uniacid' => $_W['uniacid']));
        $re['percent'] = unserialize($re['percent']);
        return $re;
    }
    static function editAgent($arr, $id = ''){
        global $_W;
        if(empty($arr))return false;
        if(empty($id)){
            $arr['uniacid'] = $_W['uniacid'];
            pdo_insert(PDO_NAME . 'agentusers', $arr);
            $id = pdo_insertid();
        }else{
            pdo_update(PDO_NAME . 'agentusers', $arr, array('id' => $id, 'uniacid' => $_W['uniacid']));
        }
        return $id;
    }
    static function deleteAgent($aid){
        global $_W;
        if(empty($aid))return false;
        $areaids = pdo_getall(PDO_NAME . 'oparea', array('aid' => $aid), 'id');
        if(pdo_delete(PDO_NAME . 'oparea', array('uniacid' => $_W['uniacid'], 'aid' => $aid))){
            return pdo_delete(PDO_NAME . 'agentusers', array('uniacid' => $_W['uniacid'], 'id' => $aid));
        }
        return false;
    }
    static function getAllGroup($page = 0, $pagenum = 10, $enabled = ''){
        global $_W;
        $condition = '';
        if(!empty($enabled) && $enabled != '')$condition = " and enabled=" . $enabled;
        $re['data'] = pdo_fetchall("select * from" . tablename(PDO_NAME . 'agentusers_group') . "where uniacid=:uniacid  " . $condition . " order by enabled desc, createtime desc limit " . $page * $pagenum . "," . $pagenum, array(':uniacid' => $_W['uniacid']));
        $re['count'] = pdo_fetchcolumn("select count(*) from" . tablename(PDO_NAME . 'agentusers_group') . "where uniacid=:uniacid  " . $condition, array(':uniacid' => $_W['uniacid']));
        return $re;
    }
    static function getSingleGroup($id){
        global $_W;
        if(empty($id))return false;
        return pdo_get(PDO_NAME . 'agentusers_group', array('id' => $id, 'uniacid' => $_W['uniacid']));
    }
    static function editGroup($arr, $id = ''){
        global $_W;
        if(empty($arr))return false;
        if($arr['isdefault'] == 1)pdo_update(PDO_NAME . 'agentusers_group', array('isdefault' => 0), array('uniacid' => $_W['uniacid'], 'isdefault' => 1));
        if(!empty($id) && $id != '')return pdo_update(PDO_NAME . 'agentusers_group', $arr, array('id' => $id, 'uniacid' => $_W['uniacid']));
        $arr['uniacid'] = $_W['uniacid'];
        return pdo_insert(PDO_NAME . 'agentusers_group', $arr);
    }
    static function deleteGroup($id){
        global $_W;
        if(empty($id))return false;
        $isuse = pdo_getcolumn(PDO_NAME . 'agentusers', array('groupid' => $id, 'uniacid' => $_W['uniacid']), 'id');
        if(!empty($isuse))return false;
        return pdo_delete(PDO_NAME . 'agentusers_group', array('id' => $id, 'uniacid' => $_W['uniacid']));
    }
    static function address_tree_in_use($aid = ''){
        global $_W;
        $provinces = pdo_getall(PDO_NAME . 'area', array('visible' => 2, 'level' => 1, 'displayorder' => array('0', $_W['uniacid'])), array('id', 'name'));
        $cities = pdo_getall(PDO_NAME . 'area', array('visible' => 2, 'level' => 2, 'displayorder' => array('0', $_W['uniacid'])), array('id', 'pid', 'name'));
        if(!empty($aid)){
            $terarea = pdo_getall(PDO_NAME . 'oparea', array('uniacid' => $_W['uniacid'], 'aid !=' => $aid), 'areaid');
        }else{
            $terarea = pdo_getall(PDO_NAME . 'oparea', array('uniacid' => $_W['uniacid']), 'areaid');
        }
        $terarea = Util :: i_array_column($terarea, 'areaid');
        $address_tree = array();
        foreach ($provinces as $province_id => $province){
            $address_tree[$province_id] = array('id' => $province['id'], 'name' => $province['name'], 'children' => array());
            foreach ($cities as $city_id => $city){
                if(in_array($city['id'], $terarea)){
                    unset($cities[$city_id]);
                }else{
                    if ($city['pid'] == $province['id']){
                        $address_tree[$province_id]['children'][$city_id] = array('id' => $city['id'], 'name' => $city['name']);
                    }
                }
            }
        }
        return $address_tree;
    }
    static function get_all_in_use(){
        global $_W;
        if($_W['aid'] != -1){
            $terarea = pdo_getall(PDO_NAME . 'oparea', array('uniacid' => $_W['uniacid'], 'aid' => $_W['aid']), 'areaid');
        }else{
            $terarea = pdo_getall(PDO_NAME . 'oparea', array('uniacid' => $_W['uniacid']), 'areaid');
        }
        $terarea = Util :: i_array_column($terarea, 'areaid');
        $districts = pdo_getall(PDO_NAME . 'area', array('visible' => 2, 'level' => 3));
        $address_tree = array();
        foreach ($terarea as $province_id => $province){
            $cities = pdo_get(PDO_NAME . 'area', array('id' => $province), array('id', 'pid', 'name'));
            $provinces = pdo_get(PDO_NAME . 'area', array('id' => $cities['pid']), array('id', 'name'));
            if(empty($address_tree[$cities['pid']])){
                $address_tree[$cities['pid']] = array('title' => $provinces['name'], 'cities' => array());
            }
            $address_tree[$cities['pid']]['cities'][$province] = array('title' => $cities['name'], 'districts' => array(),);
            foreach ($districts as $district_id => $district){
                if ($district['pid'] == $province){
                    $address_tree[$cities['pid']]['cities'][$province]['districts'][$district['id']] = $district['name'];
                }
            }
        }
        return $address_tree;
    }
    static function get_agent_area($aid = ''){
        global $_W;
        $data = array('uniacid' => $_W['uniacid']);
        if(!empty($aid))$data['aid'] = $aid;
        $terarea = pdo_getall(PDO_NAME . 'oparea', $data, 'areaid');
        $terarea = Util :: i_array_column($terarea, 'areaid');
        return $terarea;
    }
    static function save_agent_area($node_ids, $aid){
        global $_W;
        if(empty($node_ids) || empty($aid))return false;
        pdo_delete(PDO_NAME . 'oparea', array('uniacid' => $_W['uniacid'], 'aid' => $aid));
        foreach($node_ids as $val){
            $name = pdo_getcolumn(PDO_NAME . 'area', array('id' => $val), 'name');
            pdo_insert(PDO_NAME . 'oparea', array('uniacid' => $_W['uniacid'], 'areaid' => $val, 'aid' => $aid));
        }
        return TRUE;
    }
    static function get_all_area($type = ''){
        global $_W;
        $address_tree = array();
        $terarea = pdo_getall(PDO_NAME . 'oparea', array('uniacid' => $_W['uniacid'], 'status' => 1), 'areaid');
        $terarea = Util :: i_array_column($terarea, 'areaid');
        if($type == 1){
            foreach($terarea as $key => $val){
                $name = pdo_getcolumn(PDO_NAME . 'area', array('id' => $val), 'name');
                $address_tree[$key] = array('id' => $val, 'name' => $name);
            }
            return $address_tree;
        }
        $provinces = pdo_getall(PDO_NAME . 'area', array('visible' => 2, 'level' => 1, 'displayorder' => array('0', $_W['uniacid'])), array('id', 'name'));
        $cities = pdo_getall(PDO_NAME . 'area', array('visible' => 2, 'level' => 2, 'displayorder' => array('0', $_W['uniacid'])), array('id', 'pid', 'name'));
        foreach ($provinces as $province_id => $province){
            $address_tree[$province_id] = array('id' => $province['id'], 'name' => $province['name'], 'children' => array());
            foreach ($cities as $city_id => $city){
                if(@in_array($city['id'], $terarea)){
                    if ($city['pid'] == $province['id']){
                        $address_tree[$province_id]['children'][$city_id] = array('id' => $city['id'], 'name' => $city['name']);
                    }
                }
            }
            if(empty($address_tree[$province_id]['children'])){
                unset($address_tree[$province_id]);
            }
        }
        return $address_tree;
    }
    static function get_area(){
        global $_W;
        $maera = Util :: httpPost("http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip=" . $_W['clientip']);
        $maera = Util :: object_array(json_decode($maera));
        $allarea = self :: get_all_area(1);
        if(count($allarea) == 1){
            $areaid = $allarea[0]['id'];
            $name = $allarea[0]['name'];
        }else{
            foreach($allarea as $key => $val){
                if(mb_substr($maera['city'], 0, 2, 'utf-8') == mb_substr($val['name'], 0, 2, 'utf-8')){
                    $areaid = $val['id'];
                    $name = $val['name'];
                    break;
                }
            }
        }
        return array('id' => $areaid, 'name' => $name, 'lc' => $maera['province'] . $maera['city']);
    }
    static function set_area_cookie($areaid){
        global $_W;
        if(empty($areaid))return false;
        $aid = pdo_getcolumn(PDO_NAME . 'oparea', array('uniacid' => $_W['uniacid'], 'areaid' => $areaid), 'aid');
        if(empty($aid))return false;
        $name = pdo_getcolumn(PDO_NAME . 'area', array('id' => $areaid), 'name');
        $_W['areaid'] = $areaid;
        $_W['areaname'] = $name;
        $_W['aid'] = $aid;
        Util :: setCookie('__areaid', array('areaid' => $areaid, 'name' => $name, 'aid' => $aid), 7 * 86400);
    }
    static function getIdByName($name){
        global $_W;
        if(empty($name))return false;
        $re = pdo_get(PDO_NAME . 'area', array('name' => $name), 'id');
        return $re['id'];
    }
    static function getAreaNameById($id, $type = 0){
        global $_W;
        if(empty($id))return false;
        if($type == 0){
            $city = pdo_getcolumn(PDO_NAME . 'area', array('id' => $id), 'name');
            $proId = intval($id / 10000) * 10000;
            $pro = pdo_getcolumn(PDO_NAME . 'area', array('id' => $proId), 'name');
            return $pro . '-' . $city;
        }
    }
}
