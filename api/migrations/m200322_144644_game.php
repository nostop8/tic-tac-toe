<?php

use yii\db\Migration;

/**
 * Class m200322_144644_game
 */
class m200322_144644_game extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tables = Yii::$app->db->schema->getTableNames();
        $dbType = $this->db->driverName;
        $tableOptions_mysql = "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB";
        $tableOptions_mssql = "";
        $tableOptions_pgsql = "";
        $tableOptions_sqlite = "";
        /* MYSQL */
        if (!in_array('game', $tables)) {
            if ($dbType == "mysql") {
                $this->createTable('{{%game}}', [
                    'id' => 'VARCHAR(36) NOT NULL',
                    0 => 'PRIMARY KEY (`id`)',
                    'board' => 'VARCHAR(11) NOT NULL',
                    'status' => 'ENUM(\'RUNNING\',\'COMPLETED\') NOT NULL',
                ], $tableOptions_mysql);
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('SET foreign_key_checks = 0');
        $this->execute('DROP TABLE IF EXISTS `game`');
        $this->execute('SET foreign_key_checks = 1;');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200322_144644_game cannot be reverted.\n";

        return false;
    }
    */
}
