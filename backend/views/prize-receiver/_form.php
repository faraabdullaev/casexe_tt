<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\db\PrizeReceiver */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="prize-receiver-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'prize_status')->dropDownList($model->statusLabels()) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
