<?php

use yii\db\Migration;

/**
 * Class m180918_162354_add_fields__game_prizereceiver
 */
class m180918_162354_add_fields__game_prizereceiver extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('game', 'is_active', $this->boolean());
        $this->addColumn('prize_receiver', 'game_id', $this->integer());
        $this->addColumn('prize_receiver', 'created_date', $this->timestamp());
        $this->addColumn('prize_receiver', 'updated_date', $this->timestamp());

        $this->dropColumn('prize_receiver', 'date');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('game', 'is_active');
        $this->dropColumn('prize_receiver', 'game_id');
        $this->dropColumn('prize_receiver', 'created_date');
        $this->dropColumn('prize_receiver', 'updated_date');

        $this->addColumn('prize_receiver', 'date', $this->timestamp());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180918_162354_add_fields__game_prizereceiver cannot be reverted.\n";

        return false;
    }
    */
}
