<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\db\PrizeReceiver */

$this->title = Yii::t('app', 'Create Prize Receiver');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Prize Receivers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prize-receiver-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
