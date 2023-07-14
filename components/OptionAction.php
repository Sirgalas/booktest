<?php

declare(strict_types=1);

namespace app\components;

use Yii;

class OptionAction extends \yii\rest\OptionsAction
{
    public function run($id = null)
    {
        if (Yii::$app->getRequest()->getMethod() !== 'OPTIONS') {
            Yii::$app->getResponse()->setStatusCode(405);
        }
        $options = $id === null ? $this->collectionOptions : $this->resourceOptions;
        $headers = Yii::$app->getResponse()->getHeaders();
        $headers->set('Allow', implode(', ', $options));
    }
}