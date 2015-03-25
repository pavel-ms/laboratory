<?php

use yii\db\Schema;
use yii\db\Migration;

class m150325_043429_db_creation extends Migration
{
    public function up()
    {
		// таблица пользователей
		$this->execute('
			CREATE TABLE `user` (
				id INT(11) PRIMARY KEY AUTO_INCREMENT,
				`ts` datetime DEFAULT CURRENT_TIMESTAMP,
				`ts_update` datetime DEFAULT NULL,
				login VARCHAR(255) NOT NULL,
				password VARCHAR(120) NOT NULL,
				token VARCHAR(120) NOT NULL,
				name VARCHAR(120) NOT NULL
            ) ENGINE=InnoDB CHARACTER SET=utf8;
		');

		// Таблица сообщений
		$this->execute('
			CREATE TABLE `message` (
				id INT(11) PRIMARY KEY AUTO_INCREMENT,
				ts datetime DEFAULT CURRENT_TIMESTAMP,
				ts_update datetime DEFAULT NULL,
				text text NOT NULL,
				user_id INT(11),

				CONSTRAINT fk_message_to_user FOREIGN KEY (user_id)
					REFERENCES user(id) ON DELETE CASCADE ON UPDATE CASCADE

            ) ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;
		');
    }

    public function down()
    {
        echo "m150325_043429_db_creation cannot be reverted.\n";

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
