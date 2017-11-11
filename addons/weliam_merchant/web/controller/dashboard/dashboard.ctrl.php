<?php
defined('IN_IA')or exit('Access Denied');
class dashboard{
    public function index(){
        global $_W, $_GPC;
        $agentUsers[0][0] = $_W['agent'];
        $refresh = $_GPC['refresh']?1:0;
        $data = Merchant :: agentSurvey($refresh);
        $pluginsset = App :: getPlugins();
        if($data){
            $allMerchant = $data[0];
            $allMembers = $data[1];
            $address_arr = $data[2];
            $time = $data[3];
            $todaypuv = $data[4];
            $numPv = $data[5];
            $numUv = $data[6];
            $newfans = $data[7];
            $totalInMoney = $data[8];
            $totalOutMoney = $data[9];
            $spercentMoney = $data[10];
            $halfPercentMoney = $data[11];
            $vipPercentMoney = $data[12];
            $settlementMoney = $data[13];
            $waitSettlementMoney = $data[14];
        }
        include wl_template('dashboard/index');
    }
}
