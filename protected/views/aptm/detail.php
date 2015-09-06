<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title>预约详细信息</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8">
	<link href="<?php echo BACK_CSS_URL; ?>mine.css" type="text/css" rel="stylesheet">
</head>

<body>

<div class="div_head">
            <span>
                <span style="float:left">当前位置是：用户管理-》修改预约详细信息</span>
	            <span style="float:right;margin-right: 8px;font-weight: bold">
		            <?php
		            if($source_page == "show") {
			            ?>
			            <a style="text-decoration: none" href="./index.php?r=aptm/show">【返回】</a>
		            <?php
		            }
		            else {
			            ?>
			            <a style="text-decoration: none" href="./index.php?r=aptm/cal">【返回】</a>
		            <?php
		            }
		            ?>
                </span>
            </span>
</div>
<div></div>

<div style="font-size: 13px;margin: 10px 5px">
	<?php
	//理疗师姓名查找用数据准备
	$beau_model = Beautician::model();
	$query = "select * from tbl_beautician";
	$beau_info = $beau_model->findAllBySql($query);
	//构建dropDownList的option用的数组
	$beau_options = array();
	foreach($beau_info as $_beau_v){
		if($_beau_v->beau_valid != 1){
			continue;
		}
		$beau_options["$_beau_v->pk_beau_id"] = "$_beau_v->beau_realname";
	}

	//商品名称及时间数据准备
	$ord_item_model = Order_Item::model();
	$ord_item_info = $ord_item_model->findByPk($aptm_info->aptm_ord_item_id);
	if(isset($ord_item_info)) {
		$comm_model = Commodity::model();
		$comm_info = $comm_model->findByPk($ord_item_info->ord_item_comm_id);

		$comm_serv_model = Commodity_Service::model();
		$comm_serv_info = $comm_serv_model->findByPk($ord_item_info->ord_item_comm_id);
	}
	?>
	<?php $form = $this->beginWidget('CActiveForm'); ?>
	<table border="1" width="100%" class="table_a">
		<tr bgcolor="#add8e6">
			<td>
				<?php echo $form->label($aptm_info, 'pk_aptm_id'); ?>
			</td>
			<td>
				<?php echo $aptm_info->pk_aptm_id; ?>
			</td>
		</tr>
		<tr bgcolor="#ffffff">
			<td>
				<?php echo $form->label($aptm_info, 'aptm_beau_id'); ?>
			</td>
			<td>
<!--				--><?php //echo $form->textField($aptm_info, 'aptm_beau_id'); ?>
				<?php
				$aptm_beau_info = $beau_model->findByPk($aptm_info->aptm_beau_id);
				if(!isset($aptm_beau_info)) {
					echo "理疗师未选择！请选择一名理疗师:";
				}
				echo $form->dropDownList($aptm_info,'aptm_beau_id',$beau_options);
				?>
			</td>
		</tr>
		<tr bgcolor="#add8e6">
			<td>
				<?php echo $form->label($aptm_info, 'aptm_ord_item_id'); ?>
			</td>
			<td>
				<?php
				if(isset($comm_info)) {
					echo $comm_info->comm_name;
				}
				else {
					echo $aptm_info->aptm_ord_item_id;
				}
				//				echo $form->textField($aptm_info, 'aptm_ord_item_id');
				?>
			</td>
		</tr>
		<tr bgcolor="#ffffff">
			<td>
				<?php echo $form->label($aptm_info, 'aptm_time'); ?>
			</td>
			<td>
<!--				--><?php //echo $form->textField($aptm_info, 'aptm_time'); ?>
				<?php echo $form->textField($aptm_info, 'aptm_time'); ?>
			</td>
		</tr>
		<tr bgcolor="#add8e6">
			<td>服务时长(分钟)</td>
			<td>
				<?php
				if(isset($comm_serv_info)) {
					echo $comm_serv_info->serv_duration;
				}
				else {
					echo $aptm_info->aptm_ord_item_id;
				}
				?>
			</td>
		</tr>
		<tr bgcolor="#ffffff">
			<td>预计结束时间</td>
			<td>
				<?php
				if(isset($comm_serv_info)) {
					echo date("Y-m-d H:i",strtotime("$aptm_info->aptm_time + $comm_serv_info->serv_duration minute"));
				}
				else {
					echo $aptm_info->aptm_ord_item_id;
				}
				?>
			</td>
		</tr>
		<tr bgcolor="#add8e6">
			<td>
				<?php echo $form->label($aptm_info, 'aptm_status'); ?>
			</td>
			<td>
<!--				--><?php //echo $form->dropDownList($aptm_info,'aptm_status',array(array(1=>'等待付款'),
//																				array(2=>'等待确认'),
//																				array(3=>'等待服务'),
//																				array(4=>'预约取消'),
//																				array(5=>'等待评价'),
//																				array(6=>'预约完成'))); ?>
				<?php echo $form->dropDownList($aptm_info,'aptm_status',array('请选择状态',
																				'等待付款',
																				'等待确认',
																				'等待服务',
																				'预约取消',
																				'等待评价',
																				'预约完成')); ?>
			</td>
		</tr>
		<tr bgcolor="#ffffff">
			<td>
				<?php echo $form->label($aptm_info, 'aptm_course_no'); ?>
			</td>
			<td>
				<?php echo $form->textField($aptm_info, 'aptm_course_no'); ?>
			</td>
		</tr>
		<tr bgcolor="#add8e6">
			<td>
				<?php echo $form->label($aptm_info, 'aptm_cust_name'); ?>
			</td>
			<td>
				<?php echo $form->textField($aptm_info, 'aptm_cust_name'); ?>
			</td>
		</tr>
		<tr bgcolor="#ffffff">
			<td>
				<?php echo $form->label($aptm_info, 'aptm_cust_tel'); ?>
			</td>
			<td>
				<?php echo $form->textField($aptm_info, 'aptm_cust_tel'); ?>
			</td>
		</tr>
		<tr bgcolor="#add8e6">
			<td>
				<?php echo $form->label($aptm_info, 'aptm_cust_addr'); ?>
			</td>
			<td>
				<?php echo $form->textArea($aptm_info, 'aptm_cust_addr',array('cols'=>100,'rows'=>5)); ?>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<input type="submit" value="修改">
			</td>
		</tr>
	</table>
	<?php $this->endWidget(); ?>
</div>

</body>
</html>