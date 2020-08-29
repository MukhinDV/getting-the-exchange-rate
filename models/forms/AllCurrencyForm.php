<?php


namespace app\models\forms;


use app\models\Currency;
use yii\data\ActiveDataProvider;

class AllCurrencyForm
{
    /**
     * Get all currency
     *
     * @return ActiveDataProvider
     */
    public function getResult()
    {
        $currency = Currency::find()->select(['id', 'name', 'rate']);

        $provider = new ActiveDataProvider([
            'query' => $currency,
            'pagination' => [
                'pageSize' => 10
            ]
        ]);

        return $provider;
    }
}