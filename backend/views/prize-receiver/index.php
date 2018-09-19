<?php

use common\models\db\PrizeReceiver;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\db\PrizeReceiverSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Prize Receivers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prize-receiver-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Prize Receiver'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            [
                'attribute' => 'game_id',
                'value' => 'game.name'
            ],
            [
                'attribute' => 'user_id',
                'value' => 'user.username'
            ],
            [
                'attribute' => 'prize_type',
                'value' => function($model) {
                    return $model->typeLabels()[$model->prize_type];
                },
                'filter' => $searchModel->typeLabels(),
            ],
            [
                'attribute' => 'prize_value',
                'value' => function($model) {
                    if ($model->prize_type === PrizeReceiver::PRIZE_TYPE_IS_GIFT)
                        return $model->gift->name;
                    if ($model->prize_type === PrizeReceiver::PRIZE_TYPE_IS_MONEY)
                        return "\${$model->prize_value}";
                    return $model->prize_value;
                },
            ],
            [
                'attribute' => 'prize_status',
                'value' => function($model) {
                    return $model->statusLabels()[$model->prize_status];
                },
                'filter' => $searchModel->statusLabels(),
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}    {update}'
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
