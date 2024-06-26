<?php
use yii\helpers\Url;

?>


<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="<?= Url::to(['site/index']) ?>" class="logo d-flex align-items-center">
            <img src="/template/assets/img/logo.png" alt="">
            <span class="d-none d-lg-block"><?= Yii::$app->params['meta_project'] ?></span>
        </a>
    </div><!-- End Logo -->

    <div class="search-bar">
        <form class="search-form d-flex align-items-center" method="POST" action="#">
            <input type="text" name="query" placeholder="Search" title="Enter search keyword">
            <button type="submit" title="Search"><i class="bi bi-search"></i></button>
        </form>
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <li class="nav-item d-block d-lg-none">
                <a class="nav-link nav-icon search-bar-toggle " href="#">
                    <i class="bi bi-search"></i>
                </a>
            </li>

            <li class="nav-item dropdown pe-3">
                <a class="nav-link nav-icon fw-bold m-0" href="<?= Url::to(['site/login']) ?>">
                    <i class="bi bi-box-arrow-in-right"></i> เข้าสู่ระบบ
                </a>
            </li>
        </ul>
    </nav>
</header>