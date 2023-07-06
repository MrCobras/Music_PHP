<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230706074318 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__song AS SELECT id, name, author FROM song');
        $this->addSql('DROP TABLE song');
        $this->addSql('CREATE TABLE song (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, genre_id INTEGER DEFAULT NULL, name VARCHAR(128) NOT NULL, author VARCHAR(50) DEFAULT NULL, CONSTRAINT FK_33EDEEA14296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO song (id, name, author) SELECT id, name, author FROM __temp__song');
        $this->addSql('DROP TABLE __temp__song');
        $this->addSql('CREATE INDEX IDX_33EDEEA14296D31F ON song (genre_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__song AS SELECT id, name, author FROM song');
        $this->addSql('DROP TABLE song');
        $this->addSql('CREATE TABLE song (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(128) NOT NULL, author VARCHAR(50) DEFAULT NULL)');
        $this->addSql('INSERT INTO song (id, name, author) SELECT id, name, author FROM __temp__song');
        $this->addSql('DROP TABLE __temp__song');
    }
}
