<?php

use yii\db\Migration;
use app\Entities\File\Entity\File;
/**
 * Handles the creation of table `{{%book}}`.
 */
class m230628_175734_create_book_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%book}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'year' => $this->string(5),
            'description' => $this->text(),
            'isbn' => $this->float(),
            'file_id' => $this->integer()
        ]);

        $this->createIndex('idx-book-file_id','{{%book}}','file_id');
        $this->addForeignKey('fk-book-file_id','{{%book}}','file_id', File::tableName(),'id', "SET NULL",'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%book}}');
    }
}
