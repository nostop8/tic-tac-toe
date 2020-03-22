<?php

use yii\db\Migration;

/**
 * Class m200322_220003_game_updates
 */
class m200322_220003_game_updates extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%game}}', 'status', 'ENUM(\'RUNNING\',\'WIN\',\'LOSE\',\'DRAW\') NOT NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%game}}', 'status', 'ENUM(\'RUNNING\',\'WIN\',\'LOSE\') NOT NULL');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200322_220003_game_updates cannot be reverted.\n";

        return false;
    }
    */
}
