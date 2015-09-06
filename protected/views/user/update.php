<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title>用户详细信息修改</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8">
	<link href="<?php echo BACK_CSS_URL; ?>mine.css" type="text/css" rel="stylesheet">
</head>

<body>

<div class="div_head">
            <span>
                <span style="float:left">当前位置是：用户管理-》
	                <?php
	                    switch( $user_info->usr_kind ){
		                    case 0:
								//管理员
								echo "修改管理员详细信息";
			                    break;
		                    case 1:
								//理疗师
								echo "修改理疗师详细信息";
			                    break;
		                    case 2:
								//顾客
								echo "修改顾客详细信息";
			                    break;
		                    default:
								echo "修改未知详细信息";
			                    break;
	                    }
	                ?></span>
	            <span style="float:right;margin-right: 8px;font-weight: bold">
                    <a style="text-decoration: none" href="./index.php?r=user/detail&id=<?php echo $user_info->pk_usr_id; ?>">【返回】</a>
                </span>
            </span>
</div>
<div></div>

<div style="font-size: 13px;margin: 10px 5px">
	<?php $form = $this->beginWidget('CActiveForm'); ?>
	<table border="1" width="100%" class="table_a">
		<tr>
			<td>
				<?php echo $form->label($user_info, 'pk_usr_id'); ?>
			</td>
			<td>
				<?php echo $form->label($user_info,$user_info->pk_usr_id); ?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $form->label($user_info, 'usr_kind'); ?>
			</td>
			<td>
				<?php
					if($user_info->usr_kind == 0) {
						echo $form->label($user_info,"管理员");
					}
					elseif($user_info->usr_kind == 1){
						echo $form->label($user_info,"理疗师");
					}
					elseif($user_info->usr_kind == 2){
						echo $form->label($user_info,"顾客");
					}
					else{
						echo $form->label($user_info,"未知");
					}
				?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $form->label($user_info, 'usr_reg_kind'); ?>
			</td>
			<td>
				<?php echo $form->dropDownList($user_info,'usr_reg_kind',array('微信用户','新浪微博用户','QQ用户','腾讯微博用户','网站注册用户','未知')); ?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $form->label($user_info, 'usr_open_id'); ?>
			</td>
			<td>
				<?php echo $form->textField($user_info,'usr_open_id'); ?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $form->label($user_info, 'usr_username'); ?>
			</td>
			<td>
				<?php echo $form->textField($user_info,'usr_username'); ?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $form->label($user_info, 'usr_password'); ?>
			</td>
			<td>
				<span style="float:left;margin-left: 8px;font-weight: bold">
                    <a style="text-decoration: none" href="./index.php?r=user/initPassword&id=<?php echo $user_info->pk_usr_id ?>&page=2">初始化用户密码</a>
                </span>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $form->label($user_info, 'usr_create_time'); ?>
			</td>
			<td>
				<?php echo $form->label($user_info,$user_info->usr_create_time); ?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $form->label($user_info, 'usr_last_login'); ?>
			</td>
			<td>
				<?php echo $form->label($user_info,$user_info->usr_last_login); ?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $form->label($user_info, 'usr_status'); ?>
			</td>
			<td>
				<?php echo $form->label($user_info,$user_info->usr_status); ?>
			</td>
		</tr>
		<tr>
			<td>
				<?php echo $form->label($user_info, 'usr_pic_id'); ?>
			</td>
			<td>
				<?php echo $form->textField($user_info, 'usr_pic_id'); ?>
			</td>
		</tr>
		<tr>
			<td bgcolor="#6495ed">
			</td>
			<td bgcolor="#6495ed">
			</td>
		</tr>
		<?php if($user_info->usr_kind === "0") { ?>
			<!--显示管理员信息-->
			<tr>
				<td>
					<?php echo $form->label($admin_info, 'adm_level'); ?>
				</td>
				<td>
					<?php echo $form->dropDownList($admin_info,'adm_level',array('普通管理员','超级管理员')); ?>
				</td>
			</tr>
		<?php
		}
		elseif($user_info->usr_kind === "1") {?>
			<!--显示理疗师信息-->
			<tr>
				<td>
					<?php echo $form->labelEx($beautician_info, 'beau_realname'); ?>
				</td>
				<td>
					<?php echo $form->textField($beautician_info, 'beau_realname'); ?>
					<?php echo $form->error($beautician_info,'beau_realname'); ?>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo $form->label($beautician_info, 'beau_nickname'); ?>
				</td>
				<td>
					<?php echo $form->textField($beautician_info, 'beau_nickname'); ?>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo $form->labelEx($beautician_info, 'beau_idcard_id'); ?>
				</td>
				<td>
					<?php echo $form->textField($beautician_info, 'beau_idcard_id'); ?>
					<?php echo $form->error($beautician_info, 'beau_idcard_id'); ?>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo $form->labelEx($beautician_info, 'beau_level'); ?>
				</td>
				<td>
					<?php echo $form->textField($beautician_info, 'beau_level'); ?>
					<?php echo $form->error($beautician_info, 'beau_level'); ?>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo $form->labelEx($beautician_info, 'beau_tel1'); ?>
				</td>
				<td>
					<?php echo $form->textField($beautician_info, 'beau_tel1'); ?>
					<?php echo $form->error($beautician_info, 'beau_tel1'); ?>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo $form->label($beautician_info, 'beau_tel2'); ?>
				</td>
				<td>
					<?php echo $form->textField($beautician_info, 'beau_tel2'); ?>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo $form->label($beautician_info, 'beau_valid'); ?>
				</td>
				<td>
					<?php echo $form->textField($beautician_info, 'beau_valid'); ?>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo $form->labelEx($beautician_info, 'beau_sex'); ?>
				</td>
				<td>
					<?php echo $form->radioButtonList($beautician_info,'beau_sex',array('女'=>'女','男'=>'男'),array("separator"=>"&nbsp"));?>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo $form->labelEx($beautician_info, 'beau_birthday'); ?>
				</td>
				<td>
					<?php echo $form->textField($beautician_info, 'beau_birthday'); ?>
					<span>请以“1990-02-03”的格式输入</span>
					<?php echo $form->error($beautician_info, 'beau_birthday'); ?>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo $form->label($beautician_info, 'beau_email'); ?>
				</td>
				<td>
					<?php echo $form->textField($beautician_info, 'beau_email'); ?>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo $form->labelEx($beautician_info, 'beau_intro'); ?>
				</td>
				<td>
					<?php echo $form->textArea($beautician_info, 'beau_intro'); ?>
					<?php echo $form->error($beautician_info, 'beau_intro'); ?>
				</td>
			</tr>
		<?php
		}
		elseif($user_info->usr_kind === "2") { ?>
			<!--显示顾客信息-->
			<tr>
				<td>
					<?php echo $form->labelEx($customer_info, 'cust_level'); ?>
				</td>
				<td>
					<?php echo $form->textField($customer_info, 'cust_level'); ?>
					<?php echo $form->error($customer_info,'cust_level'); ?>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo $form->labelEx($customer_info, 'cust_balance'); ?>
				</td>
				<td>
					<?php echo $form->textField($customer_info, 'cust_balance'); ?>
					<?php echo $form->error($customer_info, 'cust_balance'); ?>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo $form->labelEx($customer_info, 'cust_point'); ?>
				</td>
				<td>
					<?php echo $form->textField($customer_info, 'cust_point'); ?>
					<?php echo $form->error($customer_info, 'cust_point'); ?>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo $form->label($customer_info, 'cust_realname'); ?>
				</td>
				<td>
					<?php echo $form->textField($customer_info, 'cust_realname'); ?>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo $form->label($customer_info, 'cust_mobile1'); ?>
				</td>
				<td>
					<?php echo $form->textField($customer_info, 'cust_mobile1'); ?>
					<?php echo $form->error($customer_info, 'cust_mobile1'); ?>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo $form->label($customer_info, 'cust_mobile2'); ?>
				</td>
				<td>
					<?php echo $form->textField($customer_info, 'cust_mobile2'); ?>
					<?php echo $form->error($customer_info, 'cust_mobile2'); ?>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo $form->label($customer_info, 'cust_phone'); ?>
				</td>
				<td>
					<?php echo $form->textField($customer_info, 'cust_phone'); ?>
					<?php echo $form->error($customer_info, 'cust_phone'); ?>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo $form->label($customer_info, 'cust_sex'); ?>
				</td>
				<td>
					<?php echo $form->radioButtonList($customer_info,'cust_sex',array('女'=>'女','男'=>'男'),array("separator"=>"&nbsp"));?>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo $form->label($customer_info, 'cust_birthday'); ?>
				</td>
				<td>
					<?php echo $form->textField($customer_info, 'cust_birthday'); ?>
					<span>请以“1990-02-03”的格式输入</span>
					<?php echo $form->error($customer_info, 'cust_birthday'); ?>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo $form->label($customer_info, 'cust_email1'); ?>
				</td>
				<td>
					<?php echo $form->textField($customer_info, 'cust_email1'); ?>
					<?php echo $form->error($customer_info, 'cust_email1'); ?>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo $form->label($customer_info, 'cust_email2'); ?>
				</td>
				<td>
					<?php echo $form->textField($customer_info, 'cust_email2'); ?>
					<?php echo $form->error($customer_info, 'cust_email2'); ?>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo $form->label($customer_info, 'cust_child_no'); ?>
				</td>
				<td>
					<?php echo $form->textField($customer_info, 'cust_child_no'); ?>
					<?php echo $form->error($customer_info, 'cust_child_no'); ?>
				</td>
			</tr>
			<tr>
				<td>
					<?php echo $form->label($customer_info, 'cust_childbearing_age'); ?>
				</td>
				<td>
					<?php echo $form->textField($customer_info, 'cust_childbearing_age'); ?>
					<?php echo $form->error($customer_info, 'cust_childbearing_age'); ?>
				</td>
			</tr>
		<?php
		}
		else{ echo "something wrong!"; } ?>
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