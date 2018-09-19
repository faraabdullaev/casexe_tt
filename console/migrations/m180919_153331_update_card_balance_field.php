<?php

use yii\db\Migration;

/**
 * Class m180919_153331_update_card_balance_field
 */
class m180919_153331_update_card_balance_field extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('loyalty_card', 'balance', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('loyalty_card', 'balance', $this->string(100));
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180919_153331_update_card_balance_field cannot be reverted.\n";

        return false;
    }
    */
}
