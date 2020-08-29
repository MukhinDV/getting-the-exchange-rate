<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form-login">

    <div class="row">

        <div class="col-md-6 col-md-offset-3">
            <?php $form = ActiveForm::begin([
                'id' => 'login'
            ]); ?>

            <?= $form->field($model, 'login')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>


            <div class="form-group">
                <?= Html::submitButton('Войти', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>