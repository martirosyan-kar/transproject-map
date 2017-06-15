<?php

use yii\db\Migration;

class m170612_041312_status_creation extends Migration
{
    public function up()
    {
        $this->execute("
        ALTER TABLE \"public\".\"map_migration\" 
            ADD COLUMN \"cleaned\" int2 DEFAULT 0,
            ADD COLUMN \"cleaned_image\" varchar;
        ");

        $this->execute("
        COMMENT ON COLUMN \"public\".\"map_migration\".\"cleaned\" IS '0-not cleaned, 1-cleaned';
        ");
    }

    public function down()
    {
        echo "m170612_041312_status_creation cannot be reverted.\n";

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
