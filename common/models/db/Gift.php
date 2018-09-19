<?php

namespace common\models\db;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%gift}}".
 *
 * @property int $id
 * @property int $game_id
 * @property string $name
 * @property int $count
 * @property Game $game
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
            [['name'], 'filter', 'filter' => 'trim'],
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

    public function getGame()
    {
        return $this->hasOne(Game::class, ['id' => 'game_id']);
    }

    public function getGamesList() {
        return ArrayHelper::map(Game::find()->all(), 'id', 'name');
    }
}
