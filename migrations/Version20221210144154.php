<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221210144154 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE aircraft_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE aircraft_position_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE ingestor_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_account_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE aircraft (id INT NOT NULL, icao VARCHAR(255) NOT NULL, is_military BOOLEAN NOT NULL, registration VARCHAR(255) DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, manufacturer VARCHAR(255) DEFAULT NULL, model VARCHAR(255) DEFAULT NULL, model_icao VARCHAR(255) DEFAULT NULL, operator VARCHAR(255) DEFAULT NULL, operator_icao VARCHAR(255) DEFAULT NULL, serial VARCHAR(255) DEFAULT NULL, year_build VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE aircraft_position (id INT NOT NULL, position_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, latitude NUMERIC(10, 5) DEFAULT NULL, longitude NUMERIC(10, 5) DEFAULT NULL, track VARCHAR(255) DEFAULT NULL, vertical_rate INT DEFAULT NULL, squawk VARCHAR(255) DEFAULT NULL, on_ground BOOLEAN DEFAULT NULL, callsign VARCHAR(255) DEFAULT NULL, icao VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN aircraft_position.position_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE ingestor (id INT NOT NULL, name VARCHAR(255) NOT NULL, protocol INT NOT NULL, pull_ip VARCHAR(255) DEFAULT NULL, pull_port VARCHAR(255) DEFAULT NULL, push_port VARCHAR(255) DEFAULT NULL, source_type INT NOT NULL, active INT NOT NULL, pending_command VARCHAR(255) DEFAULT NULL, processed_messages INT NOT NULL, total_processed_messages INT NOT NULL, last_message_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN ingestor.last_message_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE user_account (id INT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, is_verified BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_253B48AEF85E0677 ON user_account (username)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SCHEMA topology');
        $this->addSql('CREATE SCHEMA tiger');
        $this->addSql('CREATE SCHEMA tiger_data');
        $this->addSql('DROP SEQUENCE aircraft_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE aircraft_position_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE ingestor_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_account_id_seq CASCADE');
        $this->addSql('DROP TABLE aircraft');
        $this->addSql('DROP TABLE aircraft_position');
        $this->addSql('DROP TABLE ingestor');
        $this->addSql('DROP TABLE user_account');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
