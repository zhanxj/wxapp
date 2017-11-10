<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/for more details.
 */
defined('IN_IA') or exit('Access Denied');


class WeSession implements SessionHandlerInterface {
	
	public static $uniacid;
	
	public static $openid;
	
	public static $expire;

	
	public static function start($uniacid, $openid, $expire = 3600) {
				if (version_compare(PHP_VERSION, '7.0.0') < 0) {
			if (extension_loaded('memcache') && !empty($cache_setting['memcache']['server']) && !empty($cache_setting['memcache']['session'])) {
				ini_set("session.save_handler", "memcache");
				ini_set("session.save_path", "tcp://{$cache_setting['memcache']['server']}:{$cache_setting['memcache']['port']}");
			} elseif (extension_loaded('redis') && !empty($cache_setting['redis']['server']) && !empty($cache_setting['redis']['session'])) {
				ini_set("session.save_handler", "redis");
				ini_set("session.save_path", "tcp://{$cache_setting['redis']['server']}:{$cache_setting['redis']['port']}");
			}
		} elseif (extension_loaded('memcached') && !empty($cache_setting['memcache']['server']) && !empty($cache_setting['memcache']['session'])) {
			ini_set("session.save_handler", "memcached");
			ini_set("session.save_path", "{$cache_setting['memcache']['server']}:{$cache_setting['memcache']['port']}");
		} else {
			WeSession::$uniacid = $uniacid;
			WeSession::$openid = $openid;
			WeSession::$expire = $expire;
			$sess = new WeSession();
			if (version_compare(PHP_VERSION, '5.4') >= 0) {
				session_set_save_handler($sess, true);
			} else {
				session_set_save_handler(
					array(&$sess, 'open'),
					array(&$sess, 'close'),
					array(&$sess, 'read'),
					array(&$sess, 'write'),
					array(&$sess, 'destroy'),
					array(&$sess, 'gc')
				);
			}
		}
		register_shutdown_function('session_write_close');
		session_start();
	}

	public function open($save_path, $session_name) {
		return true;
	}

	public function close() {
		return true;
	}

	
	public function read($sessionid) {
		$sql = 'SELECT * FROM ' . tablename('core_sessions') . ' WHERE `sid`=:sessid AND `expiretime`>:time';
		$params = array();
		$params[':sessid'] = $sessionid;
		$params[':time'] = TIMESTAMP;
		$row = pdo_fetch($sql, $params);
		if(is_array($row) && !empty($row['data'])) {
			return $row['data'];
		}
		return '';
	}

	
	public function write($sessionid, $data) {
		$row = array();
		$row['sid'] = $sessionid;
		$row['uniacid'] = WeSession::$uniacid;
		$row['openid'] = WeSession::$openid;
		$row['data'] = $data;
		$row['expiretime'] = TIMESTAMP + WeSession::$expire;
		return pdo_insert('core_sessions', $row, true) >= 1;
	}

	
	public function destroy($sessionid) {
		$row = array();
		$row['sid'] = $sessionid;

		return pdo_delete('core_sessions', $row) == 1;
	}

	
	public function gc($expire) {
		$sql = 'DELETE FROM ' . tablename('core_sessions') . ' WHERE `expiretime`<:expire';

		return pdo_query($sql, array(':expire' => TIMESTAMP)) == 1;
	}
}