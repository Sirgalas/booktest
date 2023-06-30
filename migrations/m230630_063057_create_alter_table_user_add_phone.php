<?php

use app\Entities\User\Entity\User;
use yii\db\Migration;

/**
 * Class m230630_063057_create_alter_table_user_add_phone
 */
class m230630_063057_create_alter_table_user_add_phone extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(User::tableName(),'phone',$this->string(20));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(User::tableName(),'phone');
    }

}
