<?php

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var Exception$exception */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $name;
?>

<div class="text-center">
    <div class="error mx-auto" data-text="<?= $exception->statusCode ?>"><?= $exception->statusCode ?></div>
    <p class="lead text-gray-800 mb-5"><?= Html::encode($this->title) . ' : ' . nl2br(Html::encode($message)) ?></p>
    <p class="text-gray-500 mb-0">It looks like you found a glitch in the matrix...</p>
    <a href="<?= Url::to(['site/index']) ?>">&larr; Back to Dashboard</a>
</div>