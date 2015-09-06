<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
    <title>选择预约一览</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <link href="<?php echo BACK_CSS_URL; ?>mine.css" type="text/css" rel="stylesheet">
</head>

<body>
<!--<div style="width:1300px;height:500px;overflow:scroll;">-->
<div>
    <?php
    echo '美疗师：'.$beau_name.'<br>';
    $from_date_show = date('Y-m-d',strtotime("$from_date"));
    $to_date_show = date('Y-m-d',strtotime("$to_date -1 day"));
    echo $from_date_show.'~'.$to_date_show;
    /**输出表头**/
    echo '<table border="2" width="100%" class="table_b">';
    for($i=0;$i<$day_count;$i++) {
        $date_loop = date('Y-m-d',strtotime("$from_date".' +'.$i.' day'));
        echo '<tr><td height="120">'.$date_loop.'</td></tr>';
        foreach ($aptm_info_by_day as $_v_aptm_info_by_day) {
            foreach ($_v_aptm_info_by_day as $_v_v_aptm_info_by_day) {
                echo '<tr><td width="120">项目名：</td>';
                echo '<td>'.$_v_v_aptm_info_by_day[COMM_NAME].'</td></tr>';

                echo '<tr><td width="120">客户姓名</td>';
                echo '<td>'.$_v_v_aptm_info_by_day[CUST_NAME].'</td></tr>';

                echo '<tr><td width="120">金额</td>';
                echo '<td>'.$_v_v_aptm_info_by_day[PRICE].'</td></tr>';
//            var_dump($_v_aptm_info_by_day);
                echo '<br>';
            }
        }
        foreach ($contact_info_by_day as $_v_contact_info_by_day) {
            foreach ($_v_contact_info_by_day as $_v_v_contact_info_by_day) {
                echo '<tr><td width="120">项目名：</td>';
                echo '<td>'.$_v_v_contact_info_by_day[COMM_NAME].'</td></tr>';

                echo '<tr><td width="120">客户姓名</td>';
                echo '<td>'.$_v_v_contact_info_by_day[CUST_NAME].'</td></tr>';

                echo '<tr><td width="120">金额</td>';
                echo '<td>'.$_v_v_contact_info_by_day[PRICE].'</td></tr>';
//            var_dump($_v_contact_info_by_day);
                echo '<br>';
            }
        }
    }
    echo '</table>';
    ?>
</div>
</body>
</html>