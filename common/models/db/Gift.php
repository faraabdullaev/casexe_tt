<?php

namespace common\models\db;

use Yii;

/**
 * This is the model class for table "{{%gift}}".
 *
 * @property int $id
 * @property int $game_id
 * @property string $name
 * @property int $count
 */
class Gift extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%gift}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['game_id', 'name', 'count'], 'required'],
            [['game_id', 'count'], 'integer'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'game_id' => Yii::t('app', 'Game ID'),
            'name' => Yii::t('app', 'Name'),
            'count' => Yii::t('app', 'Count'),
        ];
    }
}
