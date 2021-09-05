<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%post}}`.
 */
class m210821_032856_create_post_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('{{%post}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'text' => $this->text()->notNull(),
            'img' => $this->text(),
            'created_at' => $this->dateTime()->defaultValue(['expression' => 'CURRENT_TIMESTAMP']),
            'user_id' => $this->integer()->notNull(),
        ]);

        // creates index for column `author_id`
        $this->createIndex(
            'idx-post-user_id',
            'post',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-post-user_id',
            'post',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-post-user_id',
            'post'
        );

        // drops index for column `author_id`
        $this->dropIndex(
            'idx-post-user_id',
            'post'
        );
        $this->dropTable('{{%post}}');
    }
}
