<?php

/**
 * 商品模型
 * Class Commodity
 */
class Commodity extends CActiveRecord
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
		return '{{commodity}}';
	}

	public function attributeLabels()
	{
		return array(
			'comm_name'=>'商品名称',
			'comm_price'=>'商品价格',
			'comm_kind'=>'商品种别',
			'comm_on_shelve_time'=>'上架时间',
			'comm_off_shelve_time'=>'下架时间',
			'comm_update_time'=>'更新时间',
			'comm_check_times'=>'被查看次数',
			'comm_discount'=>'折扣价格',
			'comm_intro1'=>'商品介绍1',
			'comm_intro2'=>'商品介绍2',
			'comm_intro3'=>'商品介绍3',
			'comm_intro4'=>'商品介绍4',
			'comm_intro5'=>'商品介绍5',
			'comm_is_hot'=>'热门商品',
			'comm_is_show'=>'商品显示',
			'comm_sort_order'=>'顺序',
		);
	}

	/**
	 * 商品添加表单验证规则
	 */
	public function rules()
	{
		return array(
			array('comm_name','required','message'=>'商品名称必填'),
//			array('comm_name','unique','message'=>'商品名称已经登录'),
			array('comm_price','required','message'=>'商品价格必填'),
//			array('comm_price','match','pattern'=>'/^(([1-9]\d{0,9})|0)(\.\d{1,2})?$/','message'=>'价格必须是非0数字'),
			array('comm_price,comm_discount','match','pattern'=>'/^[0-9]+(.[0-9]{2})?$/','message'=>'价格必须是非0数字'),
//			array('comm_discount','match','pattern'=>'/^(([1-9]\d{0,9})|0)(\.\d{1,2})?$/','message'=>'折扣价格必须是非0数字'),
			array('comm_intro1','required','message'=>'商品简介必填'),
			array('comm_sort_order','match','pattern'=>'/^[1-9]\d*$/','message'=>'排序必须是非0数字'),
			array('comm_kind,comm_intro2,comm_intro3,comm_intro4,comm_intro5,comm_is_hot,comm_is_show,comm_on_shelve_time,comm_off_shelve_time,comm_update_time,comm_check_times,','safe'),
		);
	}
}