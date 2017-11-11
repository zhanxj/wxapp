<?php
defined('IN_IA')or exit('Access Denied');
class goodshouse{
    function goodsList(){
        global $_W, $_GPC;
        $pindex = max(1, intval($_GPC['page']));
        $psize = 10;
        $where = array();
        if (!empty($_GPC['keyword'])){
            if(!empty($_GPC['keywordtype'])){
                switch($_GPC['keywordtype']){
                case 1: $where['@name@'] = $_GPC['keyword'];
                    break;
                case 2: $where['@id@'] = $_GPC['keyword'];
                    break;
                case 3: $where['@id@'] = $_GPC['keyword'];
                    break;
                case 4: $where['@code@'] = $_GPC['keyword'];
                    break;
                default:break;
                }
            }
        }
        $goodsData = Rush :: getNumGoods('*', $where, 'displayorder DESC', $pindex, $psize, 1);
        $goodses = $goodsData[0];
        $pager = $goodsData[1];
        if(checksubmit()){
            $display = $_GPC['display'];
            $ids = $_GPC['ids'];
            for($i = 0;$i < count($ids);$i++){
                Rush :: updateGoods(array('displayorder' => $display[$i]), array('id' => $ids[$i]));
                Cache :: deleteCache('goods', $ids[$i]);
            }
            wl_message('商品排序保存成功', web_url('rush/goodshouse/goodslist'), 'success');
        }
        include wl_template('goodshouse/goods_list');
    }
    function createGoods(){
        global $_W, $_GPC;
        if($_W['isajax']){
            $img = $_GPC['data_img'];
            $tags = $_GPC['data_tag'];
            $len = count($img);
            $tag = array();
            for ($k = 0;$k < $len;$k++){
                $tag[$k]['data_img'] = $img[$k];
                $tag[$k]['data_tag'] = $tags[$k];
            }
            $goods = $_GPC['goods'];
            $goods['detail'] = htmlspecialchars_decode($goods['detail']);
            $goods['thumbs'] = serialize($goods['thumbs']);
            $goods['tag'] = serialize($tag);
            $res = Rush :: saveGoodsHouse($goods);
            wl_message(array('errno' => 1, 'message' => '添加成功'));
        }
        include wl_template('goodshouse/creategoods');
    }
    function editGoods(){
        global $_W, $_GPC;
        $goods = Rush :: getSingleGoods($_GPC['id'], '*');
        $merchant = Rush :: getSingleMerchant($goods['sid'], 'id,storename,logo');
        $goods['thumbs'] = unserialize($goods['thumbs']);
        $goods['tag'] = unserialize($goods['tag']);
        if($_W['isajax']){
            $img = $_GPC['data_img'];
            $tags = $_GPC['data_tag'];
            $len = count($img);
            $tag = array();
            for ($k = 0;$k < $len;$k++){
                $tag[$k]['data_img'] = $img[$k];
                $tag[$k]['data_tag'] = $tags[$k];
            }
            $goods = $_GPC['goods'];
            $goods['detail'] = htmlspecialchars_decode($goods['detail']);
            $goods['thumbs'] = serialize($goods['thumbs']);
            $goods['tag'] = serialize($tag);
            $res = Rush :: updateGoods($goods, array('id' => $_GPC['id']));
            wl_message(array('errno' => 1, 'message' => '更新成功'));
        }
        include wl_template('goodshouse/creategoods');
    }
    function delete(){
        global $_W, $_GPC;
        $id = $_GPC['id'];
        $res = Rush :: deleteGoods(array('id' => $id));
        if($res){
            die(json_encode(array('errno' => 0, 'message' => $res, 'id' => $id)));
        }else{
            die(json_encode(array('errno' => 2, 'message' => $res, 'id' => $id)));
        }
    }
    function tag(){
        include wl_template('goodshouse/imgandtag');
    }
    function selectMerchant(){
        global $_W, $_GPC;
        $where = array();
        $where['uniacid'] = $_W['uniacid'];
        if($_GPC['keyword'])$where['@storename@'] = $_GPC['keyword'];
        $merchants = Rush :: getNumMerchant('id,storename,logo', $where, 'ID DESC', 0, 0, 0);
        $merchants = $merchants[0];
        foreach ($merchants as $key => & $va){
            $va['logo'] = tomedia($va['logo']);
        }
        include wl_template('goodshouse/selectMerchant');
    }
}
