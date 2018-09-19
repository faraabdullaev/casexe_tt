<?php
use common\models\db\PrizeReceiver;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\db\PrizeReceiver */

echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        [
            'attribute' => 'game_id',
            'value' => $model->game->name
        ],
        [
            'attribute' => 'user_id',
            'value' => $model->user->username
        ],
        [
            'attribute' => 'prize_type',
            'value' => $model->typeLabels()[$model->prize_type]
        ],
        [
            'attribute' => 'prize_value',
            'value' => function($model) {
                if ($model->prize_type === PrizeReceiver::PRIZE_TYPE_IS_GIFT)
                    return $model->gift->name;
                if ($model->prize_type === PrizeReceiver::PRIZE_TYPE_IS_MONEY)
                    return "\${$model->prize_value}";
                return $model->prize_value;
            }
        ],
        [
            'attribute' => 'prize_status',
            'value' => $model->statusLabels()[$model->prize_status]
        ],
        'created_date',
        'updated_date',
    ],
]);