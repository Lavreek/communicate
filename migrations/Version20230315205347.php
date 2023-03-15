<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230315205347 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE attachments (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dialogue (id INT AUTO_INCREMENT NOT NULL, user_initiator INT NOT NULL, user_participant INT NOT NULL, last_message DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messages (id INT AUTO_INCREMENT NOT NULL, user_sender INT NOT NULL, message LONGTEXT NOT NULL, dialogue_id INT NOT NULL, attachment_id INT DEFAULT NULL, send_time DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_info (id INT AUTO_INCREMENT NOT NULL, bio VARCHAR(255) DEFAULT NULL, birthday DATE DEFAULT NULL, attachment_id INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user CHANGE username username VARCHAR(180) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE attachments');
        $this->addSql('DROP TABLE dialogue');
        $this->addSql('DROP TABLE messages');
        $this->addSql('DROP TABLE user_info');
        $this->addSql('ALTER TABLE `user` CHANGE username username VARCHAR(180) NOT NULL');
    }
}
