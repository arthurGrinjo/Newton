<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250223135402 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE brand ADD name VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE car ADD name VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E09C3C6F69F');
        $this->addSql('DROP INDEX IDX_81398E09C3C6F69F ON customer');
        $this->addSql('ALTER TABLE customer ADD name VARCHAR(100) NOT NULL, DROP car_id');
        $this->addSql('ALTER TABLE engineer ADD name VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE model DROP FOREIGN KEY FK_D79572D9C3C6F69F');
        $this->addSql('DROP INDEX IDX_D79572D9C3C6F69F ON model');
        $this->addSql('ALTER TABLE model ADD name VARCHAR(100) NOT NULL, DROP car_id');
        $this->addSql('ALTER TABLE spare_part ADD name VARCHAR(100) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE brand DROP name');
        $this->addSql('ALTER TABLE engineer DROP name');
        $this->addSql('ALTER TABLE spare_part DROP name');
        $this->addSql('ALTER TABLE car DROP name');
        $this->addSql('ALTER TABLE customer ADD car_id INT NOT NULL, DROP name');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id)');
        $this->addSql('CREATE INDEX IDX_81398E09C3C6F69F ON customer (car_id)');
        $this->addSql('ALTER TABLE model ADD car_id INT DEFAULT NULL, DROP name');
        $this->addSql('ALTER TABLE model ADD CONSTRAINT FK_D79572D9C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id)');
        $this->addSql('CREATE INDEX IDX_D79572D9C3C6F69F ON model (car_id)');
    }
}
