<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property integer $customer_id
 * @property string $order_date
 * @property string $sent_date
 * @property string $cancel_date
 * @property string $notes
 * @property string $total
 *
 * @property Customer $customer
 * @property OrderLine[] $orderLines
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_id', 'order_date'], 'required'],
            [['customer_id'], 'integer'],
            [['order_date', 'sent_date', 'cancel_date'], 'safe'],
            [['notes'], 'string'],
            [['total'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Order Number',
            'customer_id' => 'Customer',
            'order_date' => 'Order Date',
            'sent_date' => 'Sent Date',
            'cancel_date' => 'Cancel Date',
            'notes' => 'Notes',
            'total' => 'Total',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrderLines()
    {
        return $this->hasMany(OrderLine::className(), ['order_id' => 'id']);
    }
}
