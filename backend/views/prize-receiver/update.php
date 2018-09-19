<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\db\PrizeReceiver */

$this->title = Yii::t('app', 'Update Prize Receiver: ' . $model->id, [
    'nameAttribute' => '' . $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Prize Receivers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="prize-receiver-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_view', ['model' => $model]) ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
