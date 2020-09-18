<?php


namespace app\helpers;


use app\models\User;

class UserHelper
{
    /** This method will create new user
     *
     * @param $model User
     *
     * @throws \yii\base\Exception
     * @throws \Exception
     */
    public function createUser($model)
    {
        $model->password_hash = $this->generatePasswordHash($model->password);
        $model->token = \Yii::$app->security->generateRandomString();
        $model->save();

        $this->setUserRoles($model);
    }

    /**
     * This method will set user role
     *
     * @param $model User
     * @throws \Exception
     */
    private function setUserRoles($model)
    {
        $authManager = \Yii::$app->authManager;
        $userRole = $authManager->getRole('user');
        $authManager->assign($userRole, $model->getId());
    }

    /**
     * @param string $login
     *
     * @return object
     */
    private function findModel(string $login): object
    {
        $model = User::findOne(['login' => $login]);

        return $model;
    }

    /**
     * This method makes user authorization
     *
     * @param string $password
     * @param string $login
     *
     * @return bool
     */
    public function authUser(string $password, string $login): bool
    {
        /** @var User $model */
        $model = $this->findModel($login);

        if (!$this->checkPassword($password, $model->password_hash)) {
            return false;
        }

        if (!\Yii::$app->user->login($model, 3600)) {
            return false;
        }

        return true;
    }

    /**
     * Verifies a password against a hash.
     *
     * @param string $password
     * @param string $passwordHash
     *
     * @return bool
     */
    private function checkPassword(string $password, string $passwordHash): bool
    {
        return \Yii::$app->security->validatePassword($password, $passwordHash);
    }

    /**
     * This method generates a secure hash from a password and a random salt
     *
     * @param string $password
     * @return string
     *
     * @throws \yii\base\Exception
     */
    public function generatePasswordHash(string $password): string
    {
        return \Yii::$app->security->generatePasswordHash($password);
    }
}