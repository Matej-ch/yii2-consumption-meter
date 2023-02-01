<?php

namespace matejch\iot24meter;

use Yii;
use yii\base\Module;
use yii\console\Application;
use yii\helpers\Json;

class Iot24 extends Module
{
    public $controllerNamespace = 'matejch\iot24meter\controllers';

    public $defaultRoute = 'iot24/index';

    public $layout = 'main';

    public $apiFile = '';

    public $sender = '';

    public $receiver = '';

    public function init()
    {
        parent::init();

        \Yii::setAlias('@matejch/iot24meter', __DIR__);

        if (Yii::$app instanceof Application) {
            $this->controllerNamespace = 'matejch\iot24meter\commands';
        }

        if (!empty($this->apiFile)) {
            $properties = Json::decode(file_get_contents($this->apiFile));
            \Yii::configure($this, $properties);
        }

        $this->registerTranslations();
    }

    public function registerTranslations(): void
    {
        if (Yii::$app->has('i18n')) {
            Yii::$app->i18n->translations['iot24meter/*'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en',
                'forceTranslation' => true,
                'basePath' => '@matejch/iot24meter/messages',
                'fileMap' => [
                    'iot24meter/msg' => 'msg.php',
                ],
            ];
        }
    }

    public static function t($category, $message, $params = [], $language = null): string
    {
        return Yii::t('iot24meter/' . $category, $message, $params, $language);
    }
}