<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "order_line".
 *
 * @property integer $id
 * @property integer $order_id
 * @property integer $book_id
 * @property integer $qty
 * @property string $price
 *
 * @property Book $book
 * @property Order $order
 */
class OrderLine extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_line';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'book_id', 'qty', 'price'], 'required'],
            [['order_id', 'book_id', 'qty'], 'integer'],
            [['price'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'book_id' => 'Book ID',
            'qty' => 'Qty',
            'price' => 'Price',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBook()
    {
        return $this->hasOne(Book::className(), ['id' => 'book_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['id' => 'order_id']);
    }
}
