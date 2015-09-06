<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title>预约添加</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8">
	<link href="<?php echo BACK_CSS_URL; ?>mine.css" type="text/css" rel="stylesheet">
</head>

<body>

<div class="div_head">
            <span>
                <span style="float:left">当前位置是：预约管理-》添加预约</span>
	            <span style="float:right;margin-right: 8px;font-weight: bold">
                    <a style="text-decoration: none" href="./index.php?r=aptm/show">【返回】</a>
                </span>
            </span>
</div>
<div></div>

<div style="font-size: 13px;margin: 10px 5px">
	<?php $form = $this->beginWidget('CActiveForm'); ?>
    <table border="1" width="100%" class="table_a">
        <tr bgcolor="#ffffff">
            <td>
                <?php echo $form->labelEx($aptm_info, 'aptm_cust_name'); ?>
            </td>
            <td>
                <?php echo $form->textField($aptm_info, 'aptm_cust_name'); ?>
                <a href="./index.php?r=aptm/selectCust">选择用户</a>
            </td>
        </tr>
        <tr bgcolor="#add8e6">
            <td>
                <?php echo '预约项目'; ?>
            </td>
            <td>
                <?php
                if($comm_info) {
                    echo $comm_info->comm_name;
                } else {
                    echo '预约项目未选择！';
                }
                ?>
            </td>
        </tr>
        <tr bgcolor="#ffffff">
            <td>
                <?php echo $form->label($aptm_info, 'aptm_time'); ?>
            </td>
            <td>
                <?php echo $form->textField($aptm_info, 'aptm_time'); ?>
            </td>
        </tr>
        <tr bgcolor="#add8e6">
            <td>
                <?php echo $form->label($aptm_info, 'aptm_cust_tel'); ?>
            </td>
            <td>
                <?php echo $form->textField($aptm_info, 'aptm_cust_tel'); ?>
            </td>
        </tr>
        <tr bgcolor="#ffffff">
            <td>
                <?php echo $form->label($aptm_info, 'aptm_cust_addr'); ?>
            </td>
            <td>
                <?php echo $form->textArea($aptm_info, 'aptm_cust_addr'); ?>
            </td>
        </tr>
        <tr bgcolor="#add8e6">
            <td>
                <?php echo $form->label($aptm_info, 'aptm_course_no'); ?>
            </td>
            <td>
                <?php echo $form->textField($aptm_info, 'aptm_course_no'); ?>
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