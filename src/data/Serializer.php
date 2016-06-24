<?php
/**
 * @link http://www.tvip.ru
 * @copyright Copyright (c) 2016 Tvip Ltd.
 */

namespace tvip\ExtJsRest\data;

use Yii;
use yii\web\Link;
use yii\rest\Serializer as BaseSerializer;

/**
 * @inheritdoc
 */
class Serializer extends BaseSerializer
{
    /*
     *  For ExtJs proxy reader set params:
     * reader: {
     *   type: 'json',
     *   rootProperty: 'data',
     *   },
     */
    public $collectionEnvelope = 'data';

    /**
     * @inheritdoc
     */
    public $linksEnvelope = '_links';

    /**
     * @inheritdoc
     */
    public $metaEnvelope = 'metaData';

    /**
     * @inheritdoc
     */
    protected function serializeDataProvider($dataProvider)
    {
        $models = $this->serializeModels($dataProvider->getModels());

        if (($pagination = $dataProvider->getPagination()) !== false) {
            $this->addPaginationHeaders($pagination);
        }

        $result = [
            $this->collectionEnvelope => $models,
            'success' => true,
        ];
        if ($pagination !== false) {
            return array_merge($result, $this->serializePagination($pagination));
        } else {
            return $result;
        }

    }

    /**
     * @inheritdoc
     */
    protected function serializePagination($pagination)
    {
        return [
            $this->linksEnvelope => Link::serialize($pagination->getLinks(true)),

            'total' => $pagination->totalCount,
            'pageCount' => $pagination->getPageCount(),
            'currentPage' => $pagination->getPage() + 1,
            'perPage' => $pagination->getPageSize(),
        ];
    }

    /**
     * @inheritdoc
     */
    protected function serializeModelErrors($model)
    {
        $this->response->setStatusCode(422, 'Data Validation Failed.');
        $result = [];
        foreach ($model->getFirstErrors() as $name => $message) {
            $result[] = [
                'success' => false,
                'field' => $name,
                'message' => $message,
            ];
        }

        return $result;
    }

}
