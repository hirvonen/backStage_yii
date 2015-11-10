<?php

/**
 * 顾客信息模型
 * Class Cust_Health_Info
 */
class Cust_Health_Info extends CActiveRecord
{
	/**
	 * 创建模型对象
	 * @param string $className
	 * @return static
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * 返回数据表名字
	 * @return string
	 */
	public function tableName()
	{
		return '{{cust_health_info}}';
	}

	public function attributeLabels()
	{
		return array(
			'custhi_height'=>'身高',
			'custhi_weight'=>'体重',
			'custhi_exam_desp'=>'体质检测情况描述',
			'custhi_bear_info'=>'生产情况',
			'custhi_lactation_info'=>'哺乳情况',
			'custhi_allergy_info'=>'过敏情况',
			'custhi_medical_info'=>'病史情况',
			'custhi_period_info'=>'例假情况',
			'custhi_sleeping_info'=>'睡眠情况',
			'custhi_sports_info'=>'运动情况',
			'custhi_other_health_info'=>'其他健康相关情况',
		);
	}

	/**
	 * 商品添加表单验证规则
	 */
	public function rules()
	{
		return array(
			array('custhi_height,custhi_weight','match','pattern'=>'^(([0-9]+.[0-9]*[1-9][0-9]*)|([0-9]*[1-9][0-9]*.[0-9]+)|([0-9]*[1-9][0-9]*))$^','message'=>'此处必须填写数字！（可以为0）'),
			array('custhi_exam_desp,custhi_bear_info,
			custhi_lactation_info,custhi_allergy_info,custhi_medical_info,custhi_period_info,custhi_sleeping_info,
			custhi_sports_info,custhi_other_health_info','safe'),
		);
	}
}