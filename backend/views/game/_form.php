<?php

use kartik\datetime\DateTimePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\db\Game */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="game-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'start')->widget(DateTimePicker::class, [
        'options' => ['placeholder' => Yii::t('main', 'Game Start')],
        'pluginOptions' => [
            'autoclose' => true
        ]
    ]) ?>

    <?= $form->field($model, 'end')->widget(DateTimePicker::class, [
        'options' => ['placeholder' => Yii::t('main', 'Game End')],
        'pluginOptions' => [
            'autoclose' => true
        ]
    ]) ?>

    <?= $form->field($model, 'conversion_rate')->textInput() ?>

    <?= $form->field($model, 'money_balance')->textInput() ?>

    <?= $form->field($model, 'money_from')->textInput() ?>

    <?= $form->field($model, 'money_to')->textInput() ?>

    <?= $form->field($model, 'bonus_from')->textInput() ?>

    <?= $form->field($model, 'bonus_to')->textInput() ?>

    <?= $form->field($model, 'money_share')->textInput() ?>

    <?= $form->field($model, 'gift_share')->textInput() ?>

    <?= $form->field($model, 'bonus_share')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
