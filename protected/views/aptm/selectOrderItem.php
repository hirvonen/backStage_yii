<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />

    <title>选择订单</title>

    <link href="<?php echo BACK_CSS_URL; ?>mine.css" type="text/css" rel="stylesheet" />
</head>
<body>
<style>
    .tr_color{background-color: #9F88FF}
</style>
<div class="div_head">
            <span>
                <span style="float: left;">当前位置是：预约管理-》添加预约-》选择用户订单</span>
                <span style="float: right; margin-right: 8px; font-weight: bold;">
                    <a style="text-decoration: none" href="./index.php?r=aptm/selectCust">【返回】</a>
                </span>
            </span>
</div>
<div></div>
<div style="font-size: 13px; margin: 10px 5px;">
    <table class="table_a" border="1" width="100%">
        <tbody><tr bgcolor="#4169e1" style="font-weight: bold;">
            <td></td>
            <td>项目名</td>
            <td>订单时间</td>
            <td>订单状态</td>
            <td>价格</td>
        </tr>
        <?php
        $comm_model = Commodity::model();
        $order_model = Order::model();
        $i=0;

        foreach ($ord_itm_info as $_v) {
            if(!$_v) {
                continue;
            }
            $comm_info = $comm_model->findByPk($_v->ord_item_comm_id);
            $order_info = $order_model->findByPk($_v->pk_ord_itm_ord_id);

            //背景颜色
            echo '<tr';
            if($i%2 != 0){
                echo ' bgcolor="#add8e6"';
            }
            else{
                echo ' bgcolor="#ffffff"';
            }
            echo '>';

            //第一列（超链接选择）
            echo '<td><a href="./index.php?r=aptm/add&ord_itm_id=';
            echo $_v->pk_ord_itm_id;
            echo '">选择该订单</a></td>';

            //第二列（项目名）
            echo '<td>';
            echo $comm_info->comm_name;
            echo '</td>';

            //第三列（订单时间）
            echo '<td>';
            echo $order_info->ord_upt_time;
            echo '</td>';

            //第四列（订单状态）
            echo '<td>';
            switch($order_info->ord_status) {
                case 100:
                    echo '等待付款';
                    break;
                case 200:
                    echo '等待确认';
                    break;
                case 300:
                    echo '进行中';
                    break;
                case 400:
                    echo '订单已取消';
                    break;
                case 500:
                    echo '等待评价';
                    break;
                case 600:
                    echo '订单完成';
                    break;
            }
            echo '</td>';

            //第五列（价格）
            echo '<td>';
            echo $_v->ord_item_price;
            echo '</td>';

            echo '</tr>';

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
</div>
</body>
</html>