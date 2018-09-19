<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\Profile */
/* @var $user \common\models\db\User */

/* @var $card \common\models\db\LoyaltyCard */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = 'Profile:';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-profile">
    <h1><?= Html::encode($this->title) ?></h1>

    <h3>
        Loyalty Card Balance: <b><?= $card->balance ?></b>
    </h3>
    <hr>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'profile-form']); ?>

            <?= $form->field($model, 'username')->textInput(['disabled' => true]) ?>

            <?= $form->field($model, 'email')->textInput(['disabled' => true]) ?>

            <?= $form->field($model, 'bank_account')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'address') ?>

            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-primary', 'name' => 'profile-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
