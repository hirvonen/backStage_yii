<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title>每日预约视图</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8">
	<link href="<?php echo BACK_CSS_URL; ?>mine.css" type="text/css" rel="stylesheet">
</head>

<body>
<!--<div style="width:1300px;height:500px;overflow:scroll;">-->
<div>
	<?php
	$aptm_model = Aptm::model();
	$day_info = array();
	/*
	 * array(beau_name, array1)
	 *      array1:(0,array2)上午
	 *             (1,array2)下午
	 *             (2,array2)傍晚
	 *              array2:(开始时间，结束时间，预约单号，客户姓名，客户号，预约项目，地址，联系方式，刷卡金额)
	 */

	function beau_infomation($aptm_day_info){
		$beau_aptm_infomation = array();    //array1
		for($i=0;$i<count($aptm_day_info);++$i){
			if(date("H", strtotime($aptm_day_info[$i]->aptm_time))<12){
				//上午
				$aptm_infomation = aptm_infomation($aptm_day_info[$i]);
				$beau_aptm_infomation[0] = $aptm_infomation;
			}
			elseif((date("H", strtotime($aptm_day_info[$i]->aptm_time))>=12) && (date("H", strtotime($aptm_day_info[$i]->aptm_time))<17)) {
				//下午
				$aptm_infomation = aptm_infomation($aptm_day_info[$i]);
				$beau_aptm_infomation[1] = $aptm_infomation;
			}
			elseif(date("H", strtotime($aptm_day_info[$i]->aptm_time))>=17) {
				//傍晚
				$aptm_infomation = aptm_infomation($aptm_day_info[$i]);
				$beau_aptm_infomation[2] = $aptm_infomation;
			}
		}

		return $beau_aptm_infomation;
	}
	function aptm_infomation($appointment){
		$order_item_model = Order_Item::model();
		$comm_service_model = Commodity_Service::model();
		$order_model = Order::model();
		$commodity_model = Commodity::model();
		$view_order_count_model = View_Order_Count::model();

		$aptm_infomation = array();
		//开始时间
		$start_time = date("H:i", strtotime($appointment->aptm_time));
		$aptm_infomation[0] = $start_time;
		//终了时间
		$query = 'select * from tbl_order_item where pk_ord_itm_id='.$appointment->aptm_ord_item_id;
		$order_item_info = $order_item_model->findBySql($query);
		$duration = 30;
		if(isset($order_item_info)){
			$query = 'select * from tbl_commodity_service where pk_serv_id='.$order_item_info->ord_item_comm_id;
			$comm_service_info = $comm_service_model->findBySql($query);
			if(isset($comm_service_info)){
				$duration += $comm_service_info->serv_duration;
			}
		}
		$end_time = date("H:i",strtotime("$start_time + $duration minute"));
		$aptm_infomation[1] = $end_time;
		//预约单号
//		$aptm_infomation[2] = $appointment->pk_aptm_id;
		//订单号
		if(isset($order_item_info)){
			$aptm_infomation[2] = $order_item_info->pk_ord_itm_ord_id;
		}
		//客户姓名
		$aptm_infomation[3] = $appointment->aptm_cust_name;
		//客户编号
		$cust_id = 0;
		if(isset($order_item_info)) {
			$query = 'select * from tbl_order where pk_ord_id=' . $order_item_info->pk_ord_itm_ord_id;
			$order_info = $order_model->findBySql($query);
			if(isset($order_info)){
				$cust_id = $order_info->ord_cust_id;
			}
		}
		$aptm_infomation[4] = $cust_id;
		//预约项目
		$aptm_name = '未知';
		if(isset($comm_service_info)){
			$query = 'select * from tbl_commodity where pk_comm_id='.$comm_service_info->pk_serv_id;
			$commodity_info = $commodity_model->findBySql($query);
			if(isset($commodity_info)){
				$aptm_name = $commodity_info->comm_name;
			}
		}
		$aptm_infomation[5] = $aptm_name;
		//地址
		$aptm_infomation[6] = $appointment->aptm_cust_addr;
		//联系方式
		$aptm_infomation[7] = $appointment->aptm_cust_tel;
		//刷卡金额
		$price = 0;
		if(isset($order_info)) {
			$query = 'select * from view_order_count where pk_ord_id = ' . $order_info->pk_ord_id;
			$view_order_count_info = $view_order_count_model->findBySql($query);
//			echo '<pre>';
//			print_r($view_order_count_info);
//			echo '</pre>';
			if (isset($view_order_count_info)) {
				$price = $view_order_count_info->total;
			}
			$price -= $order_info->ord_paid_money;
		}
		$aptm_infomation[8] = $price;

		return $aptm_infomation;
	}

	/**输出表头**/
	echo '<table border="2" width="100%" class="table_b">';
	echo '<tr><td height="10">'.date("Y-m-d",strtotime($day)).'</td></tr>';
	echo '<tr>';
	echo "<td width='120' height='10'>理疗师</td>";
	echo "<td width='120'>预约内容</td>";
	echo "<td width='250'>上午</td>";
	echo "<td width='250'>下午</td>";
	echo "<td width='250'>晚上</td>";
	echo '</tr>';

	/**准备表格具体内容**/
	//李启琴（1000009）
	$query = 'select * from tbl_appointment where aptm_beau_id=1000009';
	$aptm_select_info = $aptm_model->findAllBySql($query);
	$aptm_day_info = array();
	foreach ($aptm_select_info as $_v) {
		$aptm_time = date("Y-m-d", strtotime($_v->aptm_time));
		if($aptm_time==$day){
			$aptm_day_info[count($aptm_day_info)] = $_v;
		}
	}
	//查找上午中午下午
	$beau_aptm_infomation = beau_infomation($aptm_day_info);
	$day_info[0] = $beau_aptm_infomation;

	//范小荣（1000011）
	$query = 'select * from tbl_appointment where aptm_beau_id=1000011';
	$aptm_select_info = $aptm_model->findAllBySql($query);
	$aptm_day_info = array();
	foreach ($aptm_select_info as $_v) {
		$aptm_time = date("Y-m-d", strtotime($_v->aptm_time));
		if($aptm_time==$day){
			$aptm_day_info[count($aptm_day_info)] = $_v;
		}
	}
	//查找上午中午下午
	$beau_aptm_infomation = beau_infomation($aptm_day_info);
	$day_info[1] = $beau_aptm_infomation;

//	//文雪霞（1000013）
//	$query = 'select * from tbl_appointment where aptm_beau_id=1000013';
//	$aptm_select_info = $aptm_model->findAllBySql($query);
//	$aptm_day_info = array();
//	foreach ($aptm_select_info as $_v) {
//		$aptm_time = date("Y-m-d", strtotime($_v->aptm_time));
//		if($aptm_time==$day){
//			$aptm_day_info[count($aptm_day_info)] = $_v;
//		}
//	}
//	//查找上午中午下午
//	$beau_aptm_infomation = beau_infomation($aptm_day_info);
//	$day_info[2] = $beau_aptm_infomation;
//
//	//薛惠艺（1000014）
//	$query = 'select * from tbl_appointment where aptm_beau_id=1000014';
//	$aptm_select_info = $aptm_model->findAllBySql($query);
//	$aptm_day_info = array();
//	foreach ($aptm_select_info as $_v) {
//		$aptm_time = date("Y-m-d", strtotime($_v->aptm_time));
//		if($aptm_time==$day){
//			$aptm_day_info[count($aptm_day_info)] = $_v;
//		}
//	}
//	//查找上午中午下午
//	$beau_aptm_infomation = beau_infomation($aptm_day_info);
//	$day_info[3] = $beau_aptm_infomation;

	//张小倩（1000060）
	$query = 'select * from tbl_appointment where aptm_beau_id=1000060';
	$aptm_select_info = $aptm_model->findAllBySql($query);
	$aptm_day_info = array();
	foreach ($aptm_select_info as $_v) {
		$aptm_time = date("Y-m-d", strtotime($_v->aptm_time));
		if($aptm_time==$day){
			$aptm_day_info[count($aptm_day_info)] = $_v;
		}
	}
	//查找上午中午下午
	$beau_aptm_infomation = beau_infomation($aptm_day_info);
	$day_info[2] = $beau_aptm_infomation;

	//魏雪娇（1000089）
	$query = 'select * from tbl_appointment where aptm_beau_id=1000089';
	$aptm_select_info = $aptm_model->findAllBySql($query);
	$aptm_day_info = array();
	foreach ($aptm_select_info as $_v) {
		$aptm_time = date("Y-m-d", strtotime($_v->aptm_time));
		if($aptm_time==$day){
			$aptm_day_info[count($aptm_day_info)] = $_v;
		}
	}
	//查找上午中午下午
	$beau_aptm_infomation = beau_infomation($aptm_day_info);
	$day_info[3] = $beau_aptm_infomation;

	/**输出表格**/
	for($i=0;$i<4;++$i) {   //理疗师loop
		if($i%2==0){
			echo '<tr bgcolor="#add8e6">';
		}else{
			echo '<tr>';
		}
		switch($i){
			case 0:
				echo '<td>李启琴</td>';
				break;
			case 1:
				echo '<td>范小荣</td>';
				break;
//			case 2:
//				echo '<td>文</td>';
//				break;
//			case 3:
//				echo '<td>薛惠艺</td>';
//				break;
			case 2:
				echo '<td>张小倩</td>';
				break;
			case 3:
				echo '<td>魏雪娇</td>';
				break;
			default:
				echo '<td>未知</td>';
				break;
		}

		echo '<td>服务时间</td>';
		for($j=0;$j<3;++$j){    //上午中午下午loop
			if(!isset($day_info[$i][$j])){
				echo '<td></td>';
				continue;
			}
			echo '<td>';
			echo $day_info[$i][$j][0];
			echo '~';
			echo $day_info[$i][$j][1];
			echo '</td>';
		}
		echo '</tr>';

		if($i%2==0){
			echo '<tr bgcolor="#add8e6">';
		}else{
			echo '<tr>';
		}
		echo '<td></td>';//输出空格（理疗师栏对齐用）
		echo '<td>定单号</td>';
		for($j=0;$j<3;++$j){    //上午中午下午loop
			if(!isset($day_info[$i][$j])){
				echo '<td></td>';
				continue;
			}
			echo '<td>'.$day_info[$i][$j][2].'</td>';
		}
		echo '</tr>';

		if($i%2==0){
			echo '<tr bgcolor="#add8e6">';
		}else{
			echo '<tr>';
		}
		echo '<td></td>';//输出空格（理疗师栏对齐用）
		echo '<td>客户姓名</td>';
		for($j=0;$j<3;++$j){    //上午中午下午loop
			if(!isset($day_info[$i][$j])){
				echo '<td></td>';
				continue;
			}
			echo '<td>'.$day_info[$i][$j][3].'</td>';
		}
		echo '</tr>';

		if($i%2==0){
			echo '<tr bgcolor="#add8e6">';
		}else{
			echo '<tr>';
		}
		echo '<td></td>';//输出空格（理疗师栏对齐用）
		echo '<td>客户编号</td>';
		for($j=0;$j<3;++$j){    //上午中午下午loop
			if(!isset($day_info[$i][$j])){
				echo '<td></td>';
				continue;
			}
			echo '<td>'.$day_info[$i][$j][4].'</td>';
		}
		echo '</tr>';

		if($i%2==0){
			echo '<tr bgcolor="#add8e6">';
		}else{
			echo '<tr>';
		}
		echo '<td></td>';//输出空格（理疗师栏对齐用）
		echo '<td>预约项目</td>';
		for($j=0;$j<3;++$j){    //上午中午下午loop
			if(!isset($day_info[$i][$j])){
				echo '<td></td>';
				continue;
			}
			echo '<td>'.$day_info[$i][$j][5].'</td>';
		}
		echo '</tr>';

		if($i%2==0){
			echo '<tr bgcolor="#add8e6">';
		}else{
			echo '<tr>';
		}
		echo '<td></td>';//输出空格（理疗师栏对齐用）
		echo '<td>地址</td>';
		for($j=0;$j<3;++$j){    //上午中午下午loop
			if(!isset($day_info[$i][$j])){
				echo '<td></td>';
				continue;
			}
			echo '<td>'.$day_info[$i][$j][6].'</td>';
		}
		echo '</tr>';

		if($i%2==0){
			echo '<tr bgcolor="#add8e6">';
		}else{
			echo '<tr>';
		}
		echo '<td></td>';//输出空格（理疗师栏对齐用）
		echo '<td>联系方式</td>';
		for($j=0;$j<3;++$j){    //上午中午下午loop
			if(!isset($day_info[$i][$j])){
				echo '<td></td>';
				continue;
			}
			echo '<td>'.$day_info[$i][$j][7].'</td>';
		}
		echo '</tr>';

		if($i%2==0){
			echo '<tr bgcolor="#add8e6">';
		}else{
			echo '<tr>';
		}
		echo '<td></td>';//输出空格（理疗师栏对齐用）
		echo '<td>刷卡金额</td>';
		for($j=0;$j<3;++$j){    //上午中午下午loop
			if(!isset($day_info[$i][$j])){
				echo '<td></td>';
				continue;
			}
			echo '<td>'.$day_info[$i][$j][8].'</td>';
		}
		echo '</tr>';

		echo '</tr>';
	}

	echo '</table>';
	?>
</div>
</body>
</html>