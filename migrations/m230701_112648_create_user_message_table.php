<?php

use app\Entities\User\Entity\User;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%message}}`.
 */
class m230701_112648_create_user_message_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_message}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'message' => $this->text(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
            'is_view' => $this->boolean()->defaultValue(false)
        ]);

        $this->createIndex('idx_user_message_user_id','{{%user_message}}','user_id');
        $this->addForeignKey(
            'fk_user_message_to_user',
            '{{%user_message}}',
            'user_id',
            User::tableName(),
            'id',
            'CASCADE',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%message}}');
    }
}
