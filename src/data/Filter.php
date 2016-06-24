<?php
/**
 * @link http://www.tvip.ru
 * @copyright Copyright (c) 2016 Tvip Ltd.
 */

namespace tvip\ExtJsRest\data;

use Yii;
use yii\web\Request;
use yii\data\Sort as BaseSort;


class Filter extends BaseSort
{
    /**
     * @inheritdoc
     */
    public function getAttributeOrders($recalculate = false)
    {
        $attributeOrders = [];
        if (($params = $this->params) === null) {
            $request = Yii::$app->getRequest();
            $params = $request instanceof Request ? $request->getQueryParams() : [];
        }
        if (isset($params[$this->sortParam]) && is_scalar($params[$this->sortParam])) {

            $sortParameters = \yii\helpers\Json::decode($params[$this->sortParam]);

            foreach ($sortParameters as $sortParam) {
                $attribute=$sortParam['property'];

                $descending = $sortParam['direction']=='DESC' ? true : false;

                if (isset($this->attributes[$attribute])) {
                    $attributeOrders[$attribute] = $descending ? SORT_DESC : SORT_ASC;
                    if (!$this->enableMultiSort) {
                        return $attributeOrders;
                    }
                }
            }
        }
        return $attributeOrders;
    }
}
