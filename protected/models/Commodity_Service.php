<?php

/**
 * 商品_服务模型
 * Class Commodity_Service
 */
class Commodity_Service extends CActiveRecord
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
		return '{{commodity_service}}';
	}

    public function attributeLabels()
    {
        return array(
            'serv_kind'=>'服务种别',
            'serv_duration'=>'单次服务时长(分钟)',
            'serv_single'=>'是否单次出售',
            'serv_time'=>'疗程内服务次数',
        );
    }

    /**
     * 商品添加表单验证规则
     */
    public function rules()
    {
        return array(
            array('serv_duration','required','message'=>'单次服务时长必填'),
            array('serv_duration','match','pattern'=>'/^[1-9]\d*$/','message'=>'时长必须是非0数字'),
            array('serv_time','required','message'=>'疗程内服务次数必填'),
            array('serv_time','match','pattern'=>'/^[1-9]\d*$/','message'=>'服务次数必须是非0数字'),
            array('serv_kind,serv_single','safe'),
        );
    }
}