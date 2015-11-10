<?php

/**
 * 顾客购买疗程信息
 * Class Cust_Purchase_Info
 */
class Cust_Purchase_Info extends CActiveRecord
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
		return '{{cust_purchase_info}}';
	}
}