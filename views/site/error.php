<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception$exception */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $name;
?>

<section class="section error-404 min-vh-100 d-flex flex-column align-items-center justify-content-center">
    <h1><?= $exception->statusCode ?></h1>
    <h2><?= Html::encode($this->title) . ' : ' . nl2br(Html::encode($message)) ?></h2>
    <a class="btn" href="<?= Url::to(['site/index']) ?>"><i class="bi bi-arrow-left-square"></i> Back to home</a>
    <img src="/template/assets/img/not-found.svg" class="img-fluid py-5" alt="<?= Html::encode($this->title) ?>">
</section>