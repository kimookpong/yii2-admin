<?php

namespace app\components;

use app\models\User;
use Yii;
use yii\base\BootstrapInterface;

class LanguageSelector implements BootstrapInterface
{
    public $supportedLanguages = [];

    public function bootstrap($app)
    {
        $app->language = 'th';
        if (!empty(Yii::$app->user->id)) {
            $identity = User::findOne(['id' => Yii::$app->user->id]);
            if ($identity) {
                $identity->updateAttributes(['updated_at' => date('Y-m-d H:i:s')]);
            }
        }
    }
}
