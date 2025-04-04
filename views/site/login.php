<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */

/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;

$this->title = 'Login';
?>



<div class="row justify-content-center">
    <div class="col-lg-4 col-md-6 align-items-center justify-content-center">
        <div class="card card my-5">
            <div class="card-body">
                <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">
                        <i class="bi bi-box-arrow-in-right"></i> เข้าสู่ระบบ
                    </h5>
                </div>
                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                ]); ?>
                <div class="col-12">
                    <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
                </div>
                <div class="col-12">
                    <?= $form->field($model, 'password')->passwordInput() ?>
                </div>
                <div class="col-12">
                    <?= $form->field($model, 'rememberMe')->checkbox([
                        'template' => "<div class=\"custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
                    ]) ?>
                </div>
                <div class="col-12">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary w-100', 'name' => 'login-button']) ?>
                </div>
                <!-- <div class="col-12 pt-2">
                    <p class="small mb-0">Don't have account? <a href="pages-register.html">Create an
                            account</a></p>
                </div> -->
                <?php ActiveForm::end(); ?>

            </div>
        </div>

    </div>
</div>