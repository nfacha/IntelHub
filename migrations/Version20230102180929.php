<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230102180929 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE airport_frequency_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE airport_runway_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE airport_frequency (id INT NOT NULL, airport_id INT NOT NULL, type VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, frequency NUMERIC(10, 3) NOT NULL, external_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_BA4376D8289F53C8 ON airport_frequency (airport_id)');
        $this->addSql('CREATE TABLE airport_runway (id INT NOT NULL, airport_id INT DEFAULT NULL, lenght_ft INT DEFAULT NULL, width_ft INT DEFAULT NULL, surface VARCHAR(255) DEFAULT NULL, lighted BOOLEAN NOT NULL, le_ident VARCHAR(255) DEFAULT NULL, he_ident VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D4C296C2289F53C8 ON airport_runway (airport_id)');
        $this->addSql('ALTER TABLE airport_frequency ADD CONSTRAINT FK_BA4376D8289F53C8 FOREIGN KEY (airport_id) REFERENCES airport (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE airport_runway ADD CONSTRAINT FK_D4C296C2289F53C8 FOREIGN KEY (airport_id) REFERENCES airport (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SCHEMA topology');
        $this->addSql('CREATE SCHEMA tiger');
        $this->addSql('CREATE SCHEMA tiger_data');
        $this->addSql('DROP SEQUENCE airport_frequency_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE airport_runway_id_seq CASCADE');
        $this->addSql('ALTER TABLE airport_frequency DROP CONSTRAINT FK_BA4376D8289F53C8');
        $this->addSql('ALTER TABLE airport_runway DROP CONSTRAINT FK_D4C296C2289F53C8');
        $this->addSql('DROP TABLE airport_frequency');
        $this->addSql('DROP TABLE airport_runway');
    }
}
