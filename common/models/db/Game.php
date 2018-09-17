<?php

namespace common\models\db;

use Yii;

/**
 * This is the model class for table "{{%game}}".
 *
 * @property int $id
 * @property string $name
 * @property string $start
 * @property string $end
 * @property double $conversion_rate
 * @property int $money_balance
 * @property int $money_from
 * @property int $money_to
 * @property int $bonus_from
 * @property int $bonus_to
 * @property int $money_share
 * @property int $gift_share
 * @property int $bonus_share
 */
class Game extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%game}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['start', 'end'], 'safe'],
            [['conversion_rate'], 'number'],
            [['money_balance', 'money_from', 'money_to', 'bonus_from', 'bonus_to', 'money_share', 'gift_share', 'bonus_share'], 'integer'],
            [['name'], 'string', 'max' => 100],

            [['money_share', 'gift_share', 'bonus_share'], function ($attribute) {
                $sum = $this->money_share + $this->gift_share + $this->bonus_share;
                if ($sum !== 100) {
                    $this->addError($attribute, Yii::t('app', 'The sum of `money_share`, `gift_share` & `bonus_share` must be equal to 100'));
                }
            }],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'start' => Yii::t('app', 'Start'),
            'end' => Yii::t('app', 'End'),
            'conversion_rate' => Yii::t('app', 'Conversion Rate'),
            'money_balance' => Yii::t('app', 'Money Balance'),
            'money_from' => Yii::t('app', 'Money From'),
            'money_to' => Yii::t('app', 'Money To'),
            'bonus_from' => Yii::t('app', 'Bonus From'),
            'bonus_to' => Yii::t('app', 'Bonus To'),
            'money_share' => Yii::t('app', 'Money Share'),
            'gift_share' => Yii::t('app', 'Gift Share'),
            'bonus_share' => Yii::t('app', 'Bonus Share'),
        ];
    }
}
