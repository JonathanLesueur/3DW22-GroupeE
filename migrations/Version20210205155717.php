<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210205155717 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) DEFAULT NULL, content VARCHAR(2000) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, visible TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message_response (id INT AUTO_INCREMENT NOT NULL, message_base_id_id INT NOT NULL, message_rep_id_id INT NOT NULL, INDEX IDX_375DCFEADBF231A (message_base_id_id), INDEX IDX_375DCFEA62385457 (message_rep_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, firstname VARCHAR(100) NOT NULL, lastname VARCHAR(100) NOT NULL, birthdate DATETIME NOT NULL, identifiant VARCHAR(100) NOT NULL, created_at DATETIME NOT NULL, connected_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE message_response ADD CONSTRAINT FK_375DCFEADBF231A FOREIGN KEY (message_base_id_id) REFERENCES message (id)');
        $this->addSql('ALTER TABLE message_response ADD CONSTRAINT FK_375DCFEA62385457 FOREIGN KEY (message_rep_id_id) REFERENCES message (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message_response DROP FOREIGN KEY FK_375DCFEADBF231A');
        $this->addSql('ALTER TABLE message_response DROP FOREIGN KEY FK_375DCFEA62385457');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE message_response');
        $this->addSql('DROP TABLE `user`');
    }
}
