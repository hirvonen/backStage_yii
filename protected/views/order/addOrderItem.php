<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<title>订单添加</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8">
	<link href="<?php echo BACK_CSS_URL; ?>mine.css" type="text/css" rel="stylesheet">
</head>

<body>

<div class="div_head">
            <span>
                <span style="float:left">当前位置是：订单管理-》订单详细-》添加订单项目</span>
	            <span style="float:right;margin-right: 8px;font-weight: bold">
                    <a style="text-decoration: none" href="./index.php?r=order/detail&id=<?php echo $ord_id ?>">【返回】</a>
                </span>
            </span>
</div>
<div></div>

<div style="font-size: 13px;margin: 10px 5px">
	<?php $form = $this->beginWidget('CActiveForm'); ?>
    <table class="table_a" border="1" width="100%">
        <tbody><tr bgcolor="#4169e1" style="font-weight: bold;">
            <td></td>
            <td>商品编号</td>
            <td>商品名</td>
            <td>商品价格</td>
        </tr>
        <?php
        $i = 0;
        foreach ($comm_info as $_v) {
            ?>
            <tr <?php
            if($i%2 != 0){
                echo 'bgcolor="#add8e6"';
            }
            else{
                echo 'bgcolor="#ffffff"';
            }
            ?>>
                <td><a style="text-decoration: none"
                       href="./index.php?r=order/addOrderItem&ord_id=<?php echo $ord_id ?>&item_id=<?php echo $_v->pk_comm_id ?>">添加</a></td>
                <td><?php echo $_v->pk_comm_id ?></td>
                <td><?php echo $_v->comm_name ?></td>
                <td><?php echo $_v->comm_price ?></td>
                </tr>
            <?php
            $i++;
        }
        ?>
        <tr>
            <td colspan="20" style="text-align: center;">
                [1]
            </td>
        </tr>
        </tbody>
    </table>
	<?php $this->endWidget(); ?>
</div>

</body>
</html>