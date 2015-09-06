<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />

    <title>选择用户</title>

    <link href="<?php echo BACK_CSS_URL; ?>mine.css" type="text/css" rel="stylesheet" />
</head>
<body>
<style>
    .tr_color{background-color: #9F88FF}
</style>
<div class="div_head">
            <span>
                <span style="float: left;">当前位置是：订单管理-》添加订单-》选择用户</span>
                <span style="float: right; margin-right: 8px; font-weight: bold;">
                    <a style="text-decoration: none" href="./index.php?r=order/add&usr_id=0">【返回】</a>
                </span>
            </span>
</div>
<div></div>
<div style="font-size: 13px; margin: 10px 5px;">
    <table class="table_a" border="1" width="100%">
        <tbody><tr bgcolor="#4169e1" style="font-weight: bold;">
            <td></td>
            <td>顾客编号</td>
            <td>顾客姓名</td>
            <td>电话号码</td>
            <td>创建时间</td>
        </tr>
        <?php
        $cust_model = Customer::model();
        $cust_info = $cust_model->findAll();
        $usr_model = User::model();
        $i=0;

        foreach ($cust_info as $_v) {
            //tbl_user情报准备
            $usr_info = $usr_model->findByPk($_v->pk_cust_id);

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
            echo '<td><a href="./index.php?r=order/add&usr_id=';
            echo $_v->pk_cust_id;
            echo '">选择</a></td>';

            //第二列（顾客id）
            echo '<td>';
            echo $_v->pk_cust_id;
            echo '</td>';

            //第三列（顾客姓名）
            echo '<td>';
            echo $_v->cust_realname;
            echo '</td>';

            //第四列（电话号码）
            echo '<td>';
            echo $usr_info->usr_username;
            echo '</td>';

            //第五列（创建时间）
            echo '<td>';
            echo $usr_info->usr_create_time;
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