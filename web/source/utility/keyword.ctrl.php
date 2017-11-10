<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/for more details.
 */
defined('IN_IA') or exit('Access Denied');
error_reporting(0);
if (!in_array($do, array('keyword'))) {
	exit('Access Denied');
}

if($do == 'keyword') {
	$type = trim($_GPC['type']);

	$condition = array('uniacid' => $_W['uniacid'], 'status' => 1);
	if ($type != 'all') {
		$condition = array('uniacid' => $_W['uniacid'], 'status' => 1, 'module' => $type);
	}

	$pindex = max(1, intval($_GPC['page']));
	$psize = 24;
	$rule_list = pdo_getslice('rule', $condition, array($pindex, $psize), $total);

	$keyword_lists = array();
	if(!empty($rule_list)) {
		foreach($rule_list as $row) {
			$condition['rid'] = $row['id'];
			$row['child_items'] = pdo_getall('rule_keyword', $condition);
			$keyword_lists[$row['id']] = $row;
		}
		unset($row);
	}
	$result = array(
		'items' => $keyword_lists,
		'pager' => pagination($total, $pindex, $psize, '', array('before' => '2', 'after' => '3', 'ajaxcallback'=>'null')),
	);
	iajax(0, $result);
}
