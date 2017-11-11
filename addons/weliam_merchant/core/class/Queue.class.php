<?php defined('IN_IA')or exit('Access Denied');
class Queue{
    private $islock = array('value' => 0, 'expire' => 0);
    private $expiretime = 900;
    public function __construct(){
        $lock = Cache :: getCache('queuelock', 'first');
        if(!empty($lock))$this -> islock = $lock;
    }
    private function setLock(){
        $array = array('value' => 1, 'expire' => time());
        Cache :: setCache('queuelock', 'first', $array);
        cache_write(MODULE_NAME . ':task:status', $array);
        $this -> islock = $array;
    }
    private function deleteLock(){
        Cache :: deleteCache('queuelock', 'first');
        $this -> islock = array('value' => 0, 'expire' => time());
        return true;
    }
    public function checkLock(){
        $lock = $this -> islock;
        if($lock['value'] == 1 && $lock['expire'] < (time() - $this -> expiretime)){
            $this -> deleteLock();
            return false;
        }
        if(empty($lock['value'])){
            return false;
        }else{
            return true;
        }
    }
    public function queueMain(){
        global $_W;
        set_time_limit(0);
        if($this -> checkLock()){
            die('LOCK');
        }else{
            $this -> setLock();
        }
        $sets = pdo_fetchall('select distinct uniacid from ' . tablename(PDO_NAME . 'setting'));
        foreach ($sets as $set){
            $_W['uniacid'] = $set['uniacid'];
            if (empty($_W['uniacid']) || $_W['uniacid'] == -1){
                continue;
            }
            $this -> doTask();
            $this -> autoDealRushOrder();
        }
        unset($_W['uniacid']);
        $this -> deleteLock();
        die('TRUE');
    }
    public function autoDealRushOrder(){
        global $_W;
        $sets = pdo_fetchall('select distinct aid from ' . tablename(PDO_NAME . 'oparea') . "where uniacid = {$_W['uniacid']}");
        foreach ($sets as $set){
            $_W['aid'] = $set['aid'];
            if (empty($_W['aid']) || $_W['aid'] == -1){
                continue;
            }
            $config = Setting :: agentsetting_read('rush');
            if(empty($config['cancle_time'])){
                $config['cancle_time'] = 3;
            }
            $canceltime = time() - $config['cancle_time'] * 60;
            $orderdata = pdo_fetchall("select id from" . tablename(PDO_NAME . "rush_order") . "where uniacid = {$_W['uniacid']} and aid = {$_W['aid']} and status=0 and createtime < '{$canceltime}'");
            if(!empty($orderdata)){
                foreach($orderdata as $k => $v){
                    pdo_update(PDO_NAME . "rush_order", array('status' => 5), array('id' => $v['id']));
                }
            }
            $refundOrders = pdo_fetchall("select id,price from" . tablename(PDO_NAME . "rush_order") . "where uniacid = {$_W['uniacid']} and status = 6 limit 0,10");
            if(!empty($refundOrders)){
                foreach($refundOrders as $k => $v){
                    wlPay :: refundMoney($v['id'], $v['price'], '抢购失败', 'rush');
                }
            }
            $activitys1 = pdo_getall(PDO_NAME . "rush_activity", array('uniacid' => $_W['uniacid'], 'aid' => $_W['aid'], 'starttime <' => time(), 'status' => 1), array('id'));
            if(!empty($activitys1)){
                foreach($activitys1 as $k => $v){
                    pdo_update(PDO_NAME . "rush_activity", array('status' => 2), array('id' => $v['id']));
                }
            }
            $activitys2 = pdo_getall(PDO_NAME . "rush_activity", array('uniacid' => $_W['uniacid'], 'aid' => $_W['aid'], 'endtime <' => time(), 'status' => 2), array('id'));
            if(!empty($activitys2)){
                foreach($activitys2 as $k => $v){
                    pdo_update(PDO_NAME . "rush_activity", array('status' => 3), array('id' => $v['id']));
                }
            }
            $follows = pdo_getall(PDO_NAME . 'rush_follows', array('sendtime <=' => time()), array('actid', 'mid', 'id'), '', 'id', array(1, 50));
            if(!empty($follows)){
                foreach($follows as $k => $v){
                    Message :: rushFollow($v['mid'], $v['actid']);
                    pdo_delete(PDO_NAME . 'rush_follows', array('id' => $v['id']));
                }
            }
        }
    }
    public function addTask($key, $value){
        global $_W;
        $data = array('uniacid' => $_W['uniacid'], 'key' => $key, 'value' => $value);
        $res = pdo_insert('wlmerchant_waittask', $data);
        return $res;
    }
    public function deleteTask($id){
        global $_W;
        pdo_delete('wlmerchant_waittask', array('uniacid' => $_W['uniacid'], 'id' => $id));
    }
    public function getNeedTaskItem(){
        global $_W;
        $array = array(':uniacid' => $_W['uniacid']);
        return pdo_fetchall('SELECT * FROM ' . tablename('wlmerchant_waittask') . ' WHERE `uniacid` = :uniacid ORDER BY `id` ASC ', $array);
    }
    public function doTask(){
        global $_W;
        set_time_limit(0);
        $message = self :: getNeedTaskItem();
        foreach($message as $k => $v){
            if($v['key'] == 1){
            }
            if($v['key'] == 2){
            }
            if($v['key'] == 3){
            }
            self :: deleteTask($v['id']);
        }
    }
}
