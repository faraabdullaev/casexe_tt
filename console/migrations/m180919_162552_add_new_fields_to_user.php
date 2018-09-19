<?php

use yii\db\Migration;

/**
 * Class m180919_162552_add_new_fields_to_user
 */
class m180919_162552_add_new_fields_to_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'bank_account', $this->string(16));
        $this->addColumn('{{%user}}', 'address', $this->string(100));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%user}}', 'bank_account');
        $this->dropColumn('{{%user}}', 'address');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180919_162552_add_new_fields_to_user cannot be reverted.\n";

        return false;
    }
    */
}
