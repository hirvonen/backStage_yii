<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title>顾客疗程中健康信息反馈</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8">
	<link href="<?php echo BACK_CSS_URL; ?>mine.css" type="text/css" rel="stylesheet">
</head>

<body>
<div class="div_head">
            <span>
                <span style="float:left">当前位置是：用户管理-》添加顾客疗程中健康信息反馈</span>
	            <span style="float:right;margin-right: 8px;font-weight: bold">
                    <a style="text-decoration: none" href="./index.php?r=user/updateCust&id=<?php echo $cust_info->pk_cust_id ?>">【返回】</a>
                </span>
            </span>
</div>
<div></div>

<div style="font-size: 13px;margin: 10px 5px">
	<?php $form = $this->beginWidget('CActiveForm'); ?>
	<table border="1" width="100%" class="table_show_color">
		<tr>
			<th class="alt">添加健康信息反馈</th>
		</tr>
		<tr>
			<td>
				<?php echo $form->label($cust_info, 'cust_realname'); ?>
			</td>
			<td>
				<?php echo $form->label($cust_info,$cust_info->cust_realname); ?>
			</td>
		</tr>
		<tr class="alt">
			<td>
				<?php echo $form->label($custhr_info, 'custhr_reply_beau_name'); ?>
			</td>
			<td>
				<?php echo $form->textField($custhr_info,'custhr_reply_beau_name'); ?>
				<?php echo $form->error($custhr_info,'custhr_reply_beau_name'); ?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $form->label($custhr_info, 'custhr_reply_date'); ?>
			</td>
			<td>
				<?php echo $form->textField($custhr_info,'custhr_reply_date'); ?>
			</td>
		</tr>
		<tr class="alt">
			<td>
				<?php echo $form->label($custhr_info, 'custhr_reply'); ?>
			</td>
			<td>
				<?php echo $form->textArea($custhr_info, 'custhr_reply', array('rows'=>3, 'cols'=>70));?>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<input type="submit" value="添加">
			</td>
		</tr>
	</table>
	<?php $this->endWidget(); ?>
</div>

</body>
</html>