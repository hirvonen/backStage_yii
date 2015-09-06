<?php

/**
 * 服务-工具关系模型
 * Class Service_Tool_Relation
 */
class Service_Tool_Relation extends CActiveRecord
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
		return '{{service_tool_relation}}';
	}
}