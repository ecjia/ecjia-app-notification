<?php
defined('IN_ECJIA') or exit('No permission resources.');
/**
 * 消息中心
 * @author will.chen
 *
 */
class notification_module extends api_admin implements api_interface {
	
    public function handleRequest(\Royalcms\Component\HttpKernel\Request $request) {	
    	
//     	if ($_SESSION['admin_id'] <= 0 && $_SESSION['staff_id'] <= 0) {
//             return new ecjia_error(100, 'Invalid session');
//         }
		
    	$_SESSION['staff_id'] = 57;
    	
    	$size = $this->requestData('pagination.count', 15);
    	$page = $this->requestData('pagination.page', 2);
    	
    	$record_count = RC_DB::table('notifications')->count();
    	
    	//实例化分页
    	$page_row = new ecjia_page($record_count, $size, 6, '', $page);
    	$skip = $page_row->start_id-1;
        $notifications_result = RC_DB::table('notifications')->skip($skip)->take($size)->get();
        
        $notifications_list = array();
        
        if (!empty($notifications_result)) {
        	$express_order_db = RC_Model::model('express/express_order_viewmodel');
        	foreach ($notifications_result as $val) {
        		$data = json_decode($val['data'], true);
        		$data['express_id'] = 3;
        		$where = array('staff_id' => $_SESSION['staff_id'], 'express_id' => $data['express_id']);
        		$field = 'eo.*, oi.add_time as order_time, oi.pay_time, oi.order_amount, oi.pay_name, sf.merchants_name, sf.address as merchant_address, sf.longitude as merchant_longitude, sf.latitude as merchant_latitude';
        		$express_order_info = $express_order_db->field($field)->join(array('delivery_order', 'order_info', 'store_franchisee'))->where($where)->find();
        		
        		$notifications_list[] = array(
        						'id'	=> $val['id'],
        						'type'	=> 'express_assign',//$val['type'],
        						'time'	=> $val['created_at'],
        						'title'	=> $data['title'],
        						'description'	=> $data['body'],
        						'read_status'	=> empty($val['read_at']) ? 'unread' : 'read',
        						'data'	=> array(
        								'express_id'	=> $express_order_info['express_id'],
						    			'express_sn'	=> $express_order_info['express_sn'],
						    			'express_type'	=> $express_order_info['from'],
						    			'label_express_type'	=> $express_order_info['from'] == 'assign' ? '系统派单' : '抢单',
						    			'order_sn'		=> $express_order_info['order_sn'],
						    			'payment_name'	=> $express_order_info['pay_name'],
						    			'express_from_address'	=> '【'.$express_order_info['merchants_name'].'】'. $express_order_info['merchant_address'],
						    			'express_from_location'	=> array(
						    					'longitude' => $express_order_info['merchant_longitude'],
						    					'latitude'	=> $express_order_info['merchant_latitude'],
						    			),
						    			'express_to_address'	=> $express_order_info['address'],
						    			'express_to_location'	=> array(
						    					'longitude' => $express_order_info['longitude'],
						    					'latitude'	=> $express_order_info['latitude'],
						    			),
						    			'distance'		=> $express_order_info['distance'],
						    			'consignee'		=> $express_order_info['consignee'],
						    			'mobile'		=> $express_order_info['mobile'],
						    			'order_time'	=> RC_Time::local_date(ecjia::config('time_format'), $express_order_info['add_time']),
						    			'pay_time'		=> empty($express_order_info['pay_time']) ? '' : RC_Time::local_date(ecjia::config('time_format'), $express_order_info['pay_time']),
						    			'best_time'		=> empty($express_order_info['best_time']) ? '' : RC_Time::local_date(ecjia::config('time_format'), $express_order_info['best_time']),
						    			'shipping_fee'	=> $express_order_info['shipping_fee'],
						    			'order_amount'	=> $express_order_info['order_amount'],
        						),
        		);
        	}
        }
        
		$pager = array(
				'total' => $page_row->total_records,
				'count' => $page_row->total_records,
				'more'	=> $page_row->total_pages <= $page ? 0 : 1,
		);
		
		return array('data' => $notifications_list, 'pager' => $pager);
	 }	
}
// end