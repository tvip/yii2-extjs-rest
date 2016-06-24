<?php
/**
 * @link http://www.tvip.ru
 * @copyright Copyright (c) 2016 Tvip Ltd.
 */

namespace tvip\ExtJsRest\actions;

use Yii;
use yii\db\ActiveRecord;
use yii\web\ServerErrorHttpException;
use yii\rest\UpdateAction as Action;

/**
 * @inheritdoc
 */
class UpdateAction extends Action
{

    /**
     * @inheritdoc
     */
    public function run($id)
    {
        /* @var $model ActiveRecord */
        $model = $this->findModel($id);

        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }

        $model->scenario = $this->scenario;
        $params = array_keys(Yii::$app->getRequest()->getBodyParams());
        foreach ($params as $param){
            $model->load(\yii\helpers\Json::decode($param), '');
            if ($model->save() === false && !$model->hasErrors()) {
                throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
            }
        }

        return $model;
    }
}
