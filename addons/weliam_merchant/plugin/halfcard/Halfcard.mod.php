<?php
defined('IN_IA')or exit('Access Denied');
class Halfcard{
    static function saveHalfcard($halfcard, $param = array()){
        global $_W;
        if(!is_array($halfcard))return FALSE;
        $halfcard['uniacid'] = $_W['uniacid'];
        $halfcard['aid'] = $_W['aid'];
        if(empty($param)){
            pdo_insert(PDO_NAME . 'halfcardlist', $halfcard);
            return pdo_insertid();
        }
        return FALSE;
    }
    static function deleteHalfcard($where){
        $res = pdo_delete(PDO_NAME . 'halfcardlist', $where);
        if($res){
            return 1;
        }else{
            return 0;
        }
    }
    static function deleteHalfcardRecord($where){
        $res = pdo_delete(PDO_NAME . 'halfcardrecord', $where);
        if($res){
            return 1;
        }else{
            return 0;
        }
    }
    static function getSingleHalfcard($id, $select, $where = array()){
        $where['id'] = $id;
        return Util :: getSingelData($select, PDO_NAME . 'halfcardlist', $where);
    }
    static function getSingleMember($id, $select, $where = array()){
        $where['mid'] = $id;
        return Util :: getSingelData($select, PDO_NAME . 'halfcardmember', $where);
    }
    static function updateHalfcard($params, $where){
        $res = pdo_update(PDO_NAME . 'halfcardlist', $params, $where);
        if($res){
            return 1;
        }else{
            return 0;
        }
    }
    static function getNumRecord($select, $where, $order, $pindex, $psize, $ifpage){
        $goodsInfo = Util :: getNumData($select, PDO_NAME . 'halfcardrecord', $where, $order, $pindex, $psize, $ifpage);
        $newGoodInfo = $newGoodInfo?$newGoodInfo:array();
        return array($newGoodInfo, $goodsInfo[1], $goodsInfo[2])?array($newGoodInfo, $goodsInfo[1], $goodsInfo[2]):array();
    }
    static function getNumstore($select, $where, $order, $pindex, $psize, $ifpage){
        $goodsInfo = Util :: getNumData($select, PDO_NAME . 'merchantdata', $where, $order, $pindex, $psize, $ifpage);
        return $goodsInfo;
    }
    static function getstores($locations, $lng, $lat){
        global $_W;
        if (empty($lat) || empty($lng))return false;
        foreach ($locations as $key => $val){
            $loca = unserialize($val['location']);
            $locations[$key]['distance'] = Store :: getdistance($loca['lng'], $loca['lat'], $lng, $lat);
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
    static function createHalfOrder($dayNum, $price){
        global $_W;
        $mdata = array('uniacid' => $_W['uniacid'], 'mid' => $_W['mid']);
        if($_W['wlsetting']['halfcard']['halfcardtype'] != 1){
            $mdata['aid'] = $_W['aid'];
        }
        $vipInfo = Util :: getSingelData('*', PDO_NAME . "halfcardmember", $mdata);
        $lastviptime = $vipInfo['expiretime'];
        if($lastviptime && $lastviptime > time()){
            $limittime = $lastviptime + $dayNum * 24 * 60 * 60;
        }else{
            $limittime = time() + $dayNum * 24 * 60 * 60;
        }
        $aid = Util :: idSwitch('areaid', 'aid', $_W['areaid']);
        $data = array('aid' => $_W['aid'], 'uniacid' => $_W['uniacid'], 'mid' => $_W['mid'], 'orderno' => 'HalfCard_' . createUniontid(), 'status' => 0, 'createtime' => TIMESTAMP, 'price' => $price, 'limittime' => $limittime, 'howlong' => $dayNum);
        pdo_insert(PDO_NAME . 'halfcard_record', $data);
        return pdo_insertid();
    }
    static function payHalfcardNotify($params){
        global $_W;
        Util :: wl_log('vip_notify', PATH_DATA . 'merchant/data/', $params);
        $data = self :: getVipPayData($params);
        pdo_update(PDO_NAME . 'halfcard_record', $data, array('orderno' => $params['tid']));
        $order_out = pdo_get(PDO_NAME . 'halfcard_record', array('orderno' => $params['tid']));
        $memberData = array('halfcardstatus' => 1, 'lasthalfcardtime' => $order_out['limittime'], 'areaid' => $order_out['areaid'], 'aid' => $order_out['aid']);
        pdo_update(PDO_NAME . 'member', $memberData, array('id' => $order_out['mid']));
    }
    static function payHalfcardReturn($params){
        global $_W;
        Util :: wl_log('Vip_return', PATH_DATA . 'merchant/data/', $params);
        $order_out = pdo_get(PDO_NAME . 'halfcard_record', array('orderno' => $params['tid']), array('id'));
        header('location:' . app_url('halfcard/halfcardopen/openSuccess', array('orderid' => $order_out['id'])));
    }
    static function getNumActive($select, $where, $order, $pindex, $psize, $ifpage){
        $activeInfo = Util :: getNumData($select, PDO_NAME . 'halfcardlist', $where, $order, $pindex, $psize, $ifpage);
        return $activeInfo;
    }
    static function getNumActive1($select, $where, $order, $pindex, $psize, $ifpage){
        $activeInfo = Util :: getNumData($select, PDO_NAME . 'halfcardrecord', $where, $order, $pindex, $psize, $ifpage);
        return $activeInfo;
    }
    static function getNumhalfcardmember($select, $where, $order, $pindex, $psize, $ifpage){
        $activeInfo = Util :: getNumData($select, PDO_NAME . 'halfcardmember', $where, $order, $pindex, $psize, $ifpage);
        return $activeInfo;
    }
    static function getNumhalfcardpay($select, $where, $order, $pindex, $psize, $ifpage){
        $activeInfo = Util :: getNumData($select, PDO_NAME . 'halfcard_record', $where, $order, $pindex, $psize, $ifpage);
        return $activeInfo;
    }
}
?>