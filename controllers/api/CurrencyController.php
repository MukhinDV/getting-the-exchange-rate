<?php


namespace app\controllers\api;

use app\components\Response;
use app\models\Currency;
use app\models\forms\{AllCurrencyForm, CurrencyForm};
use Yii;

class CurrencyController extends BaseApiController
{
    /**
     * Find all currency
     *
     * @return array
     */
    public function actionGetAllCurrency(): array
    {
        if (Yii::$app->getRequest()->isGet) {
            if (!empty(Currency::find()->all())) {
                $model = new AllCurrencyForm();
                return Response::succeededWithData($model->getResult());
            } else {
                return Response::responseError('Данные по валютам отсутсвуют');
            }
        }
        return Response::methodNotAllowed('GET');
    }

    /**
     * Find currency by id
     *
     * @param string $id
     *
     * @return array
     */
    public function actionGetCurrency(string $id): array
    {
        if (Yii::$app->getRequest()->isGet) {
            $model = new CurrencyForm($id);
            if ($model->validate()) {
                return Response::succeededWithData($model->getResult());
            } else {
                return Response::validateErrors($model->errors);
            }
        }
        return Response::methodNotAllowed('GET');
    }
}