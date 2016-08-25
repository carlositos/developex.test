<?php

use yii\db\Migration;

class m160825_071558_init extends Migration
{
    public function up()
    {
        $this->execute("
        CREATE TABLE IF NOT EXISTS `cache` (
        `id` char(128) NOT NULL,
          `expire` int(11) DEFAULT NULL,
          `data` blob,
          PRIMARY KEY (`id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
        
        
        CREATE TABLE IF NOT EXISTS `items` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
          `title` varchar(255) DEFAULT NULL,
          `updated_at` int(11) NOT NULL,
          PRIMARY KEY (`id`),
          KEY `id` (`id`)
        ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=59;");
    }

    public function down()
    {
        echo "m160825_071558_init cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
