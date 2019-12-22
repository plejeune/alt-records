<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191222144441 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article CHANGE modified_at modified_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE tag DROP FOREIGN KEY tag_ibfk_1');
        $this->addSql('DROP INDEX article_id ON tag');
        $this->addSql('ALTER TABLE tag DROP article_id');
        $this->addSql('ALTER TABLE user CHANGE active active VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article CHANGE modified_at modified_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE tag ADD article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tag ADD CONSTRAINT tag_ibfk_1 FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('CREATE INDEX article_id ON tag (article_id)');
        $this->addSql('ALTER TABLE user CHANGE active active VARCHAR(255) DEFAULT \'false\' NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
