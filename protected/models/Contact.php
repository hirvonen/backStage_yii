<?php

/**
 * 订单模型
 * Class Contact
 */
class Contact extends CActiveRecord
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
		return '{{contact}}';
	}

    public function attributeLabels()
    {
        return array(
            'pk_contact_id'=>'订单编号',
            'con_open_id'=>'用户openid',
            'con_name'=>'用户姓名',
            'con_mobile'=>'用户电话',
            'con_prefer'=>'服务项目',
            'con_time'=>'上门时间',
            'con_address'=>'地址',
            'con_upt_time'=>'订单更新时间',
            'con_flag'=>'是否支付',
            'con_beau_id'=>'美疗师',
            'con_district'=>'区',
            'con_referee'=>'推荐人',
            'con_kind'=>'活动类别',
            'con_status'=>'订单状态'
        );
    }

    /**
     * 表单验证规则
     */
    public function rules()
    {
        return array(
            array('pk_contact_id,con_open_id,con_name,con_mobile,
            con_prefer,con_time,con_address,con_upt_time,con_flag,con_beau_id,con_district,con_referee,con_kind,con_status','safe'),
        );
    }
}