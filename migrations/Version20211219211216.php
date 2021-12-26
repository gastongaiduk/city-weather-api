<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211219211216 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE scale');
        $this->addSql('CREATE TEMPORARY TABLE __temp__city AS SELECT id, name, zip_codes FROM city');
        $this->addSql('DROP TABLE city');
        $this->addSql('CREATE TABLE city (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, zip_codes CLOB DEFAULT NULL)');
        $this->addSql('INSERT INTO city (id, name, zip_codes) SELECT id, name, zip_codes FROM __temp__city');
        $this->addSql('DROP TABLE __temp__city');
        $this->addSql('DROP INDEX IDX_36396FC88BAC62AF');
        $this->addSql('CREATE TEMPORARY TABLE __temp__prediction AS SELECT id, city_id, date, temperatures, created_at FROM prediction');
        $this->addSql('DROP TABLE prediction');
        $this->addSql('CREATE TABLE prediction (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, city_id INTEGER NOT NULL, date DATE NOT NULL, temperatures CLOB NOT NULL COLLATE BINARY --(DC2Type:array)
        , created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_36396FC88BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO prediction (id, city_id, date, temperatures, created_at) SELECT id, city_id, date, temperatures, created_at FROM __temp__prediction');
        $this->addSql('DROP TABLE __temp__prediction');
        $this->addSql('CREATE INDEX IDX_36396FC88BAC62AF ON prediction (city_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE scale (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, ratio_to_celsius DOUBLE PRECISION NOT NULL)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__city AS SELECT id, name, zip_codes FROM city');
        $this->addSql('DROP TABLE city');
        $this->addSql('CREATE TABLE city (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, zip_codes CLOB DEFAULT NULL COLLATE BINARY --(DC2Type:array)
        )');
        $this->addSql('INSERT INTO city (id, name, zip_codes) SELECT id, name, zip_codes FROM __temp__city');
        $this->addSql('DROP TABLE __temp__city');
        $this->addSql('DROP INDEX IDX_36396FC88BAC62AF');
        $this->addSql('CREATE TEMPORARY TABLE __temp__prediction AS SELECT id, city_id, date, temperatures, created_at FROM prediction');
        $this->addSql('DROP TABLE prediction');
        $this->addSql('CREATE TABLE prediction (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, city_id INTEGER NOT NULL, date DATE NOT NULL, temperatures CLOB NOT NULL --(DC2Type:array)
        , created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        )');
        $this->addSql('INSERT INTO prediction (id, city_id, date, temperatures, created_at) SELECT id, city_id, date, temperatures, created_at FROM __temp__prediction');
        $this->addSql('DROP TABLE __temp__prediction');
        $this->addSql('CREATE INDEX IDX_36396FC88BAC62AF ON prediction (city_id)');
    }
}
