<?php

/**
 * 商品_商品模型
 * Class Commodity_Product
 */
class Commodity_Product extends CActiveRecord
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
		return '{{commodity_product}}';
	}

	public function attributeLabels()
	{
		return array(
			'prod_kind'=>'商品种别',
			'prod_stock'=>'商品库存',
			'prod_brand_id'=>'商品品牌',
		);
	}

	/**
	 * 商品添加表单验证规则
	 */
	public function rules()
	{
		return array(
			array('prod_stock','required','message'=>'商品库存必填'),
			array('prod_stock','match','pattern'=>'/^[0-9]\d*$/','message'=>'商品库存必须是数字'),
			array('prod_brand_id','required','message'=>'商品品牌必填'),
			array('prod_kind','safe'),
		);
	}
}