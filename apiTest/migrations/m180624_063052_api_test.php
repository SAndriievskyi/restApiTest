<?php

namespace backend\modules\apiTest\migrations;

class m180624_063052_api_test extends \yii\db\Migration
{
    public function safeUp()
    {
        $this->createTable('{{test_ref_user}}', [
            'id'    => $this->primaryKey(),
            'login' => $this->string(50),
            'name'  => $this->string(250),
        ]);
        $this->createIndex('ui_ref_user_login', '{{test_ref_user}}', 'login', true);
//        $this->db->getTableSchema($table, true);
        $this->insert('{{test_ref_user}}', [
            'login' => 'test1',
            'name' => 'test1',
        ]);
        $this->insert('{{test_ref_user}}', [
            'login' => 'test2',
            'name' => 'test2',
        ]);

        $this->createTable('{{test_reg_daily_active_user}}', [
            'date_time' => $this->timestamp()->notNull()->defaultExpression('NOW()'),
            'user_id'   => $this->integer(),
        ]);
        $this->addForeignKey('reg_user_id_user_id', '{{test_reg_daily_active_user}}', 'user_id', '{{test_ref_user}}', 'id');
        $this->createIndex('ui_reg_date_time_user_id', '{{test_reg_daily_active_user}}', ['date_time', 'user_id']);
    }

    public function safeDown()
    {
        $this->dropTable('{{test_reg_daily_active_user}}');
        $this->dropTable('{{test_ref_user}}');
    }
}
