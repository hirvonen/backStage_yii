<?php

/**
 * 管理员模型
 * Class Admin
 */
class Admin extends CActiveRecord
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
		return '{{admin}}';
	}

	public function attributeLabels()
	{
		return array(
			'adm_level'=>'管理员级别',
		);
	}

	/**
	 * 商品添加表单验证规则
	 */
	public function rules()
	{
		return array(
			array('adm_level','required','message'=>'管理员级别必选！'),
		);
	}
}