<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta content="MSHTML 6.00.6000.16674" name="GENERATOR" />

	<title>用户登录</title>

	<link href="<?php echo BACK_CSS_URL; ?>User_Login.css" type="text/css" rel="stylesheet" />
</head><body id="userlogin_body">
<div></div>
<div id="user_login">
	<dl>
		<dd id="user_top">
			<ul>
				<li class="user_top_l"></li>
				<li class="user_top_c"></li>
				<li class="user_top_r"></li></ul>
		</dd><dd id="user_main">
			<?php $form = $this->beginWidget('CActiveForm',array(
				'enableClientValidation'=>true,
				'clientOptions'=>array(
					'validateOnSubmit'=>true,
				)));?>
			<ul>
					<li class="user_main_l"></li>
					<li class="user_main_c">
						<div class="user_main_box">
							<ul>
								<li class="user_main_text">用户名： </li>
								<li class="user_main_input">
									<!--<input class="TxtUserNameCssClass" id="admin_user" maxlength="20" name="admin_user">-->
									<?php echo $form->textField($user_login,'username'); ?>
									<?php echo $form->error($user_login,'username'); ?>
								</li></ul>
							<ul>
								<li class="user_main_text">密&nbsp;&nbsp;&nbsp;&nbsp;码： </li>
								<li class="user_main_input">
									<!--<input class="TxtPasswordCssClass" id="admin_psd" name="admin_psd" type="password">-->
									<?php echo $form->passwordField($user_login,'password'); ?>
									<?php echo $form->error($user_login,'password'); ?>
								</li>
							</ul>
<!--							<ul>-->
<!--								<li class="user_main_text">-->
<!--									--><?php //echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$form->checkBox($user_login,'rememberMe'); ?>
<!--								</li>-->
<!--								<li class="user_main_input">-->
<!--									--><?php //echo $form->labelEx($user_login,'rememberMe'); ?>
<!--								</li>-->
<!--							</ul>-->
							<!--<ul>
								<li class="user_main_text">验证码： </li>
								<li class="user_main_input">
									<input class="TxtValidateCodeCssClass" id="captcha" name="captcha" type="text">
									<img src="<?php echo BACK_IMG_URL; ?>admin.png"  alt="" />
								</li>
							</ul>-->
						</div>
					</li>
					<li class="user_main_r">

						<input style="border: medium none; background: url('<?php echo BACK_IMG_URL; ?>user_botton.gif') repeat-x scroll left top transparent; height: 122px; width: 111px; display: block; cursor: pointer;"
						       value="登陆"
						       type="submit">
					</li>
				</ul>
			<!--<table align="left" border="0" cellpadding="3" cellspacing="5" width="100%">
				<tbody>
					<tr>
						<td align="right" width="20%"><?php //echo $form->labelEx($user_login,'username'); ?></td>
						<td width="80%">
							<?php //echo $form->textField($user_login,'username',array('size'=>25,'class'=>'inputBg')); ?>
						</td>
					</tr>
					<tr>
						<td align="right"><?php //echo $form->labelEx($user_login,'password'); ?></td>
						<td width="85%">
							<?php //echo $form->textField($user_login,'password',array('size'=>15,'class'=>'inputBg')); ?>
						</td>
					</tr>
				</tbody>
			</table>-->
			<?php $this->endWidget(); ?>
		</dd><dd id="user_bottom">
			<ul>
				<li class="user_bottom_l"></li>
				<li class="user_bottom_c"><span style="margin-top: 40px;"></span> </li>
				<li class="user_bottom_r"></li></ul></dd></dl></div><span id="ValrUserName" style="display: none; color: red;"></span><span id="ValrPassword" style="display: none; color: red;"></span><span id="ValrValidateCode" style="display: none; color: red;"></span>
<div id="ValidationSummary1" style="display: none; color: red;"></div>
</body>
</html>