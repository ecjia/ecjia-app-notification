<?php
/**
 * 添加管理员记录日志操作对象
 */

function assign_adminlog_content() {
	ecjia_admin_log::instance()->add_action('batch_mark', '批量标记');
	ecjia_admin_log::instance()->add_action('mark', '标记');
	
	ecjia_admin_log::instance()->add_object('notice', '通知');
}

//end