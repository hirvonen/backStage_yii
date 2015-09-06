<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title>添加用户</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8">
	<link href="<?php echo BACK_CSS_URL; ?>mine.css" type="text/css" rel="stylesheet">
</head>

<body>

<div class="div_head">
            <span>
                <span style="float:left">当前位置是：用户管理-》添加用户</span>
                <span style="float:right;margin-right: 8px;font-weight: bold">
                    <a style="text-decoration: none" href="./index.php?r=user/show">【返回】</a>
                </span>
            </span>
</div>
<div></div>

<div style="font-size: 13px;margin: 10px 5px">
	<?php $form = $this->beginWidget('CActiveForm', array(
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
	)); ?>
	<table border="1" width="100%" class="table_a">
		<tr>
			<td>
				<?php echo "请选择用户种类：（注意：用户种类选择之后不可更改！）"; ?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $form->dropDownList($user_model,'usr_kind',array('管理员','理疗师','顾客')); ?>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="right">
				<input type="submit" value="下一步">
			</td>
		</tr>
	</table>
	<?php $this->endWidget(); ?>
</div>
</body>
</html>