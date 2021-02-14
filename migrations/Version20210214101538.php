<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210214101538 extends AbstractMigration
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
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, title VARCHAR(255) DEFAULT NULL, content VARCHAR(2000) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, visible TINYINT(1) NOT NULL, INDEX IDX_B6BD307FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message_response (id INT AUTO_INCREMENT NOT NULL, message_base_id_id INT NOT NULL, message_rep_id_id INT NOT NULL, INDEX IDX_375DCFEADBF231A (message_base_id_id), INDEX IDX_375DCFEA62385457 (message_rep_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE report (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, message_id INT NOT NULL, reported_at DATETIME NOT NULL, reason VARCHAR(255) NOT NULL, INDEX IDX_C42F7784A76ED395 (user_id), INDEX IDX_C42F7784537A1329 (message_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, firstname VARCHAR(100) NOT NULL, lastname VARCHAR(100) NOT NULL, birthdate DATETIME NOT NULL, identifiant VARCHAR(100) NOT NULL, created_at DATETIME NOT NULL, connected_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dislike ADD CONSTRAINT FK_FE3BECAA9D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE dislike ADD CONSTRAINT FK_FE3BECAA80E261BC FOREIGN KEY (message_id_id) REFERENCES message (id)');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B39D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B380E261BC FOREIGN KEY (message_id_id) REFERENCES message (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE message_response ADD CONSTRAINT FK_375DCFEADBF231A FOREIGN KEY (message_base_id_id) REFERENCES message (id)');
        $this->addSql('ALTER TABLE message_response ADD CONSTRAINT FK_375DCFEA62385457 FOREIGN KEY (message_rep_id_id) REFERENCES message (id)');
        $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F7784A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE report ADD CONSTRAINT FK_C42F7784537A1329 FOREIGN KEY (message_id) REFERENCES message (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dislike DROP FOREIGN KEY FK_FE3BECAA80E261BC');
        $this->addSql('ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B380E261BC');
        $this->addSql('ALTER TABLE message_response DROP FOREIGN KEY FK_375DCFEADBF231A');
        $this->addSql('ALTER TABLE message_response DROP FOREIGN KEY FK_375DCFEA62385457');
        $this->addSql('ALTER TABLE report DROP FOREIGN KEY FK_C42F7784537A1329');
        $this->addSql('ALTER TABLE dislike DROP FOREIGN KEY FK_FE3BECAA9D86650F');
        $this->addSql('ALTER TABLE `like` DROP FOREIGN KEY FK_AC6340B39D86650F');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FA76ED395');
        $this->addSql('ALTER TABLE report DROP FOREIGN KEY FK_C42F7784A76ED395');
        $this->addSql('DROP TABLE dislike');
        $this->addSql('DROP TABLE `like`');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE message_response');
        $this->addSql('DROP TABLE report');
        $this->addSql('DROP TABLE `user`');
    }
}
