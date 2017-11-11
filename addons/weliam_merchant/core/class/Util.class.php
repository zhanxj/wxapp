<?php
defined('IN_IA')or exit('Access Denied');
class Util{
    static function checkPort(){
        $port = '';
        if (!empty($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') === true || strpos($_SERVER['HTTP_USER_AGENT'], 'Windows Phone') === true))$port = 'weixin';
        return $port;
    }
    static function object_array($array){
        if(is_object($array))$array = (array)$array;
        if(is_array($array)){
            foreach($array as $key => $value)$array[$key] = self :: object_array($value);
        }
        return $array;
    }
    static function trimWithArray($array){
        if(!is_array($array))return trim($array);
        foreach($array as $key => $value)$res[$key] = self :: trimWithArray($value);
        return $res;
    }
    static function beforeTime($time){
        $difftime = time() - $time;
        if($difftime < 60)return $difftime . '秒前';
        if($difftime < 3600)return intval($difftime / 60) . '分钟前';
        if($difftime < 86400)return intval($difftime / 3600) . '小时前';
        return intval($difftime / 86400) . '天前';
    }
    static function leftTime($time, $showsecond = true){
        $difftime = $time - time();
        if($diff <= 0)return '0天0时0分';
        $day = intval($diff / 24 / 3600);
        $hour = intval(($diff % (24 * 3600)) / 3600);
        $minutes = intval(($diff % (24 * 3600)) % 3600 / 60);
        $second = $diff % 60;
        if($showsecond)return $day . '天' . $hour . '时' . $minutes . '分' . $second . '秒';
        return $day . '天' . $hour . '时' . $minutes . '分';
    }
    static function mobileMask($mobile){
        return substr($mobile, 0, 3) . '****' . substr($mobile, 7);
    }
    static function createSalt($num = 6){
        $salt = '';
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol)-1;
        for($i = 0;$i < $num;$i++){
            $salt .= $strPol[rand(0, $max)];
        }
        return $salt;
    }
    static function createConcode($type = 1, $length = 8){
        global $_W;
        $code = rand(pow(10, ($length-1)), pow(10, $length)-1);
        if($type == 1){
            $res = pdo_getcolumn(PDO_NAME . 'rush_order', array('uniacid' => $_W['uniacid'], 'checkcode' => $code), 'id');
        }
        if($type == 2){
            $res = pdo_getcolumn(PDO_NAME . 'halfcardrecord', array('uniacid' => $_W['uniacid'], 'qrcode' => $code), 'id');
        }
        if($type == 3){
            $res = pdo_getcolumn(PDO_NAME . 'token', array('uniacid' => $_W['uniacid'], 'number' => $code), 'id');
        }
        if($type == 4){
            $res = pdo_getcolumn(PDO_NAME . 'member_coupons', array('uniacid' => $_W['uniacid'], 'concode' => $code), 'id');
        }
        if($res){
            self :: createConcode($type, $length);
        }
        return $code;
    }
    static function currency_format($currency, $decimals = 2){
        $currency = floatval($currency);
        if (empty($currency)){
            return '0.00';
        }
        $currency = number_format($currency, $decimals);
        $currency = str_replace(',', '', $currency);
        return $currency;
    }
    static function encryptedPassword($password, $salt, $flag = ''){
        return md5($salt . $password . $flag);
    }
    static function getCookie($name){
        global $_GPC;
        return json_decode(base64_decode($_GPC[$name]), true);
    }
    static function setCookie($name, $array, $time = 1800){
        if(empty($array) || $array == '')return false;
        $res = self :: getCookie($name);
        if(!empty($res))setcookie($name);
        return isetcookie($name, base64_encode(json_encode($array)), $time, true);
    }
    static function mkDirs($path){
        if(!is_dir($path))mkdir($path, 0777, true);
        return is_dir($path);
    }
    static function encode($str){
        global $_W;
        return authcode($str, 'ENCODE', $_W['account']['key'], 600);
    }
    static function decode($str){
        global $_W;
        return authcode($str, 'DECODE', $_W['account']['key'], 600);
    }
    static function traversingFiles($dir){
        if(!file_exists($dir))return array();
        $styles = array();
        if ($handle = opendir($dir)){
            while (($file = readdir($handle)) !== false){
                if ($file != ".." && $file != "."){
                    if (is_dir($dir . "/" . $file)){
                        $styles[] = $file;
                    }
                }
            }
            closedir($handle);
        }
        return $styles;
    }
    static function httpRequest($url, $post = '', $headers = array(), $forceIp = '', $timeout = 60){
        load() -> func('communication');
        return ihttp_request($url, $post, $options, $timeout);
    }
    static function httpGet($url, $forceIp = '', $timeout = 60){
        $res = self :: httpRequest($url, '', array(), $forceIp, $timeout);
        if(!is_error($res))return $res['content'];
        return $res;
    }
    static function httpPost($url, $data, $forceIp = '', $timeout = 60){
        $headers = array('Content-Type' => 'application/x-www-form-urlencoded');
        $res = self :: httpRequest($url, $data, $headers, $forceIp, $timeout);
        if(!is_error($res))return $res['content'];
        return $res;
    }
    static function removeEmoji($text){
        $clean_text = "";
        $regexEmoticons = '/[\x{1F600}-\x{1F64F}]/u';
        $clean_text = preg_replace($regexEmoticons, '', $text);
        $regexSymbols = '/[\x{1F300}-\x{1F5FF}]/u';
        $clean_text = preg_replace($regexSymbols, '', $clean_text);
        $regexTransport = '/[\x{1F680}-\x{1F6FF}]/u';
        $clean_text = preg_replace($regexTransport, '', $clean_text);
        $regexMisc = '/[\x{2600}-\x{26FF}]/u';
        $clean_text = preg_replace($regexMisc, '', $clean_text);
        $regexDingbats = '/[\x{2700}-\x{27BF}]/u';
        $clean_text = preg_replace($regexDingbats, '', $clean_text);
        return $clean_text;
    }
    static function registerJssdk($debug = false){
        global $_W;
        if(define('HEADER')){
            echo '';
            return;
        }
        $sysinfo = array('uniacid' => $_W['uniacid'], 'acid' => $_W['acid'], 'siteroot' => $_W['siteroot'], 'siteurl' => $_W['siteurl'], 'attachurl' => $_W['attachurl'], 'cookie' => array('pre' => $_W['config']['cookie']['pre']));
        if(!empty($_W['acid']))$sysinfo['acid'] = $_W['acid'];
        if(!empty($_W['openid']))$sysinfo['openid'] = $_W['openid'];
        if(define('PATH_MODULE'))$sysinfo['MODULE_URL'] = PATH_MODULE;
        $sysinfo = json_encode($sysinfo);
        $jssdkconfig = json_encode($_W['account']['jssdkconfig']);
        $debug = $debug ? 'true' : 'false';
        $script = <<<EOF
	<script src="http://res.wx.qq.com/open/js/jweixin-1.1.0.js"></script>
	<script type="text/javascript">
		window.sysinfo = window.sysinfo || $sysinfo || {};
		
		// jssdk config 对象
		jssdkconfig = $jssdkconfig || {};
		
		// 是否启用调试
		jssdkconfig.debug = $debug;
		
		jssdkconfig.jsApiList = [
			'checkJsApi',
			'onMenuShareTimeline',
			'onMenuShareAppMessage',
			'onMenuShareQQ',
			'onMenuShareWeibo',
			'hideMenuItems',
			'showMenuItems',
			'hideAllNonBaseMenuItem',
			'showAllNonBaseMenuItem',
			'translateVoice',
			'startRecord',
			'stopRecord',
			'onRecordEnd',
			'playVoice',
			'pauseVoice',
			'stopVoice',
			'uploadVoice',
			'downloadVoice',
			'chooseImage',
			'previewImage',
			'uploadImage',
			'downloadImage',
			'getNetworkType',
			'openLocation',
			'getLocation',
			'hideOptionMenu',
			'showOptionMenu',
			'closeWindow',
			'scanQRCode',
			'chooseWXPay',
			'openProductSpecificView',
			'addCard',
			'chooseCard',
			'openCard',
			'openAddress'
		];
		
		wx.config(jssdkconfig);
		
	</script>
EOF;
        echo $script;
    }
    static function uploadImageInWeixin($media_id){
        global $_W;
        load() -> model('account');
        load() -> func('communication');
        $access_token = WeAccount :: token();
        $url = 'http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=' . $access_token . '&media_id=' . $media_id;
        $resp = ihttp_get($url);
        $setting = $_W['setting']['upload']['image'];
        $setting['folder'] = "images/" . MODULE_NAME . '/' . date('Y/m/d', time());
        load() -> func('file');
        if(is_error($resp)){
            $result['message'] = '提取文件失败, 错误信息: ' . $resp['message'];
            return json_encode($result);
        }
        if(intval($resp['code']) != 200){
            $result['message'] = '提取文件失败: 未找到该资源文件.';
            return json_encode($result);
        }
        if(!self :: mkDirs(PATH_ATTACHMENT . $setting['folder'])){
            $result['message'] = '提取文件失败: 未找到服务器存放文件夹.';
            return json_encode($result);
        }
        $ext = '';
        switch ($resp['headers']['Content-Type']){
        case 'application/x-jpg': case 'image/jpeg':$ext = 'jpg';
            break;
        case 'image/png':$ext = 'png';
            break;
        case 'image/gif':$ext = 'gif';
            break;
        default: $result['message'] = '提取资源失败, 资源文件类型错误.';
            return json_encode($result);
            break;
        }
        if(intval($resp['headers']['Content-Length']) > $setting['limit'] * 1024){
        $result['message'] = '上传的媒体文件过大(' . sizecount($size) . ' > ' . sizecount($setting['limit'] * 1024);
        return json_encode($result);
    }
    $originname = pathinfo($url, PATHINFO_BASENAME);
    $filename = file_random_name(PATH_ATTACHMENT . $setting['folder'], $ext);
    $pathname = $setting['folder'] . "/" . $filename;
    $fullname = PATH_ATTACHMENT . $pathname;
    if (file_put_contents($fullname, $resp['content']) == false){
        $result['message'] = '提取失败.';
        return json_encode($result);
    }
    $info = array('name' => $originname, 'ext' => $ext, 'filename' => $pathname, 'attachment' => $pathname, 'url' => tomedia($pathname), 'is_image' => $type == 'image' ? 1 : 0, 'filesize' => filesize($fullname),);
    return json_encode($info);
}
static function i_array_column($input, $columnKey, $indexKey = null){
    if(!function_exists('array_column')){
        $columnKeyIsNumber = (is_numeric($columnKey))?true:false;
        $indexKeyIsNull = (is_null($indexKey))?true :false;
        $indexKeyIsNumber = (is_numeric($indexKey))?true:false;
        $result = array();
        foreach((array)$input as $key => $row){
            if($columnKeyIsNumber){
                $tmp = array_slice($row, $columnKey, 1);
                $tmp = (is_array($tmp) && !empty($tmp))?current($tmp):null;
            }else{
                $tmp = isset($row[$columnKey])?$row[$columnKey]:null;
            }
            if(!$indexKeyIsNull){
                if($indexKeyIsNumber){
                    $key = array_slice($row, $indexKey, 1);
                    $key = (is_array($key) && !empty($key))?current($key):null;
                    $key = is_null($key)?0:$key;
                }else{
                    $key = isset($row[$indexKey])?$row[$indexKey]:0;
                }
            }
            $result[$key] = $tmp;
        }
        return $result;
    }else{
        return array_column($input, $columnKey, $indexKey);
    }
}
static function idSwitch($beforeType, $afterType, $id){
    global $_W;
    $returnid = 0;
    $types = array('sid', 'sName', 'areaid', 'areaName', 'aid', 'aName', 'cateParentId', 'cateParentName', 'cateChildId', 'cateChildName');
    if(!in_array($beforeType, $types) || !in_array($afterType, $types))return FALSE;
    switch($beforeType){
    case 'sid': switch($afterType){
        case 'areaid': $data = pdo_get(PDO_NAME . 'merchantuser', array('id' => $id), array('areaid'));
            if($data['areaid'])$returnid = $data['areaid'];
            break;
        case 'aid': $data = pdo_get(PDO_NAME . 'merchantuser', array('id' => $id), array('areaid'));
            if($data['areaid'])$data2 = pdo_get(PDO_NAME . 'oparea', array('areaid' => $data['areaid']), array('aid'));
            if($data2['aid'])$returnid = $data2['aid'];
            break;
        case 'sName': $data = pdo_get(PDO_NAME . 'merchantdata', array('id' => $id), array('storename'));
            $returnid = $data['storename'];
            break;
        };
        break;
        case 'areaid': switch($afterType){
            case 'sid': $data = pdo_getall(PDO_NAME . 'merchantuser', array('areaid' => $id), array('id'));
                if($data)$returnid = $data;
                break;
            case 'aid': $data2 = pdo_get(PDO_NAME . 'oparea', array('areaid' => $id), array('aid'));
                if($data2['aid'])$returnid = $data2['aid'];
                break;
            case 'areaName': $data2 = pdo_get(PDO_NAME . 'area', array('id' => $id), array('name'));
                $returnid = $data2['name'];
                break;
            };
            break;
            case 'aid': switch($afterType){
                case 'sid': $data = pdo_getall(PDO_NAME . 'oparea', array('aid' => $id), array('areaid'));
                    if($data){
                        foreach($data as $key => $value){
                            $re[] = pdo_get(PDO_NAME . 'merchantuser', array('areaid' => $value['areaid']), array('id'));
                        }
                    }
                    $returnid = $re;
                    break;
                case 'areaid': $returnid = pdo_getall(PDO_NAME . 'oparea', array('aid' => $id), array('areaid'));
                    break;
                case 'aName': $returnid = pdo_get(PDO_NAME . 'agentusers', array('id' => $id), array('agentname'));
                    $returnid = $returnid['agentname'];
                    break;
                };
                break;
                case 'cateParentId': switch($afterType){
                    case 'cateParentName': $data = pdo_get(PDO_NAME . 'category_store', array('id' => $id), array('name'));
                        $returnid = $data['name'];
                        break;
                    case 'cateChildName': $returnid = pdo_getall(PDO_NAME . 'category_store', array('parentid' => $id), array('name'));
                        break;
                    case 'cateChildId': $returnid = pdo_getall(PDO_NAME . 'category_store', array('parentid' => $id), array('id'));
                        break;
                    };
                    break;
                    case 'cateChildId': switch($afterType){
                        case 'cateParentId': $data = pdo_get(PDO_NAME . 'category_store', array('id' => $id), array('parentid'));
                            $returnid = $data['parentid'];
                            break;
                        case 'cateChildName': $returnid2 = pdo_get(PDO_NAME . 'category_store', array('id' => $id), array('name'));
                            $returnid = $returnid2['name'];
                            break;
                        case 'cateParentName': $returnid2 = pdo_get(PDO_NAME . 'category_store', array('id' => $id), array('parentid'));
                            $returnid1 = pdo_get(PDO_NAME . 'category_store', array('id' => $returnid2['parentid']), array('name'));
                            $returnid = $returnid1['name'];
                            break;
                        };
                        break;
                    }
                    return $returnid;
                }
                static function getSingelData($select, $tablename, $where){
                $data = self :: createStandardWhereString($where);
                return pdo_fetch("SELECT $select FROM " . tablename($tablename) . " WHERE $data[0] ", $data[1]);
            }
            static function getNumData($select, $tablename, $where, $order = 'id DESC', $pindex = 0, $psize = 0, $ifpage = 0){
            global $_W;
            $data = self :: createStandardWhereString($where);
            $countStr = "SELECT COUNT(*) FROM " . tablename($tablename) . " WHERE $data[0] ";
            $selectStr = "SELECT $select FROM " . tablename($tablename) . " WHERE $data[0] ";
            $res = self :: getDataIfPage($countStr, $selectStr, $data[1], $pindex, $psize, $order, $ifpage);
            return $res;
        }
        static function getDataIfPage($countStr, $selectStr, $params, $pindex = 0, $psize = 0, $order = 'id DESC', $ifpage = 0){
        $pindex = max(1, intval($pindex));
        $total = $ifpage?pdo_fetchcolumn($countStr, $params):'';
        if($psize > 0 && $ifpage){
        $data = pdo_fetchall($selectStr . " ORDER BY $order " . " LIMIT " . ($pindex - 1) * $psize . ',' . $psize, $params);
    }else{
    $data = pdo_fetchall($selectStr . " ORDER BY $order", $params);
}
$pager = pagination($total, $pindex, $psize);
return array($data, $pager, $total);
}
static function createStandardWhereString($where = array()){
global $_W;
if(!is_array($where))return false;
$where['uniacid'] = $where['uniacid'] > 0?$where['uniacid']:$_W['uniacid'];
$sql = '';
foreach($where as $k => $v){
    $i = 0;
    if(isset($k) && $v === '')message('存在异常参数' . $k);
    if(strpos($k, '>') !== false){
        $k = trim(trim($k), '>');
        $eq = ' >= ';
    }elseif(strpos($k, '<') !== false){
        $k = trim(trim($k), '<');
        $eq = ' <= ';
    }elseif(strpos($k, '@') !== false){
        $eq = ' LIKE ';
        $k = trim(trim($k), '@');
        $v = "%" . $v . "%";
    }elseif(strpos($k, '#') !== false){
        $i = 1;
        $eq = ' IN ';
        $k = trim(trim($k), '#');
    }elseif(strpos($k, '!=') !== false){
        $i = 1;
        $eq = ' != ';
        $k = trim(trim($k), '!=');
    }elseif(strpos($k, '^') !== false){
        $i = 2;
        $arr = explode("^", $k);
        $num = count($arr);
        $str = '(';
        for($j = 0;$j < $num;$j++){
            if($num - $j == 1){
                $str .= $arr[$j] . " LIKE  '%" . $v . "%'";
            }else{
                $str .= $arr[$j] . " LIKE  '%" . $v . "%'" . " or ";
            }
        }
        $str .= ')';
    }else{
        $eq = ' = ';
    }
    if($i == 1){
        $sql .= 'AND `' . $k . '`' . $eq . $v . ' ';
    }elseif($i == 2){
        $sql .= 'AND ' . $str;
    }else{
        if($params[':' . $k]){
            $sql .= 'AND `' . $k . '`' . $eq . ':2' . $k . ' ';
            $params[':2' . $k] = $v;
        }else{
            $sql .= 'AND `' . $k . '`' . $eq . ':' . $k . ' ';
            $params[':' . $k] = $v;
        }
    }
}
$sql = trim($sql, 'AND');
return array($sql, $params);
}
static function changeAreaArray($arr){
$newarr = array();
foreach($arr as $key => $value){
    $newarr[$value['id']]['title'] = $value['name'];
    $newarr[$value['id']]['cities'] = array();
    foreach($value['children'] as $k => $v){
        $newarr[$value['id']]['cities'][$v['id']]['title'] = $v['name'];
    }
}
return $newarr;
}
static function wl_log($filename, $path, $filedata){
$url_log = $path . "log/" . date('Y-m-d', time()) . "/" . $filename . ".log";
$url_dir = $path . "log/" . date('Y-m-d', time());
if (!is_dir($url_dir)){
    mkdir($url_dir, 0777, true);
}
file_put_contents('payresult.log', var_export($r, true) . PHP_EOL, FILE_APPEND);
file_put_contents($url_log, var_export('/=====================================================================================' . date('Y-m-d H:i:s', time()) . '/', true) . PHP_EOL, FILE_APPEND);
file_put_contents($url_log, var_export($filedata, true) . PHP_EOL, FILE_APPEND);
return 'log_success';
}
static function Convert_GCJ02_To_BD09($lat, $lng){
$x_pi = 3.14159265358979324 * 3000.0 / 180.0;
$x = $lng;
$y = $lat;
$z = sqrt($x * $x + $y * $y) + 0.00002 * sin($y * $x_pi);
$theta = atan2($y, $x) + 0.000003 * cos($x * $x_pi);
$lng = $z * cos($theta) + 0.0065;
$lat = $z * sin($theta) + 0.006;
return array('lat' => $lat, 'lng' => $lng);
}
static function Convert_BD09_To_GCJ02($lat, $lng){
$x_pi = 3.14159265358979324 * 3000.0 / 180.0;
$x = $lng - 0.0065;
$y = $lat - 0.006;
$z = sqrt($x * $x + $y * $y) - 0.00002 * sin($y * $x_pi);
$theta = atan2($y, $x) - 0.000003 * cos($x * $x_pi);
$lng = $z * cos($theta);
$lat = $z * sin($theta);
return array('lat' => sprintf('%.6f', $lat), 'lng' => sprintf("%.6f", $lng));
}
}
