<?php

use yii\db\Schema;
use yii\db\Migration;

/**
 * Class m180917_171422_add_tables
 */
class m180917_171422_add_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('game', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull(),
            'start' => $this->timestamp(),
            'end' => $this->timestamp(),
            'conversion_rate' => $this->float(),
            'money_balance' => $this->integer(),
            'money_from' => $this->integer(),
            'money_to' => $this->integer(),
            'bonus_from' => $this->integer(),
            'bonus_to' => $this->integer(),
            'money_share' => $this->integer(),
            'gift_share' => $this->integer(),
            'bonus_share' => $this->integer(),
        ]);

        $this->createTable('gift', [
            'id' => $this->primaryKey(),
            'game_id' => $this->integer()->notNull(),
            'name' => $this->string(100)->notNull(),
            'count' => $this->integer()->notNull(),
        ]);

        $this->createTable('loyalty_card', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'balance' => $this->string(100)->notNull(),
        ]);

        $this->createTable('prize_receiver', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'prize_type' => $this->smallInteger()->notNull(),
            'prize_value' => $this->integer(),
            'prize_status' => $this->smallInteger(),
            'date' => $this->timestamp(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('game');
        $this->dropTable('gift');
        $this->dropTable('loyalty_card');
        $this->dropTable('prize_receiver');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180917_171422_add_tables cannot be reverted.\n";

        return false;
    }
    */
}
