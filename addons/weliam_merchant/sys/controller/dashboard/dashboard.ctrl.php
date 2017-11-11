<?php
defined('IN_IA')or exit('Access Denied');
class dashboard{
    public function index(){
        global $_W, $_GPC;
        $refresh = $_GPC['refresh']?1:0;
        $data = Merchant :: sysSurvey($refresh);
        if($data){
            $agentUsers = $data[0];
            $membersNum = $data[1];
            $address_arr = $data[2];
            $time = $data[3];
            $todaypuv = $data[5];
            $numPv = $data[6];
            $numUv = $data[7];
            $newfans = $data[8];
            $totalInMoney = $data[9];
            $totalOutMoney = $data[10];
            $spercentMoney = $data[11];
            $halfPercentMoney = $data[12];
            $vipPercentMoney = $data[13];
            $settlementMoney = $data[14];
            $waitSettlementMoney = $data[15];
        }
        include wl_template('dashboard/index');
    }
}
