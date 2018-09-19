<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\db\GameSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="game-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'start') ?>

    <?= $form->field($model, 'end') ?>

    <?= $form->field($model, 'conversion_rate') ?>

    <?php // echo $form->field($model, 'money_balance') ?>

    <?php // echo $form->field($model, 'money_from') ?>

    <?php // echo $form->field($model, 'money_to') ?>

    <?php // echo $form->field($model, 'bonus_from') ?>

    <?php // echo $form->field($model, 'bonus_to') ?>

    <?php // echo $form->field($model, 'money_share') ?>

    <?php // echo $form->field($model, 'gift_share') ?>

    <?php // echo $form->field($model, 'bonus_share') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
