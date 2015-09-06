<?php

/**
 * 工具借出记录模型
 * Class Tool_Lend_History
 */
class Tool_Lend_History extends CActiveRecord
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
		return '{{tool_lend_history}}';
	}
}