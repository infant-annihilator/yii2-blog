<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tag_list}}`.
 */
class m210821_032942_create_tag_list_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('{{%tag_list}}', [
            'id' => $this->primaryKey(),
            'post_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-tag_list-post_id',
            'tag_list',
            'post_id'
        );

        $this->addForeignKey(
            'fk-tag_list-post_id',
            'tag_list',
            'post_id',
            'post',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-tag_list-tag_id',
            'tag_list',
            'tag_id'
        );

        $this->addForeignKey(
            'fk-tag_list-tag_id',
            'tag_list',
            'tag_id',
            'tag',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropForeignKey(
            'fk-tag_list-post_id',
            'post'
        );

        $this->dropIndex(
            'idx-tag_list-post_id',
            'post'
        );

        $this->dropForeignKey(
            'fk-tag_list-post_id',
            'tag'
        );

        $this->dropIndex(
            'idx-tag_list-post_id',
            'tag'
        );
        
        $this->dropTable('{{%tag_list}}');
    }
}
