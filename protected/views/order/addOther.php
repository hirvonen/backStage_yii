<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title>订单(特殊活动)添加</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8">
	<link href="<?php echo BACK_CSS_URL; ?>mine.css" type="text/css" rel="stylesheet">
</head>

<body>

<div class="div_head">
            <span>
                <?php
                switch($kind) {
                    case OTHER_KIND_1YUAN:
                        echo '<span style="float:left">当前位置是：订单管理-》添加订单（1元订单）</span>';
                        break;
                    case OTHER_KIND_88YUAN:
                        echo '<span style="float:left">当前位置是：订单管理-》添加订单（88元订单）</span>';
                        break;
                    case OTHER_KIND_SGB:
                        echo '<span style="float:left">当前位置是：订单管理-》添加订单（圣戈班）</span>';
                        break;
                    case OTHER_KIND_168YUAN:
                        echo '<span style="float:left">当前位置是：订单管理-》添加订单（168元订单）</span>';
                        break;
                    case OTHER_KIND_1111:
                        echo '<span style="float:left">当前位置是：订单管理-》添加订单（双11订单）</span>';
                        break;
                    case OTHER_KIND_HAOKANG:
                        echo '<span style="float:left">当前位置是：订单管理-》添加订单（好慷订单）</span>';
                        break;
                    default:
                        break;
                }
                ?>
	            <span style="float:right;margin-right: 8px;font-weight: bold">
                    <a style="text-decoration: none" href="./index.php?r=order/showOtherOrder&kind=<?php echo $kind ?>">【返回】</a>
                </span>
            </span>
</div>
<div></div>

<div style="font-size: 13px;margin: 10px 5px">
	<?php $form = $this->beginWidget('CActiveForm'); ?>
    <table border="1" width="100%" class="table_a">
        <tr bgcolor="#ffffff">
            <td>
                <?php echo $form->labelEx($contact_info, 'con_open_id'); ?>
            </td>
            <td>
                <?php echo $form->textField($contact_info, 'con_open_id'); ?>
            </td>
        </tr>
        <tr bgcolor="#add8e6">
            <td>
                <?php echo $form->labelEx($contact_info, 'con_name'); ?>
            </td>
            <td>
                <?php echo $form->textField($contact_info, 'con_name'); ?>
            </td>
        </tr>
        <tr bgcolor="#ffffff">
            <td>
                <?php echo $form->labelEx($contact_info, 'con_mobile'); ?>
            </td>
            <td>
                <?php echo $form->textField($contact_info, 'con_mobile'); ?>
            </td>
        </tr>
        <tr bgcolor="#add8e6">
            <td>
                <?php echo $form->labelEx($contact_info, 'con_prefer'); ?>
            </td>
            <td>
                <?php
                switch($kind) {
                    case OTHER_KIND_1YUAN:
                        $options = array ('1'=>'透润美肤', '2'=>'经络养生', '3'=>'经络纤体/淋巴排毒');
                        break;
                    case OTHER_KIND_88YUAN:
                    case OTHER_KIND_SGB:
                    case OTHER_KIND_LY168YUAN:
                        $options = array ('4'=>'经络养生', '5'=>'透润美肤');
                        break;
                    case OTHER_KIND_168YUAN:
                        $options = array ('6'=>'深层淋巴净排','7'=>'经络纤体','8'=>'轻盈塑体（局部）','9'=>'经络养生调理','10'=>'肩颈调理',
                            '11'=>'温肾固本','12'=>'肝胆养护','13'=>'补气养血','14'=>'关节理疗（膝盖）','15'=>'透润美肤',
                            '16'=>'白皙美肤','17'=>'3D紧致美肤','18'=>'乳腺疏通散结/开奶','19'=>'骨盆调整','20'=>'胸部紧致提升');
                        break;
                    default:
                        $options = array ('0'=>'出错啦！');
                        break;
                }
                echo $form->dropDownList($contact_info,'con_prefer',$options);
                ?>
            </td>
        </tr>
        <tr bgcolor="#ffffff">
            <td>
                <?php echo $form->labelEx($contact_info, 'con_time'); ?>
            </td>
            <td>
                <?php echo $form->textField($contact_info, 'con_time'); ?>
            </td>
        </tr>
        <tr bgcolor="#add8e6">
            <td>
                <?php echo $form->labelEx($contact_info, 'con_address'); ?>
            </td>
            <td>
                <?php echo $form->textArea($contact_info, 'con_address'); ?>
            </td>
        </tr>
        <tr bgcolor="#ffffff">
            <td>
                <?php echo $form->labelEx($contact_info, 'con_flag'); ?>
            </td>
            <td>
                <?php
                $options = array('0'=>'未付款','1'=>'已付款');
                echo $form->dropDownList($contact_info,'con_flag',$options);
                ?>
            </td>
        </tr>
        <tr bgcolor="#add8e6">
            <td>
                <?php echo $form->labelEx($contact_info, 'con_district'); ?>
            </td>
            <td>
<!--                --><?php //echo $form->textField($contact_info, 'con_district'); ?>
                <?php
                $options = array ('黄浦区'=>'黄埔区',
                    '静安区'=>'静安区',
                    '徐汇区'=>'徐汇区',
                    '卢湾区'=>'卢湾区',
                    '长宁区'=>'长宁区',
                    '闸北区'=>'闸北区',
                    '虹口区'=>'虹口区',
                    '杨浦区'=>'杨浦区',
                    '浦东新区'=>'浦东新区',
                    '普陀区'=>'普陀区',
                    '闵行区'=>'闵行区',
                    '宝山区'=>'宝山区',
                    '嘉定区'=>'嘉定区',
                    '松江区'=>'松江区',
                    '青浦区'=>'青浦区',
                    '奉贤区'=>'奉贤区',
                    '金山区'=>'金山区',
                    '崇明区'=>'崇明区');
                echo $form->dropDownList($contact_info,'con_district',$options);
                ?>
            </td>
        </tr>
        <tr bgcolor="#ffffff">
            <td>
                <?php echo $form->labelEx($contact_info, 'con_referee'); ?>
            </td>
            <td>
                <?php echo $form->textField($contact_info, 'con_referee'); ?>
            </td>
        </tr>
        <tr bgcolor="#add8e6">
            <td>
                <?php echo $form->labelEx($contact_info, 'con_status'); ?>
            </td>
            <td>
                <?php
                $options = array ('0'=>'未完成', '1'=>'已完成');
                echo $form->dropDownList($contact_info,'con_status',$options);
                ?>
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