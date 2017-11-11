<?php
defined('IN_IA')or exit('Access Denied');
class active{
    function activelist(){
        global $_W, $_GPC;
        $pindex = max(1, intval($_GPC['page']));
        $psize = 10;
        $data = array();
        if(!empty($_GPC['status']))$data['status'] = intval($_GPC['status']);
        $data['aid'] = $_W['aid'];
        $activity = Rush :: getNumActive('*', $data, 'ID DESC', $pindex, $psize, 1);
        $pager = $activity[1];
        $activity = $activity[0];
        foreach ($activity as $key => & $value){
            $value['storename'] = pdo_getcolumn(PDO_NAME . 'merchantdata', array('id' => $value['sid']), 'storename');
            Rush :: changeActivestatus($value);
        }
        $status0 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename(PDO_NAME . 'rush_activity') . " WHERE uniacid={$_W['uniacid']} and status in (1,2,3) and aid={$_W['aid']}");
        $status1 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename(PDO_NAME . 'rush_activity') . " WHERE uniacid={$_W['uniacid']} and status=1 and aid={$_W['aid']}");
        $status2 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename(PDO_NAME . 'rush_activity') . " WHERE uniacid={$_W['uniacid']} and status=2 and aid={$_W['aid']}");
        $status3 = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename(PDO_NAME . 'rush_activity') . " WHERE uniacid={$_W['uniacid']} and status=3 and aid={$_W['aid']}");
        include wl_template('active/active_list');
    }
    function createactive(){
        global $_W, $_GPC;
        $id = intval($_GPC['id']);
        $gid = intval($_GPC['gid']);
        if(empty($_GPC['add'])){
            if(empty($id) && empty($gid)){
                include wl_template('active/selectActive');
                exit;
            }elseif(empty($id)){
                $goods = Rush :: getSingleGoods($gid, '*');
            }else{
                $goods = Rush :: getSingleActive($id, '*');
            }
            $merchant = Rush :: getSingleMerchant($goods['sid'], 'id,storename,logo');
            $goods['thumbs'] = unserialize($goods['thumbs']);
            $goods['tag'] = unserialize($goods['tag']);
            $sale = $goods['num'] - $goods['levelnum'];
        }
        if (empty($goods['starttime']) || empty($goods['endtime'])){
            $goods['starttime'] = time();
            $goods['endtime'] = strtotime('+1 month');
            $goods['cutofftime'] = strtotime('+1 month');
        }
        if (checksubmit('submit')){
            $img = $_GPC['data_img'];
            $tags = $_GPC['data_tag'];
            $len = count($img);
            $tag = array();
            for ($k = 0;$k < $len;$k++){
                $tag[$k]['data_img'] = $img[$k];
                $tag[$k]['data_tag'] = $tags[$k];
            }
            $goods = $_GPC['goods'];
            if(empty($goods['price']))wl_message('请填写抢购价格');
            if(empty($goods['name']))wl_message('请填写商品名称');
            if(empty($goods['num']))wl_message('请填写抢购数量');
            $goods['detail'] = htmlspecialchars_decode($goods['detail']);
            $goods['thumbs'] = serialize($goods['thumbs']);
            $goods['tag'] = serialize($tag);
            $time = $_GPC['time'];
            $goods['starttime'] = strtotime($time['start']);
            $goods['endtime'] = strtotime($time['end']);
            $goods['cutofftime'] = strtotime($_GPC['cutofftime']);
            $goods['aid'] = $_W['aid'];
            $goods['levelnum'] = $goods['num'] - $sale;
            if($goods['starttime'] > time()){
                $goods['status'] = 1;
            }elseif($goods['starttime'] < time() && time() < $goods['endtime']){
                $goods['status'] = 2;
            }elseif($goods['endtime'] < time()){
                $goods['status'] = 3;
            }
            if($id){
                $res = Rush :: updateActive($goods, array('id' => $id));
            }else{
                $res = Rush :: saveRushActive($goods);
            }
            message('保存成功！', web_url('rush/active/activelist'), 'success');
        }
        include wl_template('active/createactive');
    }
    function selectGoods(){
        global $_W, $_GPC;
        $where = array('aid' => $_W['aid'], 'uniacid' => $_W['uniacid']);
        if($_GPC['keyword'])$where['@name@'] = $_GPC['keyword'];
        $goodsData = Rush :: getNumGoods("id,name,thumb", $where, 'id desc', 0, 0, 0);
        $ds = $goodsData[0];
        include wl_template('active/selectGoods');
    }
    function ajax(){
        global $_W, $_GPC;
        $id = $_GPC['id'];
        $da = Rush :: getSingleGoods($id, '*');
        die(json_encode($da));
    }
    function delete(){
        global $_W, $_GPC;
        $id = $_GPC['id'];
        if(is_array($id)){
            foreach ($id as $key => $value){
                $res = Rush :: updateActive(array('status' => 4), array('id' => $value));
            }
        }else{
            $res = Rush :: updateActive(array('status' => 4), array('id' => $id));
        }
        if($res){
            die(json_encode(array('errno' => 0)));
        }else{
            die(json_encode(array('errno' => 1)));
        }
    }
}
