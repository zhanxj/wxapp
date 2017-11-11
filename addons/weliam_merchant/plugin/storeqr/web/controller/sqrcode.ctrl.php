<?php
defined('IN_IA')or exit('Access Denied');
class sqrcode{
    public function qrlist(){
        global $_W, $_GPC;
        $wheresql = " WHERE uniacid = :uniacid AND aid = :aid";
        $param = array(':uniacid' => $_W['uniacid'], ':aid' => $_W['aid']);
        $keyword = trim($_GPC['keyword']);
        if(!empty($keyword)){
            $wheresql .= " AND (cardsn LIKE '%{$keyword}%' or remark LIKE '%{$keyword}%') ";
        }
        $starttime = empty($_GPC['time']['start'])? TIMESTAMP - 86399 * 30 : strtotime($_GPC['time']['start']);
        $endtime = empty($_GPC['time']['end'])? TIMESTAMP: strtotime($_GPC['time']['end']);
        if(!empty($_GPC['time']['start'])){
            $wheresql .= " AND createtime >= '{$starttime}' AND createtime <= '{$endtime}'";
        }
        if (!empty($_GPC['status'])){
            $wheresql .= " AND status = {$_GPC['status']}";
        }
        if (!empty($_GPC['model']) && $_GPC['model'] != -1){
            $wheresql .= " AND model = {$_GPC['model']}";
        }
        $pindex = max(1, intval($_GPC['page']));
        $psize = 20;
        $list = pdo_fetchall("SELECT * FROM " . tablename(PDO_NAME . 'qrcode') . $wheresql . ' ORDER BY `id` DESC LIMIT ' . ($pindex - 1) * $psize . ',' . $psize, $param);
        if (!empty($list)){
            foreach ($list as $index => & $qrcode){
                $wq_qr = pdo_get('qrcode', array('id' => $qrcode['qrid']), array('ticket', 'scene_str', 'qrcid', 'id', 'createtime'));
                $qrcode['scene_str'] = $wq_qr['scene_str'];
                $qrcode['qrcid'] = $wq_qr['qrcid'];
                $qrcode['id'] = $wq_qr['id'];
                $qrcode['endtime'] = $wq_qr['createtime'] + 2592000;
                if ($qrcode['model'] == 2){
                    $qrcode['showurl'] = 'https:mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . urlencode($wq_qr['ticket']);
                    $qrcode['modellabel'] = "含参";
                    $qrcode['endtime'] = '<font color="green">永不</font>';
                }elseif($qrcode['model'] == 3){
                    $qrcode['showurl'] = app_url('qr/qrcode/show', array('ncnumber' => $qrcode['cardsn'], 'salt' => $qrcode['salt']));
                    $qrcode['modellabel'] = "智能";
                    $qrcode['endtime'] = '<font color="green">永不</font>';
                }else{
                    $qrcode['modellabel'] = "临时";
                    $qrcode['showurl'] = 'https:mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . urlencode($wq_qr['ticket']);
                    if (TIMESTAMP > $qrcode['endtime']){
                        $qrcode['endtime'] = '<font color="red">已过期</font>';
                    }else{
                        $qrcode['endtime'] = date('Y-m-d H:i:s', $qrcode['endtime']);
                    }
                }
            }
        }
        $total = pdo_fetchcolumn('SELECT COUNT(id) FROM ' . tablename(PDO_NAME . 'qrcode') . $wheresql, $param);
        $pager = pagination($total, $pindex, $psize);
        if($_GPC['export'] != ''){
            $this -> export($wheresql, $param);
        }
        include wl_template('sqrcode/qr-list');
    }
    public function post(){
        global $_W, $_GPC;
        if(checksubmit('submit')){
            Storeqr :: qr_createkeywords();
            $qrctype = intval($_GPC['qrc-model']);
            $allnum = intval($_GPC['qr_num']);
            include wl_template('sqrcode/qr-process');
            exit;
        }
        include wl_template('sqrcode/qr-post');
    }
    public function get(){
        global $_W, $_GPC;
        $qrctype = intval($_GPC['qrc-model']);
        $return = Storeqr :: creatstoreqr($qrctype, $_GPC['remark']);
        die(json_encode($return));
    }
    public function export($wheresql, $param){
        if(empty($wheresql) || empty($param))return FALSE;
        set_time_limit(0);
        $list = pdo_fetchall("SELECT * FROM " . tablename(PDO_NAME . 'qrcode') . $wheresql . ' ORDER BY `id` DESC', $param);
        $html = "\xEF\xBB\xBF";
        $filter = array('showurl' => '二维码', 'cardsn' => '编号', 'status' => '使用状态', 'model' => '二维码类型', 'qrcid' => '场景ID', 'createtime' => '生成时间');
        foreach ($filter as $key => $title){
            $html .= $title . "\t,";
        }
        $html .= "\n";
        foreach ($list as $k => $v){
            $wq_qr = pdo_get('qrcode', array('id' => $v['qrid']), array('ticket', 'scene_str', 'model', 'id', 'url'));
            $v['scene_str'] = $wq_qr['scene_str'];
            if($wq_qr['model'] == 3){
                $str1 = substr($wq_qr['url'], 0, 15);
                if($str1 == 'http://w.url.cn'){
                    $v['showurl'] = $wq_qr['url'];
                }else{
                    $v['showurl'] = app_url('qr/qrcode', array('ncnumber' => $v['cardsn'], 'salt' => $v['salt']));
                }
            }else{
                $v['showurl'] = $wq_qr['url'];
            }
            foreach ($filter as $key => $title){
                if ($key == 'createtime'){
                    $html .= date('Y-m-d H:i:s', $v[$key]) . "\t, ";
                }elseif($key == 'status'){
                    switch ($v[$key]){
                    case '1': $html .= '未绑定' . "\t, ";
                        break;
                    case '2': $html .= '已绑定' . "\t, ";
                        break;
                    default: $html .= '已失效' . "\t, ";
                        break;
                    }
                }elseif($key == 'model'){
                    switch ($v[$key]){
                    case '1': $html .= '临时' . "\t, ";
                        break;
                    case '2': $html .= '含参' . "\t, ";
                        break;
                    default: $html .= '智能' . "\t, ";
                        break;
                    }
                }elseif($key == 'qrcid'){
                    if(!empty($v['qrcid'])){
                        $html .= $v['qrcid'] . "\t, ";
                    }else{
                        $html .= $v['scene_str'] . "\t, ";
                    }
                }else{
                    $html .= $v[$key] . "\t, ";
                }
            }
            $html .= "\n";
        }
        header('Content-type:text/csv');
        header('Content-Disposition:attachment; filename=全部数据.csv');
        echo $html;
        exit();
    }
    public function setting(){
        global $_W, $_GPC;
        $settings = Setting :: agentsetting_read('storeqr');
        if (checksubmit('submit')){
            $base = array('enterfast' => $_GPC['enterfast'], 'binding' => $_GPC['binding'], 'status' => intval($_GPC['status']));
            Setting :: agentsetting_save($base, 'storeqr');
            wl_message('保存设置成功！', referer(), 'success');
        }
        include wl_template('sqrcode/qr-setting');
    }
    public function summary(){
        global $_W, $_GPC;
        $usednum = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename(PDO_NAME . 'qrcode') . " WHERE uniacid = '{$_W['uniacid']}' and aid = '{$_W['aid']}' and status = 2");
        $invalidnum = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename(PDO_NAME . 'qrcode') . " WHERE uniacid = '{$_W['uniacid']}' and aid = '{$_W['aid']}' and status = 3");
        $notusenum = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename(PDO_NAME . 'qrcode') . " WHERE uniacid = '{$_W['uniacid']}' and aid = '{$_W['aid']}' and status = 1");
        $remark_arr = pdo_fetchall('SELECT distinct remark FROM ' . tablename(PDO_NAME . 'qrcode') . "WHERE uniacid = {$_W['uniacid']} and aid = '{$_W['aid']}'");
        $remark_arr = Util :: i_array_column($remark_arr, 'remark');
        foreach ($remark_arr as $key => $item){
            $arr2[] = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename(PDO_NAME . 'qrcode') . " WHERE uniacid = '{$_W['uniacid']}' and aid = '{$_W['aid']}' and remark = '{$item}' ");
            $arr3[] = pdo_fetchcolumn("SELECT COUNT(id) FROM " . tablename(PDO_NAME . 'qrcode') . " WHERE uniacid = '{$_W['uniacid']}' and aid = '{$_W['aid']}' and remark = '{$item}' and status = 2 ");
        }
        $data = json_encode($remark_arr);
        for ($i = 0;$i < count($remark_arr);$i++){
            $data2[$i]['value'] = $arr2[$i];
            $data2[$i]['name'] = $remark_arr[$i];
        }
        $data2 = json_encode($data2);
        $arr2 = json_encode($arr2);
        $arr3 = json_encode($arr3);
        include wl_template('sqrcode/qr-summary');
    }
}
?>