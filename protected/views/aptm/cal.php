<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title>预约视图</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8">
	<link href="<?php echo BACK_CSS_URL; ?>mine.css" type="text/css" rel="stylesheet">
</head>

<body>
<!--<div style="width:1300px;height:500px;overflow:scroll;">-->
<div>
	<?php
	//定义model用于取得duration和地址（区名）
	$order_item_model = Order_Item::model();
	$commodity_service_model = Commodity_Service::model();
	$order_model = Order::model();
	$address_model = Address::model();

	$day = date("Y-m-d", time());
	echo '<table border="2" width="100%" class="table_a">';
	echo '<tr>';
	echo "<td width='120'>理疗师</td>";
	for($i=0;$i<15;$i++){
		if($i%2 == 0) {
			echo "<td bgcolor='#add8e6'>".
				"<a href='./index.php?r=aptm/dayCal&day=".$day."' target=_blank>".
				$day.
				'</a></td>';
		}
		else{
			echo "<td bgcolor='#7fffd4'>".
				"<a href='./index.php?r=aptm/dayCal&day=".$day."' target=_blank>".
				$day.
				'</a></td>';
		}
		$day = date("Y-m-d",strtotime("$day +1 day"));
	}

	echo '</tr>';

	//计算美容师人数，为第一层for循环做准备
	$beau_num = count($beau_info);

	//取得每个预约的美容师id，为第二层for循环做准备
	$aptm_num = count($aptm_info);
	$aptm_beau_name = array();
	$beau_model = Beautician::model();
	for($i=0;$i<$aptm_num;$i++){
		$aptm_item = $aptm_info[$i];
		$beau_item_1 = $beau_model->findByPk($aptm_item->aptm_beau_id);
		if(isset($beau_item_1)) {
			$aptm_beau_name[$i] = $beau_item_1->beau_realname;
		}
		else{
			$aptm_beau_name[$i] = "NULL";
		}
	}

	$day = date("Y-m-d", time());

	//输出未安排理疗师表
	echo "<tr>";
	echo "<td width='120'>未安排</td>";
	for($i=0;$i<15;$i++){
		$null_aptm = array();
		$null_aptm_name = array();
		for($j=0;$j<$aptm_num;$j++){
			$null_aptm_item = $aptm_info[$j];
			$null_time = date("Y-m-d", strtotime($null_aptm_item->aptm_time));
			if(($null_time==$day)&&($null_aptm_item->aptm_beau_id==null)) {
				$null_aptm_name[0] = $null_aptm_item->pk_aptm_id;
				$null_aptm_name[1] = $null_aptm_item->aptm_cust_name;
				$null_aptm_name[2] = date('H:i', strtotime($null_aptm_item->aptm_time));
				$null_aptm_name[3] = $null_aptm_item->aptm_ord_item_id;
				$null_aptm[count($null_aptm)] = $null_aptm_name;
			}
		}
		if(isset($null_aptm)){
			echo "<td width='120'>";
			for ($k=0;$k<count($null_aptm);$k++) {
				$duration = 30; //需要将按摩时间加长30分钟以便获得一些余量
				$district = '未知';
				$query = 'select * from tbl_order_item where pk_ord_itm_id='.$null_aptm[$k][3];
				$order_item_info = $order_item_model->findBySql($query);
				if(isset($order_item_info)){
					//取duration
					$query = 'select * from tbl_commodity_service where pk_serv_id='.$order_item_info->ord_item_comm_id;
					$commodity_service_info = $commodity_service_model->findBySql($query);
					if(isset($commodity_service_info)){
						$duration += $commodity_service_info->serv_duration;
					}
					//取区名
					$query = 'select * from tbl_order where pk_ord_id='.$order_item_info->pk_ord_itm_ord_id;
					$order_info = $order_model->findBySql($query);
					if(isset($order_info)){
						$query = 'select * from tbl_address where addr_cust_id='.$order_info->ord_cust_id;
						$address_info = $address_model->findBySql($query);
						if(isset($address_info)){
							$district = $address_info->addr_district;
							switch($district){
								case 1:
									$district = '黄埔';
									break;
								case 2:
									$district = '静安';
									break;
								case 3:
									$district = '徐汇';
									break;
								case 4:
									$district = '卢湾';
									break;
								case 5:
									$district = '长宁';
									break;
								case 6:
									$district = '闸北';
									break;
								case 7:
									$district = '虹口';
									break;
								case 8:
									$district = '杨浦';
									break;
								case 9:
									$district = '浦东';
									break;
								case 10:
									$district = '普陀';
									break;
								case 11:
									$district = '闵行';
									break;
								case 12:
									$district = '宝山';
									break;
								case 13:
									$district = '嘉定';
									break;
								case 14:
									$district = '松江';
									break;
								case 15:
									$district = '青浦';
									break;
								case 16:
									$district = '奉贤';
									break;
								case 17:
									$district = '金山';
									break;
								case 18:
									$district = '崇明';
									break;
								default:
									$district = '上海';
									break;
							}
						}
					}
				}
				$starttime = $null_aptm[$k][2];
				$endtime = date("H:i",strtotime("$starttime + $duration minute"));

				echo "<a style='text-decoration: underline' href='./index.php?r=aptm/detail&id=".
					$null_aptm[$k][0].
					"&source_page=cal"."'>".
					$null_aptm[$k][1].
					'('.
					$district.
					')'.
					' '.
					$starttime.
					'~'.
					$endtime.
					'</a>';
				echo "<br>";
			}
			echo "</td>";
		}
		else{
			echo "<td width='120'></td>";
		}
		$day = date("Y-m-d",strtotime("$day +1 day"));
	}
	echo "</tr>";

	//输出未安排的1元体验列表
	echo "<tr>";
	echo "<td width='120'>未安排(活动)</td>";
	$contact_model = Contact::model();
	$day = date("Y-m-d", time());
	$query = 'select * from tbl_contact where con_time >='.$day;
	$contact_info = $contact_model->findAllBySql($query);
	$contact_num = count($contact_info);

	for($i=0;$i<15;$i++) {
		$null_contact = array();
		for($j=0;$j<$contact_num;$j++) {
			$null_time = date("Y-m-d", strtotime($contact_info[$j]->con_time));
			if(($null_time==$day)&&($contact_info[$j]->con_beau_id==null)) {
				$null_contact[count($null_contact)] = $contact_info[$j];
			}
		}
		if(isset($null_contact)){
			echo "<td width='120'>";
			for ($k=0;$k<count($null_contact);$k++) {
				$duration = 30; //需要将按摩时间加长30分钟以便获得一些余量
				switch($null_contact[$k]->con_prefer) {
					case 1:
						//透润美肤(tbl_commodity:10023)
						$duration += 80;
						break;
					case 2:
						//经络养生(tbl_commodity:10008)
						$duration += 60;
						break;
					case 3:
						//经络纤体/淋巴排毒(tbl_commodity:10001)
						$duration += 90;
						break;
					default:
						//种别错误，时长默认设为90分钟（60+30）
						$duration += 60;
						break;
				}
				$district = '未知';
				switch($null_contact[$k]->con_district) {
					case 1:
						$district = '黄埔';
						break;
					case 2:
						$district = '静安';
						break;
					case 3:
						$district = '徐汇';
						break;
					case 4:
						$district = '卢湾';
						break;
					case 5:
						$district = '长宁';
						break;
					case 6:
						$district = '闸北';
						break;
					case 7:
						$district = '虹口';
						break;
					case 8:
						$district = '杨浦';
						break;
					case 9:
						$district = '浦东';
						break;
					case 10:
						$district = '普陀';
						break;
					case 11:
						$district = '闵行';
						break;
					case 12:
						$district = '宝山';
						break;
					case 13:
						$district = '嘉定';
						break;
					case 14:
						$district = '松江';
						break;
					case 15:
						$district = '青浦';
						break;
					case 16:
						$district = '奉贤';
						break;
					case 17:
						$district = '金山';
						break;
					case 18:
						$district = '崇明';
						break;
					default:
						$district = $null_contact[$k]->con_district;
						break;
				}
				$starttime = date('H:i', strtotime($null_contact[$k]->con_time));;
				$endtime = date("H:i",strtotime("$starttime + $duration minute"));

				echo "<a style='text-decoration: underline' href='./index.php?r=aptm/detailOther&id=".
					$null_contact[$k]->pk_contact_id.
					"&source_page=cal"."'>".
					$null_contact[$k]->con_name.
					'('.
					$district.
					')'.
					' '.
					$starttime.
					'~'.
					$endtime.
					'</a>';
				echo "<br>";
			}
			echo "</td>";
		}
		else{
			echo "<td width='120'></td>";
		}
		$day = date("Y-m-d",strtotime("$day +1 day"));
	}
	echo "</tr>";

	//输出理疗师日程表
	for($i=0;$i<$beau_num;$i++){
		$beau_item = $beau_info[$i];
		if($beau_item->beau_valid != 1){
			continue;//理疗师必须在岗才输出预约
		}
		echo '<tr>';
		echo '<td>'.$beau_item->beau_realname.'</td>';
		$day = date("Y-m-d", time());
		for($j=0;$j<15;$j++){
			$one_day_multi_check = array();
			$aptm_id_time = array();
			//按照日期来轮巡
			for($k=0;$k<$aptm_num;$k++){
				//找到当天的日期
				$aptm_item = $aptm_info[$k];
				//$beau_item_1 = $beau_model->findAllByPk($aptm_item->aptm_beau_id);
				$time = date("Y-m-d", strtotime($aptm_item->aptm_time));
				if(($time==$day)&&($beau_item->beau_realname==$aptm_beau_name[$k])){
					$aptm_id_time[0] = $aptm_item->pk_aptm_id;
					$aptm_id_time[1] = $aptm_item->aptm_cust_name;
					$aptm_id_time[2] = date("H:i", strtotime($aptm_item->aptm_time));
					$aptm_id_time[3] = $aptm_item->aptm_ord_item_id;
					$one_day_multi_check[count($one_day_multi_check)] = $aptm_id_time;
				}
			}

			//输出格子
			$have_aptm = 0;
			switch(count($one_day_multi_check)){
				case 0:
					echo "<td width='120' bgcolor='green'>无预约</td>";
					break;
				case 1:
					echo "<td width='120' bgcolor='#1e90ff'>";
					$have_aptm = 1;
					break;
				case 2:
				case 3:
				case 4:
				case 5:
				case 6:
				case 7:
				case 8:
				case 9:
				case 10:
				case 11:
				case 12:
				case 13:
				case 14:
				case 15:
					echo "<td width='120' bgcolor='red'>";
					$have_aptm = 1;
					break;
				default:
					echo "<td bgcolor='yellow'>sth went wrong!</td>";
					break;
			}
			if($have_aptm == 1) {
				for ($oneday_time = 0; $oneday_time < count($one_day_multi_check); $oneday_time++) {
					$duration = 0;
					$duration = '未知';

					//取得每个预约的duration
					$query = 'select * from tbl_order_item where pk_ord_itm_id='.$one_day_multi_check[$oneday_time][3];
					$order_item_info = $order_item_model->findBySql($query);
					if(isset($order_item_info)){
						//取duration
						$query = 'select * from tbl_commodity_service where pk_serv_id='.$order_item_info->ord_item_comm_id;
						$commodity_service_info = $commodity_service_model->findBySql($query);
						if(isset($commodity_service_info)){
							$duration = $commodity_service_info->serv_duration;
						}

						//取区名
						$query = 'select * from tbl_order where pk_ord_id='.$order_item_info->pk_ord_itm_ord_id;
						$order_info = $order_model->findBySql($query);
						if(isset($order_info)){
							$query = 'select * from tbl_address where addr_cust_id='.$order_info->ord_cust_id;
							$address_info = $address_model->findBySql($query);
							if(isset($address_info)){
								$district = $address_info->addr_district;
								switch($district){
									case 1:
										$district = '黄埔';
										break;
									case 2:
										$district = '静安';
										break;
									case 3:
										$district = '徐汇';
										break;
									case 4:
										$district = '卢湾';
										break;
									case 5:
										$district = '长宁';
										break;
									case 6:
										$district = '闸北';
										break;
									case 7:
										$district = '虹口';
										break;
									case 8:
										$district = '杨浦';
										break;
									case 9:
										$district = '浦东';
										break;
									case 10:
										$district = '普陀';
										break;
									case 11:
										$district = '闵行';
										break;
									case 12:
										$district = '宝山';
										break;
									case 13:
										$district = '嘉定';
										break;
									case 14:
										$district = '松江';
										break;
									case 15:
										$district = '青浦';
										break;
									case 16:
										$district = '奉贤';
										break;
									case 17:
										$district = '金山';
										break;
									case 18:
										$district = '崇明';
										break;
									default:
										$district = '上海';
										break;
								}
							}
						}
					}
					$starttime = $one_day_multi_check[$oneday_time][2];
					$duration += 30;//需要将按摩时间加长30分钟以便获得一些余量
					$endtime = date("H:i",strtotime("$starttime + $duration minute"));

					echo "<a style='text-decoration: underline' href='./index.php?r=aptm/detail&id=" .
						$one_day_multi_check[$oneday_time][0].
						"&source_page=cal" . "'>" .
						$one_day_multi_check[$oneday_time][1].
						'('.
						$district.
						')'.
						" " .
						$starttime.
						"~" .
						$endtime.
						"</a>";
					echo "<br>";
				}
			}
			echo "</td>";
			$day = date("Y-m-d",strtotime("$day +1 day"));
		}
		echo '</tr>';

		//再来一行，输出1元体验的预约情况
		echo '<tr>';
		echo '<td>'.$beau_item->beau_realname.'(活动)'.'</td>';
		$contact_model = Contact::model();
		$day = date("Y-m-d", time());
		$query = 'select * from tbl_contact where con_time >='.$day.' and con_beau_id ='.$beau_item->pk_beau_id;
		$contact_info = $contact_model->findAllBySql($query);
		$contact_day_info = array();

		for($j=0;$j<15;$j++) {
			$null_day_flag = false;
			$day_cnt = 0;//数组的每一天的数据都会是一个预约list数组（二维数组），本变量是数组的第二维index
			foreach ($contact_info as $_v_contact_info) {
				$contact_time = date("Y-m-d", strtotime($_v_contact_info->con_time));
				if($contact_time == $day) {
					$null_day_flag = true;
					$contact_day_info[$j][$day_cnt] = $_v_contact_info;
					$day_cnt++;
				}
			}
			if(!$null_day_flag) {
				$contact_day_info[$j] = null;
			}
			$day = date("Y-m-d",strtotime("$day +1 day"));
		}
		for($j=0;$j<15;$j++) {
			echo '<td bgcolor="#ffffe0">';
			if(!isset($contact_day_info[$j])) {
				echo '</td>';
				continue;
			}
			for($k=0;$k<count($contact_day_info[$j]);$k++) {
				$duration = 30; //需要将按摩时间加长30分钟以便获得一些余量
				switch($contact_day_info[$j][$k]->con_prefer) {
					case 1:
						//透润美肤(tbl_commodity:10023)
						$duration += 80;
						break;
					case 2:
						//经络养生(tbl_commodity:10008)
						$duration += 60;
						break;
					case 3:
						//经络纤体/淋巴排毒(tbl_commodity:10001)
						$duration += 90;
						break;
					default:
						//种别错误，时长默认设为90分钟（60+30）
						$duration += 60;
						break;
				}
				$district = '未知';
				switch($contact_day_info[$j][$k]->con_district) {
					case 1:
						$district = '黄埔';
						break;
					case 2:
						$district = '静安';
						break;
					case 3:
						$district = '徐汇';
						break;
					case 4:
						$district = '卢湾';
						break;
					case 5:
						$district = '长宁';
						break;
					case 6:
						$district = '闸北';
						break;
					case 7:
						$district = '虹口';
						break;
					case 8:
						$district = '杨浦';
						break;
					case 9:
						$district = '浦东';
						break;
					case 10:
						$district = '普陀';
						break;
					case 11:
						$district = '闵行';
						break;
					case 12:
						$district = '宝山';
						break;
					case 13:
						$district = '嘉定';
						break;
					case 14:
						$district = '松江';
						break;
					case 15:
						$district = '青浦';
						break;
					case 16:
						$district = '奉贤';
						break;
					case 17:
						$district = '金山';
						break;
					case 18:
						$district = '崇明';
						break;
					default:
						$district = $contact_day_info[$j][$k]->con_district;
						break;
				}
				$starttime = date('H:i', strtotime($contact_day_info[$j][$k]->con_time));;
				$endtime = date("H:i",strtotime("$starttime + $duration minute"));

				echo "<a style='text-decoration: underline' href='./index.php?r=aptm/detailOther&id=".
					$contact_day_info[$j][$k]->pk_contact_id.
					"&source_page=cal"."'>".
					$contact_day_info[$j][$k]->con_name.
					'('.
					$district.
					')'.
					' '.
					$starttime.
					'~'.
					$endtime.
					'</a>';
				echo "<br>";
			}
			echo '</td>';
		}
		echo '</tr>';
	}

	echo '</table>';
	?>
</div>
</body>
</html>