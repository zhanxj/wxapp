<?php
defined('IN_IA')or exit('Access Denied');
set_time_limit(0);
load() -> func('file');
class auth{
    public function __construct(){
        global $_W;
        if (!$_W['isfounder']){
            message('无权访问!');
        }
    }
    public function index(){
        global $_W, $_GPC;
        $domain = $_W['siteroot'];
        $siteid = '1111';
        //$auth = Cloud :: wl_syssetting_read('auth');
		$auth['ip'] = $_W['clientip'];
		$auth['domain'] = $_W['siteroot'];
		$auth['siteid'] = $siteid;
		$auth['code'] = '1111111111111';
		$auth['family'] = 'base';
        //$resp = Cloud :: auth_user($siteid, $domain);
		$resp['updatetime'] = time();
		$resp['website'] = 1111;
		$resp['ip'] = $_W['clientip'];
		$resp['domain'] = $_W['siteroot'];
        $ip = $resp['ip'];
        //$result = Cloud :: auth_checkauth($auth);
		$result['status'] = 1;
		$result['family'] = 'base';
        if (checksubmit()){
            $data = array('ip' => $_GPC['ip'], 'domain' => $_GPC['domain'], 'siteid' => $_GPC['siteid'], 'code' => $_GPC['code']);
            $resp = Cloud :: auth_grant($data);
            if($resp['errno'] == 1){
                wl_message($resp['message']);
            }else{
                $data['family'] = $resp['family'];
                $tmpdir = IA_ROOT . '/addons/' . MODULE_NAME . '/core/common';
                if (!is_dir($tmpdir)){
                    mkdirs($tmpdir);
                }
                file_put_contents($tmpdir . '/common.log', json_encode($data));
                Cloud :: wl_syssetting_save($data, 'auth');
                wl_message($resp['message']);
            }
        }
        include wl_template('cloud/auth');
    }
    public function process(){
        global $_W, $_GPC;
        include wl_template('cloud/process');
    }
    public function upgrade(){
        global $_W, $_GPC;
        $auth = Cloud :: wl_syssetting_read('auth');
        $result = Cloud :: auth_checkauth($auth);
        if($result['status'] != 1){
            wl_message('您还未授权，请授权后再试！', web_url('cloud/auth/index'), 'warning');
        }
        $versionfile = PATH_CORE . 'common/version.php';
        require_once $versionfile;
        $version = WELIAM_VERSION;
        $release = date('YmdHis', filemtime($versionfile));
        $upgrade = Cloud :: auth_check($auth, $version);
        if (is_array($upgrade)){
            if ($upgrade['result'] == 1){
                $files = array();
                if (!empty($upgrade['files'])){
                    foreach ($upgrade['files'] as $file){
                        $entry = IA_ROOT . '/addons/' . MODULE_NAME . '/' . $file['path'];
                        if (!is_file($entry) || md5_file($entry) != $file['md5']){
                            $files[] = array('path' => $file['path'], 'download' => 0, 'entry' => $entry);
                        }
                    }
                }
                if(!empty($files)){
                    $upgrade['files'] = $files;
                    $tmpdir = IA_ROOT . '/addons/' . MODULE_NAME . '/temp';
                    if (!is_dir($tmpdir)){
                        mkdirs($tmpdir);
                    }
                    file_put_contents($tmpdir . '/file.txt', json_encode($upgrade));
                }else{
                    unset($upgrade);
                }
            }else{
                wl_message($upgrade['message']);
            }
        }else{
            wl_message('服务器错误:' . $resp['content'] . '. ');
        }
        include wl_template('cloud/upgrade');
    }
    public function download(){
        global $_W, $_GPC;
        $auth = Cloud :: wl_syssetting_read('auth');
        $tmpdir = IA_ROOT . '/addons/' . MODULE_NAME . '/temp';
        $f = file_get_contents($tmpdir . '/file.txt');
        $upgrade = json_decode($f, true);
        $files = $upgrade['files'];
        $path = "";
        foreach ($files as $f){
            if (empty($f['download'])){
                $path = $f['path'];
                break;
            }
        }
        if (!empty($path)){
            $ret = Cloud :: auth_download($auth, $path);
            if (is_array($ret)){
                $path = $ret['path'];
                $dirpath = dirname($path);
                if (!is_dir(IA_ROOT . '/addons/' . MODULE_NAME . '/' . $dirpath)){
                    mkdirs(IA_ROOT . '/addons/' . MODULE_NAME . '/' . $dirpath, '0777');
                }
                $content = base64_decode($ret['content']);
                if($path == 'web/agent.php'){
                    file_put_contents(IA_ROOT . '/' . $path, $content);
                }
                file_put_contents(IA_ROOT . '/addons/' . MODULE_NAME . '/' . $path, $content);
                $success = 1;
                foreach ($files as & $f){
                    if ($f['path'] == $path){
                        $f['download'] = 1;
                        break;
                    }
                    if ($f['download']){
                        $success++;
                    }
                }
                unset($f);
                $upgrade['files'] = $files;
                $tmpdir = IA_ROOT . '/addons/' . MODULE_NAME . '/temp';
                if (!is_dir($tmpdir)){
                    mkdirs($tmpdir);
                }
                file_put_contents($tmpdir . '/file.txt', json_encode($upgrade));
                die(json_encode(array('result' => 1, 'total' => count($files), 'success' => $success, 'path' => $path)));
            }
        }else{
            $updatefile = IA_ROOT . '/addons/' . MODULE_NAME . '/upgrade.php';
            require $updatefile;
            $tmpdir = IA_ROOT . '/addons/' . MODULE_NAME . '/temp';
            @rmdirs($tmpdir);
            wl_message('恭喜您，系统更新成功！', web_url('cloud/auth/upgrade'), 'success');
        }
    }
}
