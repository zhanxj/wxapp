<?php
//decode by QQ:287907476 http://www.5kym.com/

defined('IN_IA') or exit('Access Denied');
set_time_limit(0);

class database
{
	//public function __construct()
	//{
		//global $_W;
		//if (!$_W['isfounder']) {
			//message('无权访问!');
		//}
	//}

	public function run()
	{
		global $_W, $_GPC;
		if (checksubmit()) {
			$sql = $_POST['sql'];
			pdo_run($sql);
			message('查询执行成功.', 'refresh');
		}
		include wl_template('cloud/database');
	}

	public function datemana()
	{
		global $_W, $_GPC;
		include wl_template('cloud/datemana');
	}

	public function testdata()
	{
		global $_W, $_GPC;
		$type = !empty($_GPC['type']) ? $_GPC['type'] : 'install';
		if ($type == 'install') {
			$this->clear_data();
			$this->install_data();
			$sql = file_get_contents(PATH_CORE . "common/testdb.php");
			$sql = str_replace("'37'", "'" . $_W['uniacid'] . "'", $sql);
			$sql = str_replace("i=37", "i=" . $_W['uniacid'], $sql);
			$sql = str_replace("http://demo.weliam.cn/", $_W['siteroot'], $sql);
			pdo_run($sql);
			message('测试数据安装成功', web_url('cloud/database/datemana'), 'success');
		}
		if ($type == 'clear') {
			$this->clear_data();
			$this->install_data();
			message('测试数据清除成功', web_url('cloud/database/datemana'), 'success');
		}
	}

	public function areadata()
	{
		global $_W, $_GPC;
		$type = !empty($_GPC['type']) ? $_GPC['type'] : 'install';
		if ($type == 'install') {
			$id = pdo_getcolumn(PDO_NAME . 'area', array('id' => 110000), 'id');
			if ($id) {
				message('存在地区数据，请先清除以后再试.', web_url('cloud/database/datemana'), 'warning');
			}
			$sql = file_get_contents(PATH_CORE . "common/db.php");
			$sql = str_replace(' ims_', ' ' . tablename(), $sql);
			pdo_run($sql);
			message('地区数据安装成功.', web_url('cloud/database/datemana'), 'success');
		}
		if ($type == 'clear') {
			$id = pdo_getcolumn(PDO_NAME . 'area', array('id' => 110000), 'id');
			if (empty($id)) {
				message('不存在地区数据，无需再清除.', web_url('cloud/database/datemana'), 'warning');
			}
			pdo_query('TRUNCATE TABLE ' . tablename('wlmerchant_area') . ";");
			message('地区数据清除成功.', web_url('cloud/database/datemana'), 'success');
		}
	}

	private function clear_data()
	{
		$table_name = array('wlmerchant_waittask', 'wlmerchant_vip_record', 'wlmerchant_storeusers_group', 'wlmerchant_rush_order', 'wlmerchant_rush_activity', 'wlmerchant_role', 'wlmerchant_refund_record', 'wlmerchant_puvrecord', 'wlmerchant_adv', 'wlmerchant_agentusers', 'wlmerchant_agentusers_group', 'wlmerchant_apirecord', 'wlmerchant_banner', 'wlmerchant_category_store', 'wlmerchant_collect', 'wlmerchant_comment', 'wlmerchant_couponlist', 'wlmerchant_creditrecord', 'wlmerchant_goodshouse', 'wlmerchant_indexset', 'wlmerchant_member', 'wlmerchant_member_coupons', 'wlmerchant_merchant_account', 'wlmerchant_merchant_money_record', 'wlmerchant_merchant_record', 'wlmerchant_merchantdata', 'wlmerchant_merchantuser', 'wlmerchant_merchantuser_qrlog', 'wlmerchant_nav', 'wlmerchant_notice', 'wlmerchant_oparea', 'wlmerchant_oplog', 'wlmerchant_paylog', 'wlmerchant_puv');
		foreach ($table_name as $key => $value) {
			pdo_query("DROP TABLE IF EXISTS " . tablename($value) . ";");
		}
	}

	private function install_data()
	{
		$updatefile = IA_ROOT . '/addons/' . MODULE_NAME . '/upgrade.php';
		require $updatefile;
	}
}