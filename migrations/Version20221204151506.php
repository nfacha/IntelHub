<?php

declare( strict_types=1 );

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221204151506 extends AbstractMigration {
	public function getDescription(): string {
		return '';
	}

	public function up( Schema $schema ): void {
		// this up() migration is auto-generated, please modify it to your needs
		$this->addSql( 'CREATE TABLE aircraft (id INT AUTO_INCREMENT NOT NULL, last_position_id INT DEFAULT NULL, icao VARCHAR(255) NOT NULL, is_military TINYINT(1) NOT NULL, registration VARCHAR(255) DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, manufacturer VARCHAR(255) DEFAULT NULL, model VARCHAR(255) DEFAULT NULL, model_icao VARCHAR(255) DEFAULT NULL, operator VARCHAR(255) DEFAULT NULL, operator_icao VARCHAR(255) DEFAULT NULL, serial VARCHAR(255) DEFAULT NULL, year_build VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_13D967299DB2514A (last_position_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB' );
		$this->addSql( 'CREATE TABLE aircraft_position (id INT AUTO_INCREMENT NOT NULL, position_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', latitude NUMERIC(10, 5) DEFAULT NULL, longitude NUMERIC(10, 5) DEFAULT NULL, track VARCHAR(255) DEFAULT NULL, vertical_rate INT DEFAULT NULL, squawk VARCHAR(255) DEFAULT NULL, on_ground TINYINT(1) DEFAULT NULL, callsign VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB' );
		$this->addSql( 'ALTER TABLE aircraft ADD CONSTRAINT FK_13D967299DB2514A FOREIGN KEY (last_position_id) REFERENCES aircraft_position (id)' );
	}

	public function down( Schema $schema ): void {
		// this down() migration is auto-generated, please modify it to your needs
		$this->addSql( 'ALTER TABLE aircraft DROP FOREIGN KEY FK_13D967299DB2514A' );
		$this->addSql( 'DROP TABLE aircraft' );
		$this->addSql( 'DROP TABLE aircraft_position' );
	}
}
