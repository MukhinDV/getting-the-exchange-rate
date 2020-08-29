<?php


namespace app\components;


use Yii;
use yii\base\Behavior;

class Response extends Behavior
{
    /**
     * @param $message
     *
     * @return array
     */
    public static function responseError($message)
    {
        Yii::$app->response->statusCode = 400;

        return [
            'status' => 'error',
            'code' => 400,
            'error' => $message
        ];
    }

    /**
     * @param $data
     * @param array|null $static
     *
     * @return array
     */
    public static function succeededWithData($data, array $static = null)
    {
        Yii::$app->response->statusCode = 200;

        if ($static) {
            return [
                'status' => 'success',
                'code' => '200',
                'data' => [
                    $data,
                    [
                        'static' => $static
                    ]
                ]
            ];
        }

        return [
            'status' => 'success',
            'code' => '200',
            'data' => $data
        ];
    }

    /**
     * @param array $errors
     *
     * @return array
     */
    public static function validateErrors(array $errors)
    {
        Yii::$app->response->statusCode = 403;
        $fail = ['status' => 'fail', 'code' => 403, 'fail' => []];
        foreach ($errors as $id => $message) {
            $fail['fail'][] = [
                $id => $message[0]
            ];
        }

        return $fail;
    }

    /**
     * @param $request
     * @return array
     */
    public static function methodNotAllowed($request)
    {
        Yii::$app->response->statusCode = 405;

        return [
            'status' => 'error',
            'code' => 405,
            'error' => 'Этот метод запроса должен быть: ' . $request
        ];
    }
}