<?php

use app\Entities\Author\Entity\Author;
use app\Entities\User\Entity\User;
use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_author}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 * - `{{%author}}`
 */
class m230630_060050_create_junction_table_for_user_and_author_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_author}}', [
            'user_id' => $this->integer(),
            'author_id' => $this->integer(),
            'PRIMARY KEY(user_id, author_id)',
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-user_author-user_id}}',
            '{{%user_author}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-user_author-user_id}}',
            '{{%user_author}}',
            'user_id',
            User::tableName(),
            'id',
            'CASCADE'
        );

        // creates index for column `author_id`
        $this->createIndex(
            '{{%idx-user_author-author_id}}',
            '{{%user_author}}',
            'author_id'
        );

        // add foreign key for table `{{%author}}`
        $this->addForeignKey(
            '{{%fk-user_author-author_id}}',
            '{{%user_author}}',
            'author_id',
            Author::tableName(),
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-user_author-user_id}}',
            '{{%user_author}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-user_author-user_id}}',
            '{{%user_author}}'
        );

        // drops foreign key for table `{{%author}}`
        $this->dropForeignKey(
            '{{%fk-user_author-author_id}}',
            '{{%user_author}}'
        );

        // drops index for column `author_id`
        $this->dropIndex(
            '{{%idx-user_author-author_id}}',
            '{{%user_author}}'
        );

        $this->dropTable('{{%user_author}}');
    }
}
