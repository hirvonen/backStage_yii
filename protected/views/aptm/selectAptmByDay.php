<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />

	<title>美疗师预约一览</title>

	<link href="<?php echo BACK_CSS_URL; ?>mine.css" type="text/css" rel="stylesheet" />
</head>
<body>
<style>
	.tr_color{background-color: #9F88FF}
</style>
<div class="div_head">
            <span>
                <span style="float: left;">当前位置是：数据管理-》美疗师预约一览</span>
            </span>
</div>
<div></div>
<br>
<br>
<div class="div_search_multi_lines">
            <span>
                <?php $form = $this->beginWidget('CActiveForm'); ?>
	            <?php
	            $beau_model = Beautician::model();
	            $query = 'select * from tbl_beautician where beau_valid=1';
	            $beau_info = $beau_model->findAllBySql($query);
	            ?>
	            美疗师<select name="beau_id" style="width: 100px;">
		            <option value="0">请选择美疗师</option>
		            <?php
		            foreach ($beau_info as $_v_beau_info) {
			            echo '<option value="'.$_v_beau_info->pk_beau_id.'">';
			            echo $_v_beau_info->beau_realname;
			            echo '</option>';
		            }
		            ?>
	            </select>
	            <br>
	            <br>
	            <br>
                从<select name="from_date_year" style="width: 80px;">
		            <option value="2015">2015年</option>
		            <option value="2016">2016年</option>
		            <option value="2017">2017年</option>
	            </select>
	            <select name="from_date_month" style="width: 60px;">
		            <option value="1">1月</option>
		            <option value="2">2月</option>
		            <option value="3">3月</option>
		            <option value="4">4月</option>
		            <option value="5">5月</option>
		            <option value="6">6月</option>
		            <option value="7">7月</option>
		            <option value="8">8月</option>
		            <option value="9">9月</option>
		            <option value="10">10月</option>
		            <option value="11">11月</option>
		            <option value="12">12月</option>
	            </select>
	            <select name="from_date_day" style="width: 60px;">
		            <option value="1">1日</option>
		            <option value="2">2日</option>
		            <option value="3">3日</option>
		            <option value="4">4日</option>
		            <option value="5">5日</option>
		            <option value="6">6日</option>
		            <option value="7">7日</option>
		            <option value="8">8日</option>
		            <option value="9">9日</option>
		            <option value="10">10日</option>
		            <option value="11">11日</option>
		            <option value="12">12日</option>
		            <option value="13">13日</option>
		            <option value="14">14日</option>
		            <option value="15">15日</option>
		            <option value="16">16日</option>
		            <option value="17">17日</option>
		            <option value="18">18日</option>
		            <option value="19">19日</option>
		            <option value="20">20日</option>
		            <option value="21">21日</option>
		            <option value="22">22日</option>
		            <option value="23">23日</option>
		            <option value="24">24日</option>
		            <option value="25">25日</option>
		            <option value="26">26日</option>
		            <option value="27">27日</option>
		            <option value="28">28日</option>
		            <option value="29">29日</option>
		            <option value="30">30日</option>
		            <option value="31">31日</option>
	            </select>
	            <br>到<select name="to_date_year" style="width: 80px;">
		            <option value="2015">2015年</option>
		            <option value="2016">2016年</option>
		            <option value="2017">2017年</option>
	            </select>
	            <select name="to_date_month" style="width: 60px;">
		            <option value="1">1月</option>
		            <option value="2">2月</option>
		            <option value="3">3月</option>
		            <option value="4">4月</option>
		            <option value="5">5月</option>
		            <option value="6">6月</option>
		            <option value="7">7月</option>
		            <option value="8">8月</option>
		            <option value="9">9月</option>
		            <option value="10">10月</option>
		            <option value="11">11月</option>
		            <option value="12">12月</option>
	            </select>
	            <select name="to_date_day" style="width: 60px;">
		            <option value="1">1日</option>
		            <option value="2">2日</option>
		            <option value="3">3日</option>
		            <option value="4">4日</option>
		            <option value="5">5日</option>
		            <option value="6">6日</option>
		            <option value="7">7日</option>
		            <option value="8">8日</option>
		            <option value="9">9日</option>
		            <option value="10">10日</option>
		            <option value="11">11日</option>
		            <option value="12">12日</option>
		            <option value="13">13日</option>
		            <option value="14">14日</option>
		            <option value="15">15日</option>
		            <option value="16">16日</option>
		            <option value="17">17日</option>
		            <option value="18">18日</option>
		            <option value="19">19日</option>
		            <option value="20">20日</option>
		            <option value="21">21日</option>
		            <option value="22">22日</option>
		            <option value="23">23日</option>
		            <option value="24">24日</option>
		            <option value="25">25日</option>
		            <option value="26">26日</option>
		            <option value="27">27日</option>
		            <option value="28">28日</option>
		            <option value="29">29日</option>
		            <option value="30">30日</option>
		            <option value="31">31日</option>
	            </select>
	            <br>
	            <br>
	                <input value="查询" type="submit" />
	            <?php $this->endWidget(); ?>
            </span>
</div>
</body>
</html>