<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title>预约(其他)详细信息</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8">
	<link href="<?php echo BACK_CSS_URL; ?>mine.css" type="text/css" rel="stylesheet">
</head>

<body>

<div class="div_head">
            <span>
                <span style="float:left">当前位置是：预约管理-》修改预约(其他)详细信息</span>
	            <span style="float:right;margin-right: 8px;font-weight: bold">
		            <?php
		            if($source_page == "show") {
			            ?>
			            <a style="text-decoration: none" href="#">【返回】</a>
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
	//美疗师姓名查找用数据准备
	$beau_model = Beautician::model();
	$query = "select * from tbl_beautician";
	$beau_info = $beau_model->findAllBySql($query);
	//构建美疗师dropDownList的option用的数组
	$beau_options = array();
	foreach($beau_info as $_beau_v) {
		if($_beau_v->beau_valid != 1) {
			continue;
		}
		$beau_options["$_beau_v->pk_beau_id"] = "$_beau_v->beau_realname";
	}

	//构建服务项目dropDownList的option用的数组
//	$code_model = Code::model();
//	$query = 'select * from tbl_code where code_tbl_name='.'"tbl_contact"'.' and '.'code_name='.'"con_prefer"';
//	$code_info = $code_model->findAllBySql($query);
//	$prefer_options = array();
//	foreach($code_info as $_code_v) {
//		$prefer_options[$_code_v->code_value] = $_code_v->code_meaning;
//	}
	switch($contact_info->con_kind) {
		case OTHER_KIND_1YUAN:
			$prefer_options = array ('1'=>'透润美肤', '2'=>'经络养生', '3'=>'经络纤体/淋巴排毒');
			break;
		case OTHER_KIND_88YUAN:
		case OTHER_KIND_SGB:
			$prefer_options = array ('4'=>'经络养生','5'=>'透润美肤');
			break;
		case OTHER_KIND_168YUAN:
			$prefer_options = array ('6'=>'深层淋巴净排','7'=>'经络纤体','8'=>'轻盈塑体（局部）','9'=>'经络养生调理','10'=>'肩颈调理',
				'11'=>'温肾固本','12'=>'肝胆养护','13'=>'补气养血','14'=>'关节理疗（膝盖）','15'=>'透润美肤',
				'16'=>'白皙美肤','17'=>'3D紧致美肤','18'=>'乳腺疏通散结/开奶','19'=>'骨盆调整','20'=>'胸部紧致提升');
		default:
			break;
	}

	//构建区域dropDownList的option用的数组
	$district_options = array('上海','黄埔','静安','徐汇','卢湾','长宁',
		'闸北','虹口','杨浦','浦东','普陀',
		'闵行','宝山','嘉定','松江','青浦',
		'奉贤','金山','崇明');
	?>
	<?php $form = $this->beginWidget('CActiveForm'); ?>
	<table border="1" width="100%" class="table_a">
		<tr bgcolor="#add8e6">
			<td>
				<?php echo $form->label($contact_info, 'pk_contact_id'); ?>
			</td>
			<td>
				<?php echo $contact_info->pk_contact_id; ?>
				<?php
				switch($contact_info->con_kind) {
					case OTHER_KIND_1YUAN:
						echo '(1元活动)';
						break;
					case OTHER_KIND_88YUAN:
						echo '(88元活动)';
						break;
					case OTHER_KIND_SGB:
						echo '(圣戈班活动)';
						break;
					case OTHER_KIND_168YUAN:
						echo '(168元活动)';
						break;
					default:
						echo '(未知活动)';
						break;
				}
				?>
			</td>
		</tr>
		<tr bgcolor="#ffffff">
			<td>
				<?php echo $form->label($contact_info, 'con_beau_id'); ?>
			</td>
			<td>
				<?php
				$beau_model = Beautician::model();
				$con_beau_info = $beau_model->findByPk($contact_info->con_beau_id);
				if(!isset($con_beau_info)) {
					echo "理疗师未选择！请选择一名理疗师:";
				}
				echo $form->dropDownList($contact_info,'con_beau_id',$beau_options);
				?>
			</td>
		</tr>
		<tr bgcolor="#add8e6">
			<td>
				<?php echo $form->label($contact_info, 'con_name'); ?>
			</td>
			<td>
				<?php echo $form->textField($contact_info, 'con_name'); ?>
			</td>
		</tr>
		<tr bgcolor="#ffffff">
			<td>
				<?php echo $form->label($contact_info, 'con_mobile'); ?>
			</td>
			<td>
				<?php echo $form->textField($contact_info, 'con_mobile'); ?>
			</td>
		</tr>
		<tr bgcolor="#add8e6">
			<td>
				<?php echo $form->label($contact_info, 'con_prefer'); ?>
			</td>
			<td>
				<?php
				echo $form->dropDownList($contact_info, 'con_prefer', $prefer_options);
				?>
			</td>
		</tr>
		<tr bgcolor="#ffffff">
			<td>
				<?php echo $form->label($contact_info, 'con_time'); ?>
			</td>
			<td>
				<?php
				echo $form->textField($contact_info, 'con_time');
//				echo date("Y-m-d H:i",strtotime($contact_info->con_time));
				?>
			</td>
		</tr>
		<tr bgcolor="#add8e6">
			<td>
				<?php echo $form->label($contact_info, 'con_address'); ?>
			</td>
			<td>
				<?php echo $form->textArea($contact_info, 'con_address'); ?>
			</td>
		</tr>
		<tr bgcolor="#ffffff">
			<td>
				<?php echo $form->label($contact_info, 'con_district'); ?>
			</td>
			<td>
				<?php echo $form->dropDownList($contact_info, 'con_district', $district_options); ?>
			</td>
		</tr>
		<tr bgcolor="#add8e6">
			<td>
				<?php echo $form->label($contact_info, 'con_flag'); ?>
			</td>
			<td>
				<?php echo $form->dropDownList($contact_info,'con_flag',array('未付款', '已付款')); ?>
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