<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210205160051 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dislike (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, message_id_id INT DEFAULT NULL, disliked_at DATETIME NOT NULL, INDEX IDX_FE3BECAA9D86650F (user_id_id), INDEX IDX_FE3BECAA80E261BC (message_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `like` (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, message_id_id INT DEFAULT NULL, liked_at DATETIME NOT NULL, INDEX IDX_AC6340B39D86650F (user_id_id), INDEX IDX_AC6340B380E261BC (message_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dislike ADD CONSTRAINT FK_FE3BECAA9D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE dislike ADD CONSTRAINT FK_FE3BECAA80E261BC FOREIGN KEY (message_id_id) REFERENCES message (id)');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B39D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B380E261BC FOREIGN KEY (message_id_id) REFERENCES message (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE dislike');
        $this->addSql('DROP TABLE `like`');
    }
}
