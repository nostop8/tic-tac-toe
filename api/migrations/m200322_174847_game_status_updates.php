<?php

use yii\db\Migration;

/**
 * Class m200322_174847_game_status_updates
 */
class m200322_174847_game_status_updates extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%game}}', 'status', 'ENUM(\'RUNNING\',\'WIN\',\'LOSE\') NOT NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%game}}', 'status', 'ENUM(\'RUNNING\',\'COMPLETED\') NOT NULL');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200322_174847_game_status_updates cannot be reverted.\n";

        return false;
    }
    */
}
