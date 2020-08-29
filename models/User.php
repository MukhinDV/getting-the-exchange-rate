<?php

namespace app\models;

use aracoool\uuid\{Uuid, UuidBehavior, UuidValidator};
use yii\behaviors\TimestampBehavior;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property string $id
 * @property string $login Логин
 * @property string $password_hash Пароль
 * @property string $token Токен
 * @property int $created_at Дата создания
 * @property string $updated_at Дата обновления
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    public $password;
    public $repeat_password;

    const SCENARIO_REGISTER = 'Регистрация';
    const SCENARIO_LOGIN = 'Логин';

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class
            ],
            [
                'class' => UuidBehavior::class,
                'version' => Uuid::V4
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], UuidValidator::class],
            [['id'], 'string'],
            [['id', 'password_hash', 'token'], 'unique'],


            [['created_at'], 'default', 'value' => null],
            [['created_at'], 'integer'],

            [['login', 'password_hash', 'token', 'updated_at'], 'string', 'max' => 255],
            [['login', 'password'], 'required'],
            [['login'], 'unique', 'message' => 'Этот логин уже занят', 'on' => self::SCENARIO_REGISTER],
            ['login', 'exist', 'message' => "Такого логина не существует", 'on' => self::SCENARIO_LOGIN],

            ['repeat_password', 'compare', 'compareAttribute' => 'password',
                'message' => 'Пароли не совпадают', 'on' => self::SCENARIO_REGISTER],
            ['repeat_password', 'required', 'on' => self::SCENARIO_REGISTER],
            ['repeat_password', 'compare', 'compareAttribute' => 'password',
                'message' => 'Пароли не совпадают', 'on' => self::SCENARIO_REGISTER],
        ];
    }

    public function beforeSave($insert)
    {
        return parent::beforeSave($insert);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Логин',
            'password_hash' => 'Хэш пароля',
            'token' => 'Токен',
            'password' => 'Пароль',
            'repeat_password' => 'Повторный пароль',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата изменения',
        ];
    }

    /**
     * Finds an identity by the given ID.
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return User::find()->andWhere(['id' => $id])->cache(10)->one();
    }

    /**
     * @return string
     */
    public function getUserName()
    {
        return $this->login;
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface|null the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $user = self::find()->where(['token' => $token])->one();

        if (!empty($user)) {
            return $user;
        }

    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled. The returned key will be stored on the
     * client side as a cookie and will be used to authenticate user even if PHP session has been expired.
     *
     * Make sure to invalidate earlier issued authKeys when you implement force user logout, password change and
     * other scenarios, that require forceful access revocation for old sessions.
     *
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }
}
