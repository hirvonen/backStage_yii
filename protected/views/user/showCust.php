<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />

	<title>顾客列表</title>

	<link href="<?php echo BACK_CSS_URL; ?>mine.css" type="text/css" rel="stylesheet" />
</head>
<body>
<div class="div_head">
            <span>
                <span style="float: left;">当前位置是：用户管理-》顾客一览</span>
                <span style="float: right; margin-right: 8px; font-weight: bold;">
                    <a style="text-decoration: none;" href="#">【添加顾客】</a>
                </span>
            </span>
</div>
<div></div>
<div class="div_search">
            <span>
                <?php
                $form = $this->beginWidget('CActiveForm');
                $code_model = Code::model();
                $query = 'select * from tbl_code where code_tbl_name="tbl_customer" and code_name="cust_source"';
                $code_info = $code_model->findAllBySql($query);
                if(isset($_POST["cust_source"])) {
	                $select_kind = $_POST["cust_source"];
                }
                else {
	                $select_kind = 0;
                }
                echo '来源<select name="cust_source" style="width: 100px;">';

                if($code_info) {
	                foreach ($code_info as $_v) {
		                if ($select_kind == $_v->code_value) {
			                $print_word = " selected=" . "'" . "selected" . "' " . "value='" . $_v->code_value . "'";
		                } else {
			                $print_word = "value=" . "'" . $_v->code_value . "'";
		                }
		                echo '<option ' . $print_word . '>' . $_v->code_meaning . '</option>';
	                }
                }

                ?>
	            </select>
	                <input value="查询" type="submit" />
	            <?php $this->endWidget(); ?>
            </span>
</div>
<div style="font-size: 13px; margin: 10px 5px;">
	<table class="table_show_color" border="1" width="100%">
		<tbody>
		<tr class="alt">
			<th>顾客id</th>
			<th>姓名</th>
			<th>手机</th>
			<th>来源</th>
		</tr>
		<?php
		$count = 0;
		foreach (array_reverse($cust_info) as $_v) {
			if($count%2 == 0) {
				echo '<tr>';
			} else {
				echo '<tr class="alt">';
			}

			echo '<td><a href="./index.php?r=user/updateCust&id='.$_v->pk_cust_id.'">'.$_v->pk_cust_id.'</td>';
			//为上传暂时屏蔽
//			echo '<td><a href="#">'.$_v->pk_cust_id.'</td>';
			echo '<td>'.$_v->cust_realname.'</td>';
			$user_cust_info = $user_info->findbyPK($_v->pk_cust_id);
			if($user_cust_info){
				echo '<td>'.$user_cust_info->usr_username.'</td>';
			} else {
				echo '<td></td>';
			}

			for($i=0;$i<count($code_info);$i++) {
				if($code_info[$i]->code_value == $_v->cust_source) {
					echo '<td>'.$code_info[$i]->code_meaning.'</td>';
					break;
				}
			}
			if($i >= count($code_info)) {
				echo '<td>来源未确定</td>';
			}

			echo '</tr>';
			$count++;
		}
		?>
		</tbody>
	</table>
</div>
</body>
</html>