<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230707080107 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__song AS SELECT id, genre_id, name FROM song');
        $this->addSql('DROP TABLE song');
        $this->addSql('CREATE TABLE song (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, genre_id INTEGER DEFAULT NULL, name VARCHAR(128) NOT NULL, CONSTRAINT FK_33EDEEA14296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO song (id, genre_id, name) SELECT id, genre_id, name FROM __temp__song');
        $this->addSql('DROP TABLE __temp__song');
        $this->addSql('CREATE INDEX IDX_33EDEEA14296D31F ON song (genre_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        //$this->addSql('CREATE TABLE author (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL)');
        $this->addSql('CREATE INDEX IDX_D702667EA0BDB2F3 ON author_song (song_id)');
        $this->addSql('CREATE INDEX IDX_D702667EF675F31B ON author_song (author_id)');
        $this->addSql('ALTER TABLE song ADD COLUMN author VARCHAR(50) DEFAULT NULL');
    }
}
