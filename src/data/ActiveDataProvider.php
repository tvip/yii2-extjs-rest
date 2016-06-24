<?php
/**
 * @link http://www.tvip.ru
 * @copyright Copyright (c) 2016 Tvip Ltd.
 */

namespace tvip\ExtJsRest\data;

use Yii;
use yii\data\ActiveDataProvider as BaseDataProvider;
use yii\web\Request;
/**
 * @inheritdoc
 */

class ActiveDataProvider extends BaseDataProvider
{
    /**
     * @inheritdoc
     */
    public $pageParam = 'page';

    /**
     * @inheritdoc
     */
    public $pageSizeParam = 'limit';

    /**
     * @inheritdoc
     */
    public $sortParam = 'sort';

    /**
     * @inheritdoc
     */
    public $filterParam = 'filter';

    /**
     * @var array mapping ExtJs.filter operators to ActiveDataProvider
     */
    public $filterOperatorMap = [
        'eq' => '=',
        'gt' => '>=',
        'lt' => '<=',
    ];


    /**
     * @inheritdoc
     */
    protected function prepareModels()
    {
        $this->setPagination(['pageParam' => $this->pageParam,'pageSizeParam' => $this->pageSizeParam]);
        $this->setSort(['sortParam' => $this->sortParam,'enableMultiSort' => true]);
        $this->setFilter();
        return parent::prepareModels();
    }

    /**
     * @inheritdoc
     */
    public function setSort($value)
    {
        $config = ['class' => Sort::className()];
        parent::setSort(\Yii::createObject(array_merge($config, $value)));
    }

    public function setFilter()
    {
        $attributeFilters = [];

        $request = Yii::$app->getRequest();
        $params = $request instanceof Request ? $request->getQueryParams() : [];

        if (isset($params[$this->filterParam]) && is_scalar($params[$this->filterParam])) {

            $filterParameters = \yii\helpers\Json::decode($params[$this->filterParam]);

            foreach ($filterParameters as $filterParam) {

                $this->query->andFilterWhere([
                    isset($this->filterOperatorMap[$filterParam['operator']]) ? $this->filterOperatorMap[$filterParam['operator']] : $filterParam['operator'],
                    $filterParam['property'],
                    $filterParam['value']
                ]);

            }
        }
        return $attributeFilters;
    }


}
