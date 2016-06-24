<?php
/**
 * @link http://www.tvip.ru
 * @copyright Copyright (c) 2016 Tvip Ltd.
 */

namespace tvip\ExtJsRest;

use Yii;
use yii\helpers\ArrayHelper;
use yii\rest\Controller as BaseController;
use tvip\ExtJsRest\data\Serializer;

/**
 * @inheritdoc
 */
class Controller extends BaseController
{
    /**
     * @inheritdoc
     */
    protected function serializeData($data)
    {
        return Yii::createObject(['class' => Serializer::className()])->serialize($data);
    }
}
