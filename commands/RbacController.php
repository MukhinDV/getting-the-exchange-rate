<?php

namespace app\commands;

use yii\console\Controller;

class RbacController extends Controller
{
    /**
     * @return \yii\rbac\ManagerInterface
     */
    private function getAuthManager()
    {
        return \Yii::$app->authManager;
    }

    /**
     * @throws \yii\base\Exception
     */
    public function actionInit()
    {
        /** @var \yii\rbac\ManagerInterface $authManager */
        $authManager = $this->getAuthManager();

        /** remove all rules */
        $authManager->removeAll();

        $user = $authManager->createRole('user');
        $authManager->add($user);

        $user_request = $authManager->createPermission('request');
        $user_request->description = 'Отправить запрос';
        $authManager->add($user_request);

        $authManager->addChild($user, $user_request);
    }
}