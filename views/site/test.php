<?php

use app\assets\AppAsset;

$this->registerJsFile('@web/app/test.js?v=' . date('YmdHis'), ['depends' => AppAsset::className()]);
?>
<div class="card">
    <div class="card-body">

    </div>
</div>