Yii 2 REST API for ExtJs(sencha)
============================

REST API ActiveController support for input parameters extjs and serialize response.
Enable in extjs store remoteSort, remoteFilter and autoSync in viewModel.

EXAMPLE PROXY CLASS EXTJS
-------------------
```php
Ext.define('tvip.proxy.YiiRestProxy', {
    extend: 'Ext.data.proxy.Rest',
    alias: 'proxy.yiirest',

    type: 'rest',

    reader: {
        type: 'json',
        rootProperty: 'data',
    },

    writer: {
        type: 'json'
    },

    headers: {
        "Accept": "application/json",
    },
});
```
INSTALLATION
------------
~~~
composer require tvip/yii2-extjs-rest
~~~

USE
------------
Example controller
```php
<?php
namespace app\modules\api\components;

use Yii;
use yii\helpers\ArrayHelper;
use tvip\ExtJsRest\ActiveController;

class Controller extends ActiveController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(),[
            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
                'cors' => [
                    'Origin' => ['*'],
                    'Access-Control-Request-Headers' => ['*'],
                    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                ],
            ]
        ]);
    }
}

```
