<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m200829_073547_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => 'Uuid primary key',
            'login' => $this->string()->notNull()->unique()->comment('Логин'),
            'password_hash' => $this->string()->notNull()->unique()->comment('Пароль'),
            'token' => $this->string()->notNull()->unique()->comment('Токен'),

            'created_at' => $this->integer()->notNull()->comment('Дата создания'),
            'updated_at' => $this->string()->notNull()->comment('Дата обновления'),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
