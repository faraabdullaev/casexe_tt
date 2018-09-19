<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\db\Game */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Games'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="game-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'is_active:boolean',
            'start',
            'end',
            'conversion_rate',
            'money_balance',
            'money_from',
            'money_to',
            'bonus_from',
            'bonus_to',
            'money_share',
            'gift_share',
            'bonus_share',
        ],
    ]) ?>

</div>
