<?php


namespace app\commands;


use app\models\Currency;
use aracoool\uuid\Uuid;
use Yii;
use yii\console\Controller;

class CurrencyController extends Controller
{
    /**Get all currency from cbr.ru
     *
     * @throws \yii\db\Exception
     */
    public function actionUpdateCurrency()
    {
        $xmlResult = simplexml_load_file('http://www.cbr.ru/scripts/XML_daily.asp');

        if (!empty($xmlResult)) {
            Currency::deleteAll();

            foreach ($xmlResult as $currency) {
                Yii::$app->db->createCommand()->insert('currency', [
                    'id' => Uuid::v4(),
                    'name' => $currency->Name,
                    'rate' => $currency->Value,
                    'created_at' => time(),
                    'updated_at' => time(),
                ])->execute();
            }
        }
    }
}