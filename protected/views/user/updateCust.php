<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title>顾客详细信息修改</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8">
	<link href="<?php echo BACK_CSS_URL; ?>mine.css" type="text/css" rel="stylesheet">
</head>

<body>
<div class="div_head">
            <span>
                <span style="float:left">当前位置是：用户管理-》修改顾客详细信息</span>
	            <span style="float:right;margin-right: 8px;font-weight: bold">
                    <a style="text-decoration: none" href="./index.php?r=user/showCust">【返回】</a>
                </span>
            </span>
</div>
<div></div>

<div style="font-size: 13px;margin: 10px 5px">
	<?php $form = $this->beginWidget('CActiveForm'); ?>
	<table border="1" width="100%" class="table_show_color">
		<tr>
			<th class="alt">顾客基本信息</th>
		</tr>
		<tr>
			<td>
				<?php echo $form->label($user_info, 'pk_usr_id'); ?>
			</td>
			<td>
				<?php echo $form->label($user_info,$user_info->pk_usr_id); ?>
			</td>
		</tr>
		<tr class="alt">
			<td>
				<?php echo $form->label($cust_info, '姓名'); ?>
			</td>
			<td>
				<?php echo $form->textField($cust_info,'cust_realname'); ?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $form->label($user_info, '手机号码'); ?>
			</td>
			<td>
				<?php echo $form->textField($user_info,'usr_username'); ?>
				<?php echo $form->error($user_info,'usr_username'); ?>
			</td>
		</tr>
		<tr class="alt">
			<td>
				<?php echo $form->label($addr_info, 'addr_addr'); ?>
			</td>
			<td>
				<?php
				if($addr_info) {
					echo $form->textArea($addr_info, 'addr_addr', array('rows'=>3, 'cols'=>70));
				} else {
					echo $form->textField('地址未知');
				}
				?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $form->label($cust_info, 'cust_source'); ?>
			</td>
			<td>
				<?php
				$code_model = Code::model();
				$query = 'select * from tbl_code where code_tbl_name = "tbl_customer" and code_name = "cust_source"';
				$code_info = $code_model->findAllBySql($query);
				$cust_source_options = array();
				foreach($code_info as $_code_info_v){
					$cust_source_options[$_code_info_v->code_value] = $_code_info_v->code_meaning;
				}
				echo $form->dropDownList($cust_info,'cust_source',$cust_source_options);
				?>
			</td>
		</tr>
		<tr class="alt">
			<td>
				<?php echo $form->label($cust_info, 'cust_in_time'); ?>
			</td>
			<td>
				<?php echo $form->label($cust_info, $cust_info->cust_in_time);?>
<!--				--><?php //echo $form->label($cust_info, 'cust_in_time');?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $form->label($cust_info, 'cust_level'); ?>
			</td>
			<td>
				<?php echo $form->textField($cust_info, 'cust_level');?>
			</td>
		</tr>
		<tr class="alt">
			<td>
				<?php echo $form->label($cust_info, 'cust_point'); ?>
			</td>
			<td>
				<?php echo $form->textField($cust_info, 'cust_point');?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $form->label($cust_info, 'cust_birthday'); ?>
			</td>
			<td>
				<?php echo $form->textField($cust_info, 'cust_birthday');?>
			</td>
		</tr>
		<tr class="alt">
			<td>
				<?php echo $form->label($cust_info, 'cust_baby1_birthday'); ?>
			</td>
			<td>
				<?php echo $form->textField($cust_info, 'cust_baby1_birthday');?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $form->label($cust_info, 'cust_baby1_sex'); ?>
			</td>
			<td>
				<?php echo $form->radioButtonList($cust_info,'cust_baby1_sex',array('男'=>'男','女'=>'女'),array("separator"=>"&nbsp"));?>

			</td>
		</tr>
		<?php
		if($cust_info->cust_baby2_birthday != null) {
			echo '<tr class="alt"><td>'.
				$form->label($cust_info, 'cust_baby2_birthday').
				'</td><td>'.$form->textField($cust_info, 'cust_baby2_birthday').
				'</td></tr>';
			echo '<tr><td>'.
				$form->label($cust_info, 'cust_baby2_sex').
				'</td><td>'.$form->radioButtonList($cust_info,'cust_baby2_sex',array('男'=>'男','女'=>'女'),array("separator"=>"&nbsp")).
				'</td></tr>';
		}
		if($cust_info->cust_baby3_birthday != null) {
			echo '<tr class="alt"><td>'.
				$form->label($cust_info, 'cust_baby3_birthday').
				'</td><td>'.$form->textField($cust_info, 'cust_baby3_birthday').
				'</td></tr>';
			echo '<tr><td>'.
				$form->label($cust_info, 'cust_baby3_sex').
				'</td><td>'.$form->radioButtonList($cust_info,'cust_baby3_sex',array('男'=>'男','女'=>'女'),array("separator"=>"&nbsp")).
				'</td></tr>';
		}
		?>
		<tr class="alt">
			<td>
				<?php echo $form->label($cust_info, 'cust_profession'); ?>
			</td>
			<td>
				<?php echo $form->textField($cust_info, 'cust_profession');?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $form->label($cust_info, 'cust_prefer'); ?>
			</td>
			<td>
				<?php
				$flag = 1;
				$selected_comm = array();
				$selected_num = 0;
				for($i=0;$i<19;$i++) {
					if($i!=0) {
						$flag = $flag<<1;
					}
					if($cust_info->cust_prefer & $flag) {
						$selected_comm[$selected_num] = $flag;
						$selected_num++;
					}
				}
				$cust_info->cust_prefer = $selected_comm;
				echo $form->checkBoxList($cust_info, 'cust_prefer',
					array('1'=>'深层淋巴净排','2'=>'经络纤体','4'=>'轻盈塑体（局部）','8'=>'轻盈塑体（全身）',
						'16'=>'完美体雕（局部）','32'=>'经络养生调理','64'=>'肩颈调理','128'=>'温肾固本',
						'256'=>'肝胆养护','512'=>'补气养血','1024'=>'关节理疗（膝盖）','2048'=>'透润美肤',
						'4096'=>'白皙美肤','8192'=>'3D紧致美肤','16384'=>'乳腺疏通散结/开奶','32768'=>'骨盆调整',
						'65536'=>'胸部紧致提升','131072'=>'妊娠纹修复','262144'=>'卵巢养护'));
				?>
			</td>
		</tr>
		<tr class="alt">
			<td>
				<?php echo $form->label($cust_info, 'cust_beautician'); ?>
			</td>
			<td>
				<?php
				$beau_model = Beautician::model();
				$beau_info = $beau_model->findAll();
				$flag = 1;
				$selected_beau = array();
				$selected_num = 0;
				for($i=0;$i<count($beau_info);$i++) {
					if($i!=0) {
						$flag = $flag<<1;
					}
					if($cust_info->cust_beautician & $flag) {
						$selected_beau[$selected_num] = $flag;
						$selected_num++;
					}
				}
				$cust_info->cust_beautician = $selected_beau;
				echo $form->checkBoxList($cust_info, 'cust_beautician',
					array('1'=>'李启芹','2'=>'范小荣','16'=>'张小倩','32'=>'魏雪娇'),
					array("separator"=>"&nbsp"));
				?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $form->label($cust_info, 'cust_else'); ?>
			</td>
			<td>
				<?php echo $form->textArea($cust_info, 'cust_else', array('rows'=>3, 'cols'=>70));?>
			</td>
		</tr>

		<tr>
			<th class="alt">顾客健康信息</th>
		</tr>
		<tr>
			<td>
				<?php echo $form->label($custhi_info, 'custhi_height'); ?>
			</td>
			<td>
				<?php echo $form->textField($custhi_info, 'custhi_height');?>cm
				<?php echo $form->error($custhi_info, 'custhi_height');?>

			</td>
		</tr>
		<tr class="alt">
			<td>
				<?php echo $form->label($custhi_info, 'custhi_weight'); ?>
			</td>
			<td>
				<?php echo $form->textField($custhi_info, 'custhi_weight');?>kg
				<?php echo $form->error($custhi_info, 'custhi_weight');?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $form->label($custhi_info, 'custhi_exam_desp'); ?>
			</td>
			<td>
				<?php echo $form->textArea($custhi_info, 'custhi_exam_desp', array('rows'=>3, 'cols'=>70));?>
			</td>
		</tr>
		<tr class="alt">
			<td>
				<?php echo $form->label($custhi_info, 'custhi_bear_info'); ?>
			</td>
			<td>
				<?php echo $form->textArea($custhi_info, 'custhi_bear_info', array('rows'=>3, 'cols'=>70));?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $form->label($custhi_info, 'custhi_lactation_info'); ?>
			</td>
			<td>
				<?php echo $form->textArea($custhi_info, 'custhi_lactation_info', array('rows'=>3, 'cols'=>70));?>
			</td>
		</tr>
		<tr class="alt">
			<td>
				<?php echo $form->label($custhi_info, 'custhi_allergy_info'); ?>
			</td>
			<td>
				<?php echo $form->textArea($custhi_info, 'custhi_allergy_info', array('rows'=>3, 'cols'=>70));?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $form->label($custhi_info, 'custhi_medical_info'); ?>
			</td>
			<td>
				<?php echo $form->textArea($custhi_info, 'custhi_medical_info', array('rows'=>3, 'cols'=>70));?>
			</td>
		</tr>
		<tr class="alt">
			<td>
				<?php echo $form->label($custhi_info, 'custhi_period_info'); ?>
			</td>
			<td>
				<?php echo $form->textArea($custhi_info, 'custhi_period_info', array('rows'=>3, 'cols'=>70));?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $form->label($custhi_info, 'custhi_sleeping_info'); ?>
			</td>
			<td>
				<?php echo $form->textArea($custhi_info, 'custhi_sleeping_info', array('rows'=>3, 'cols'=>70));?>
			</td>
		</tr>
		<tr class="alt">
			<td>
				<?php echo $form->label($custhi_info, 'custhi_sports_info'); ?>
			</td>
			<td>
				<?php echo $form->textArea($custhi_info, 'custhi_sports_info', array('rows'=>3, 'cols'=>70));?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $form->label($custhi_info, 'custhi_other_health_info'); ?>
			</td>
			<td>
				<?php echo $form->textArea($custhi_info, 'custhi_other_health_info', array('rows'=>3, 'cols'=>70));?>
			</td>
		</tr>
		<?php
		if($custhr_info) {
			echo '<tr><th class="alt">健康信息反馈<a href="./index.php?r=user/addCustHealthReply&id='.
				$user_info->pk_usr_id.
				'">(添加)</a></th></tr>';
			for($i=(count($custhr_info)-1);$i>=0;$i--) {
				if($i%2!=0) {
					echo '<tr>';
				} else {
					echo '<tr class="alt">';
				}
				echo '<td>'.$form->label($custhr_info[$i], 'custhr_reply').'</td>';
				echo '<td>'.$form->textArea($custhr_info[$i], 'custhr_reply', array('rows'=>3, 'cols'=>70)).'</td>';
				echo '</tr>';

				if($i%2!=0) {
					echo '<tr>';
				} else {
					echo '<tr class="alt">';
				}
				echo '<td>'.$form->label($custhr_info[$i], 'custhr_reply_beau_name').'</td>';
				echo '<td>'.$form->textField($custhr_info[$i], 'custhr_reply_beau_name').'</td>';
				echo '</tr>';

				if($i%2!=0) {
					echo '<tr>';
				} else {
					echo '<tr class="alt">';
				}
				echo '<td>'.$form->label($custhr_info[$i], 'custhr_reply_date').'</td>';
				echo '<td>'.$form->textField($custhr_info[$i], 'custhr_reply_date').'</td>';
				echo '</tr>';
			}
		} else {
			echo '<tr><th class="alt"><a href="./index.php?r=user/addCustHealthReply&id='.
				$user_info->pk_usr_id.
				'">添加健康信息反馈</a></th></tr>';
		}
		?>




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