<?php

use yii\db\Migration;

class m170521_135319_map_table extends Migration
{
    public function up()
    {
        $this->execute("
        
        CREATE TABLE \"public\".\"map\" (
            \"id\" serial4 NOT NULL,
            \"name\" varchar NOT NULL,
            \"description\" varchar NOT NULL,
            \"region\" varchar NOT NULL,
            \"latitude\" varchar NOT NULL,
            \"longitude\" varchar NOT NULL,
            PRIMARY KEY (\"id\") NOT DEFERRABLE INITIALLY IMMEDIATE
        )
        WITH (OIDS=FALSE);
        
        ");

    }

    public function down()
    {
        echo "m170521_135319_map_table cannot be reverted.\n";

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
