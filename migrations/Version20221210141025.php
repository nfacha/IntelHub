<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221210141025 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE aircraft DROP CONSTRAINT fk_13d967299db2514a');
        $this->addSql('DROP INDEX uniq_13d967299db2514a');
        $this->addSql('ALTER TABLE aircraft DROP last_position_id');
        $this->addSql('ALTER TABLE aircraft_position ADD icao VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SCHEMA topology');
        $this->addSql('CREATE SCHEMA tiger');
        $this->addSql('CREATE SCHEMA tiger_data');
        $this->addSql('ALTER TABLE aircraft ADD last_position_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE aircraft ADD CONSTRAINT fk_13d967299db2514a FOREIGN KEY (last_position_id) REFERENCES aircraft_position (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_13d967299db2514a ON aircraft (last_position_id)');
        $this->addSql('ALTER TABLE aircraft_position DROP icao');
    }
}
