<?php

use yii\db\Migration;

/**
 * Class m200322_154622_game_board_length_fix
 */
class m200322_154622_game_board_length_fix extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('{{%game}}', 'board', 'VARCHAR(9) NOT NULL');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('{{%game}}', 'board', 'VARCHAR(11) NOT NULL');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200322_154622_game_board_length_fix cannot be reverted.\n";

        return false;
    }
    */
}
