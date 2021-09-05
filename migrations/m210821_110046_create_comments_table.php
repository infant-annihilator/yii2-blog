<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%comments}}`.
 */
class m210821_110046_create_comments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('{{%comments}}', [
            'id' => $this->primaryKey(),
            'text' => $this->text()->notNull(),
            'created_at' => $this->dateTime()->defaultValue(['expression' => 'CURRENT_TIMESTAMP']),
            'post_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
        ]);

        $this->createIndex(
            'idx-comment-post_id',
            'comment',
            'post_id'
        );

        $this->addForeignKey(
            'fk-comment-post_id',
            'comment',
            'post_id',
            'post',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-comment-tag_id',
            'comment',
            'tag_id'
        );

        $this->addForeignKey(
            'fk-comment-tag_id',
            'comment',
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
            'fk-comment-post_id',
            'post'
        );

        $this->dropIndex(
            'idx-comment-post_id',
            'post'
        );

        $this->dropForeignKey(
            'fk-comment-post_id',
            'tag'
        );

        $this->dropIndex(
            'idx-comment-post_id',
            'tag'
        );

        $this->dropTable('{{%comments}}');
    }
}
