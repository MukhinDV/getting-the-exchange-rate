<?php


namespace app\models\forms;


use app\models\Currency;
use yii\base\Model;

class CurrencyForm extends Model
{
    public $id;

    /**
     * CurrencyForm constructor.
     *
     * @param $id
     */
    public function __construct($id)
    {
        parent::__construct();
        $this->id = $id;
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['id', 'required'],
            ['id', 'string'],
            ['id', 'trim'],
            ['id', 'checkId']
        ];
    }

    /**
     * Validate rule
     *
     * @return bool
     */
    public function checkId()
    {
        if ($this->getCurrency() == null) {
            $this->addError('id', 'По такому id нет курса');
            return false;
        }

        return true;
    }

    /**
     * @return array
     */
    public function getResult()
    {
        $currency = $this->getCurrency();

        return [
            'id' => $this->id,
            'name' => $currency->name,
            'rate' => $currency->rate,
        ];
    }

    /**Find model
     *
     * @return Currency|null
     */
    private function getCurrency()
    {
        try {
            return Currency::findOne($this->id);
        } catch (\Exception $e) {
            return null;
        }
    }
}