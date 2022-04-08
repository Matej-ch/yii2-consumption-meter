<?php

namespace matejch\iot24meter\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * @property int $id
 * @property float $price
 * @property int $year
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class Iot24GlobalPrice extends ActiveRecord
{
    public static function tableName()
    {
        return 'iot24_global_price';
    }

    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('iot24meter/msg', 'id'),
            'price' => Yii::t('iot24meter/msg', 'price'),
            'year' => Yii::t('iot24meter/msg', 'year'),
            'created_at' => Yii::t('iot24meter/msg', 'created_at'),
            'updated_at' => Yii::t('iot24meter/msg', 'updated_at')
        ];
    }

    public function rules(): array
    {
        return [
            [['price', 'year'], 'required'],
            [['year'], 'integer'],
            [['price'], 'number'],
            [['year'], 'default', 'value' => date('Y')],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    public function behaviors(): array
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }
}