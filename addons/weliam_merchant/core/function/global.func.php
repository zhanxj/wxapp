<?php
defined('IN_IA')or exit('Access Denied');
function getAllPluginsName(){
    return array('Rush', 'Merchant', 'wlCoupon', 'halfcard');
}
function createUniontid(){
    global $_W;
    $moduleid = pdo_getcolumn("modules" , array('name' => 'weliam_merchant'), 'mid');
    $moduleid = empty($moduleid)? '000000' : sprintf("%06d", $moduleid);
    $uniontid = date('YmdHis') . $moduleid . random(8, 1);
    return $uniontid;
}
function m($filename = ''){
    static $_modules = array();
    if(strpos($filename, '/') > -1){
        list($file, $name) = explode('/', $filename);
    }else{
        die('文件结构不正确，正确结构（文件夹名/文件名）');
    }
    if (isset($_modules[$file][$name]))return $_modules[$file][$name];
    $model = PATH_CORE . "library/" . $file . "/" . $name . '.lib.php';
    if (!is_file($model)){
        die('Library Class ' . $filename . ' Not Found!');
    }
    require $model;
    $class_name = ucfirst($name);
    $_modules[$file][$name] = new $class_name();
    return $_modules[$file][$name];
}
function checkLimit($roleid, $arr = array()){
    $allPerms = Perms :: allParms();
    if(empty($allPerms[$arr['p']][$arr['ac']][$arr['do']]))return true;
    $limits = Perms :: getRolePerms($roleid);
    if(empty($limits) || empty($arr))return false;
    if(empty($limits[$arr['p']][$arr['ac']][$arr['do']]))return false;
    return true;
}
function web_url($segment, $params = array()){
    global $_W;
    list($p, $ac, $do) = explode('/', $segment);
    if (defined('IN_WEB')){
        $url = $_W['siteroot'] . 'web/agent.php?';
    }else{
        $url = $_W['siteroot'] . 'web/index.php?c=site&a=entry&m=' . MODULE_NAME . '&';
    }
    if (!empty($p)){
        $url .= "p={$p}&";
    }
    if (!empty($ac)){
        $url .= "ac={$ac}&";
    }
    $do = !empty($do)? $do : 'index';
    if (!empty($do)){
        $url .= "do={$do}&";
    }
    if (!empty($params)){
        $queryString = http_build_query($params, '', '&');
        $url .= $queryString;
    }
    return $url;
}
function app_url($segment, $params = array()){
    global $_W;
    list($p, $ac, $do) = explode('/', $segment);
    $_W['siteroot'] = str_replace(array('/addons/' . MODULE_NAME, '/core/common'), '', $_W['siteroot']);
    $url = $_W['siteroot'] . 'app/index.php?i=' . $_W['uniacid'] . '&c=entry&m=' . MODULE_NAME . '&';
    if (!empty($p)){
        $url .= "p={$p}&";
    }
    if (!empty($ac)){
        $url .= "ac={$ac}&";
    }
    $do = !empty($do)? $do : 'index';
    if (!empty($do)){
        $url .= "do={$do}&";
    }
    if (!empty($params)){
        $queryString = http_build_query($params, '', '&');
        $url .= $queryString;
    }
    return $url;
}
function wl_template($filename, $flag = ''){
    global $_W;
    $name = MODULE_NAME;
    if (defined('IN_SYS')){
        $source = IA_ROOT . "/addons/{$name}/sys/view/default/{$filename}.html";
        $compile = IA_ROOT . "/data/tpl/sys/{$name}/sys/view/default/{$filename}.tpl.php";
        if (!is_file($source)){
            $source = IA_ROOT . "/addons/{$name}/plugin/{$_W['plugin']}/sys/view/default/{$filename}.html";
        }
    }
    if (defined('IN_WEB')){
        $source = IA_ROOT . "/addons/{$name}/web/view/default/{$filename}.html";
        $compile = IA_ROOT . "/data/tpl/web/{$name}/web/view/default/{$filename}.tpl.php";
        if (!is_file($source)){
            $source = IA_ROOT . "/addons/{$name}/plugin/{$_W['plugin']}/web/view/default/{$filename}.html";
        }
    }
    if (defined('IN_APP')){
        $template = $_W['wlsetting']['templat']['appview'];
        if (empty($template)){
            $template = "default";
        }
        $source = IA_ROOT . "/addons/{$name}/app/view/{$template}/{$filename}.html";
        $compile = IA_ROOT . "/data/tpl/app/{$name}/app/view/{$template}/{$filename}.tpl.php";
        if (!is_file($source)){
            $source = IA_ROOT . "/addons/{$name}/app/view/default/{$filename}.html";
        }
        if(!is_file($source)){
            $source = IA_ROOT . "/addons/{$name}/plugin/{$_W['plugin']}/app/view/default/{$filename}.html";
        }
        if(!empty($_W['agentset']['halfcard']['halfcardtext']) || !empty($_W['agentset']['halfcard']['halftext'])){
            $compile = IA_ROOT . "/data/tpl/app/{$name}/{$_W['uniacid']}/{$_W['aid']}/app/view/{$template}/{$filename}.tpl.php";
        }
    }
    if (!is_file($source)){
        exit("Error: template source '{$filename}' is not exist!!!");
    }
    if (!is_file($compile) || filemtime($source) > filemtime($compile)){
        Template :: wl_template_compile($source, $compile, true);
    }
    if ($flag == TEMPLATE_FETCH){
        extract($GLOBALS, EXTR_SKIP);
        ob_end_flush();
        ob_clean();
        ob_start();
        include $compile;
        $contents = ob_get_contents();
        ob_clean();
        return $contents;
    }else if($flag == 'template'){
        extract($GLOBALS, EXTR_SKIP);
        return $compile;
    }else{
        return $compile;
    }
}
function wl_message($msg, $redirect = '', $type = ''){
    global $_W, $_GPC;
    if($redirect == 'refresh'){
        $redirect = $_W['script_name'] . '?' . $_SERVER['QUERY_STRING'];
    }
    if($redirect == 'referer'){
        $redirect = referer();
    }
    if($redirect == 'close'){
        $redirect = 'wx.closeWindow()';
        $close = 1;
    }
    if($redirect == ''){
        $type = in_array($type, array('success', 'error', 'info', 'warning', 'ajax', 'sql'))? $type : 'info';
    }else{
        $type = in_array($type, array('success', 'error', 'info', 'warning', 'ajax', 'sql'))? $type : 'success';
    }
    if ($_W['isajax'] || !empty($_GET['isajax']) || $type == 'ajax'){
        if($type != 'ajax' && !empty($_GPC['target'])){
            exit("
<script type=\"text/javascript\">
parent.require(['jquery', 'util'], function($, util){
	var url = " . (!empty($redirect)? 'parent.location.href' : "''") . ";
	var modalobj = util.message('" . $msg . "', '', '" . $type . "');
	if (url) {
		modalobj.on('hide.bs.modal', function(){\$('.modal').each(function(){if(\$(this).attr('id') != 'modal-message') {\$(this).modal('hide');}});top.location.reload()});
	}
});
</script>");
        }else{
            $vars = array();
            if(is_array($msg)){
                $vars['errno'] = $msg['errno'];
                $vars['message'] = $msg['message'];
                die(json_encode($vars));
            }else{
                $vars['message'] = $msg;
            }
            $vars['redirect'] = $redirect;
            $vars['type'] = $type;
            die(json_encode($vars));
        }
    }elseif(is_array($msg)){
        $msg = $msg['message'];
    }
    if (empty($msg) && !empty($redirect)){
        header('location: ' . $redirect);
    }
    $label = $type;
    if($type == 'error'){
        $label = 'danger';
    }
    if($type == 'ajax' || $type == 'sql'){
        $label = 'warning';
    }
    include wl_template('common/message', TEMPLATE_INCLUDEPATH);
    exit();
}
function wl_debug($value){
    echo "<br><pre>";
    print_r($value);
    echo '</pre>';
    exit ;
}
function wl_log($filename, $title, $data){
    global $_W;
    if($uniacid != ''){
        $_W['uniacid'] = $uniacid;
    }
    $url_log = PATH_DATA . "log/" . date('Y-m-d', time()) . "/" . $filename . ".log";
    $url_dir = PATH_DATA . "log/" . date('Y-m-d', time());
    Util :: mkDirs($url_dir);
    file_put_contents($url_log, var_export('/=======' . date('Y-m-d H:i:s', time()) . '【' . $title . '】=======/', true) . PHP_EOL, FILE_APPEND);
    file_put_contents($url_log, var_export($data, true) . PHP_EOL, FILE_APPEND);
}
function qr($url){
    global $_W;
    if(empty($url))return false;
    m('qrcode/QRcode') -> png($url, false, QR_ECLEVEL_H, 4);
}
function puv(){
    global $_W;
    if($_W['uniacid'] <= 0 || empty($_W['areaid'])){
        return;
    }
    $puv = pdo_getcolumn(PDO_NAME . 'puv', array('uniacid' => $_W['uniacid'], 'date' => date('Ymd'), 'areaid' => $_W['areaid']), 'id');
    if (empty($puv)){
        pdo_insert(PDO_NAME . 'puv', array('areaid' => $_W['areaid'], 'uniacid' => $_W['uniacid'], 'pv' => 0, 'uv' => 0, 'date' => date('Ymd')));
        $puv = pdo_insertid();
    }
    pdo_query('UPDATE ' . tablename(PDO_NAME . 'puv') . " SET `pv` = `pv` + 1 WHERE id = {$puv}");
    if($_W['mid']){
        $myp = pdo_getcolumn(PDO_NAME . 'puvrecord', array('uniacid' => $_W['uniacid'], 'date' => date('Ymd'), 'mid' => $_W['mid'], 'areaid' => $_W['areaid']), 'id');
        if(empty($myp)){
            pdo_query('UPDATE ' . tablename(PDO_NAME . 'puv') . " SET `uv` = `uv` + 1 WHERE id = {$puv}");
            pdo_insert(PDO_NAME . 'puvrecord', array('areaid' => $_W['areaid'], 'uniacid' => $_W['uniacid'], 'pv' => 0, 'mid' => $_W['mid'], 'date' => date('Ymd')));
            $myp = pdo_insertid();
        }
        pdo_query('UPDATE ' . tablename(PDO_NAME . 'puvrecord') . " SET `pv` = `pv` + 1 WHERE id = {$myp}");
    }
}
function sendCustomNotice($openid, $msg, $url = '', $account = null){
    global $_W;
    if (!$account){
        load() -> model('account');
        $acid = pdo_fetchcolumn("SELECT acid FROM " . tablename('account_wechats') . " WHERE `uniacid`=:uniacid LIMIT 1", array(':uniacid' => $_W['uniacid']));
        $account = WeAccount :: create($acid);
    }
    if (!$account){
        return;
    }
    $content = "";
    if (is_array($msg)){
        foreach ($msg as $key => $value){
            if (!empty($value['title'])){
                $content .= $value['title'] . ":" . $value['value'] . "\n";
            }else{
                $content .= $value['value'] . "\n";
                if ($key == 0){
                    $content .= "\n";
                }
            }
        }
    }else{
        $content = $msg;
    }
    if (!empty($url)){
        $content .= "<a href='{$url}'>点击查看详情</a>";
    }
    return $account -> sendCustomNotice(array("touser" => $openid, "msgtype" => "text", "text" => array('content' => urlencode($content))));
}
function sendtplnotice($touser, $template_id, $postdata, $url = '', $account = null){
    global $_W;
    load() -> model('account');
    if (!$account){
        if (!empty($_W['acid'])){
            $account = WeAccount :: create($_W['acid']);
        }else{
            $acid = pdo_fetchcolumn("SELECT acid FROM " . tablename('account_wechats') . " WHERE `uniacid`=:uniacid LIMIT 1", array(':uniacid' => $_W['uniacid']));
            $account = WeAccount :: create($acid);
        }
    }
    if (!$account){
        return;
    }
    return $account -> sendTplNotice($touser, $template_id, $postdata, $url);
}
function wl_tpl_form_field_member($value = array()){
    $s = '';
    $s = '
		<script type="text/javascript">
			function search_members() {
	       	if( $.trim($("#search-kwd").val())==""){
	            Tip.focus("#search-kwd","请输入关键词");
	            return;
	        }
	
			$("#module-menus").html("正在搜索....");
			$.get("' . web_url('member/wlMember/selectMember') . '", {
				keyword: $.trim($("#search-kwd").val())
			}, function(dat){
				$("#module-menus").html(dat);
			});
		}
	    function select_member(o) {
			$("#openid").val(o.openid);
			$("#saler").val(o.nickname);
			$("#search-kwd").val(o.nickname);
			$("#module-menus").html("");
		}
		</script>';
    $s .= '
			<div class="layui-form-item">
                    <label class="col-xs-12 col-sm-3 col-md-2 layui-form-label">选择微信账号</label>
                    <div class="col-xs-12 col-sm-9 col-md-8 col-lg-7 layui-input-block">
                        <input type="hidden" id="openid" name="openid" value="' . $value['openid'] . '" />
                        <div class="input-group">
                            <input type="text" name="nickname" maxlength="30" value="' . $value['nickname'] . '" id="saler" class="form-control" readonly />
                            <div class="input-group-btn">
                                <button class="btn btn-default" type="button" data-toggle="modal" data-target="#myModal">选择微信账号</button>
                            </div>
                        </div>
	          			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	                        <div class="modal-dialog" style="width: 660px;">
	                            <div class="modal-content">
	                                <div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h3>选择微信账号</h3></div>
	                                <div class="modal-body" >
	                                    <div class="row">
	                                        <div class="input-group">
	                                            <input type="text" class="form-control" name="keyword" value="" id="search-kwd" placeholder="请输入微信昵称" />
	                                            <span class="input-group-btn"><button type="button" class="btn btn-default" onclick="search_members();">搜索</button></span>
	                                        </div>
	                                    </div>
	                                    <div id="module-menus" style="padding-top:5px;">
	                                    </div>
	                                </div>
	                                	<div class="modal-footer"><a href="#" class="btn btn-default" data-dismiss="modal" aria-hidden="true">关闭</a>
	                                	</div>
	                            </div>
	                        </div>
	                    </div>
                	</div>
   				</div>
		';
    return $s;
}
