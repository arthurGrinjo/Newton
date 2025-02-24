<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250223152243 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE brand (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_1C52F958D17F50A6 (uuid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE brand_spare_part (brand_id INT NOT NULL, spare_part_id INT NOT NULL, INDEX IDX_D90FBBE844F5D008 (brand_id), INDEX IDX_D90FBBE849B7A72 (spare_part_id), PRIMARY KEY(brand_id, spare_part_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car (id INT AUTO_INCREMENT NOT NULL, customer_id INT NOT NULL, model_id INT NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_773DE69DD17F50A6 (uuid), INDEX IDX_773DE69D9395C3F3 (customer_id), INDEX IDX_773DE69D7975B7E7 (model_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_81398E09D17F50A6 (uuid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE engineer (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_94176AD9D17F50A6 (uuid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE maintenance_job (id INT AUTO_INCREMENT NOT NULL, task VARCHAR(100) NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_522DB5CED17F50A6 (uuid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE maintenance_job_spare_part (maintenance_job_id INT NOT NULL, spare_part_id INT NOT NULL, INDEX IDX_7F26BB0A211D78A0 (maintenance_job_id), INDEX IDX_7F26BB0A49B7A72 (spare_part_id), PRIMARY KEY(maintenance_job_id, spare_part_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE model (id INT AUTO_INCREMENT NOT NULL, brand_id INT NOT NULL, name VARCHAR(100) NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_D79572D9D17F50A6 (uuid), INDEX IDX_D79572D944F5D008 (brand_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE scheduled_maintenance_job (id INT AUTO_INCREMENT NOT NULL, engineer_id INT NOT NULL, maintenance_job_id INT NOT NULL, time_slot_id INT NOT NULL, car_id INT DEFAULT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_DFA05AD5D17F50A6 (uuid), INDEX IDX_DFA05AD5F8D8CDF1 (engineer_id), INDEX IDX_DFA05AD5211D78A0 (maintenance_job_id), INDEX IDX_DFA05AD5D62B0FA (time_slot_id), INDEX IDX_DFA05AD5C3C6F69F (car_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE spare_part (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_E3D09D36D17F50A6 (uuid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE spare_part_brand (spare_part_id INT NOT NULL, brand_id INT NOT NULL, INDEX IDX_E02FC5B549B7A72 (spare_part_id), INDEX IDX_E02FC5B544F5D008 (brand_id), PRIMARY KEY(spare_part_id, brand_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE time_slot (id INT AUTO_INCREMENT NOT NULL, uuid BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_1B3294AD17F50A6 (uuid), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE brand_spare_part ADD CONSTRAINT FK_D90FBBE844F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id)');
        $this->addSql('ALTER TABLE brand_spare_part ADD CONSTRAINT FK_D90FBBE849B7A72 FOREIGN KEY (spare_part_id) REFERENCES spare_part (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE car ADD CONSTRAINT FK_773DE69D7975B7E7 FOREIGN KEY (model_id) REFERENCES model (id)');
        $this->addSql('ALTER TABLE maintenance_job_spare_part ADD CONSTRAINT FK_7F26BB0A211D78A0 FOREIGN KEY (maintenance_job_id) REFERENCES maintenance_job (id)');
        $this->addSql('ALTER TABLE maintenance_job_spare_part ADD CONSTRAINT FK_7F26BB0A49B7A72 FOREIGN KEY (spare_part_id) REFERENCES spare_part (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE model ADD CONSTRAINT FK_D79572D944F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id)');
        $this->addSql('ALTER TABLE scheduled_maintenance_job ADD CONSTRAINT FK_DFA05AD5F8D8CDF1 FOREIGN KEY (engineer_id) REFERENCES engineer (id)');
        $this->addSql('ALTER TABLE scheduled_maintenance_job ADD CONSTRAINT FK_DFA05AD5211D78A0 FOREIGN KEY (maintenance_job_id) REFERENCES maintenance_job (id)');
        $this->addSql('ALTER TABLE scheduled_maintenance_job ADD CONSTRAINT FK_DFA05AD5D62B0FA FOREIGN KEY (time_slot_id) REFERENCES time_slot (id)');
        $this->addSql('ALTER TABLE scheduled_maintenance_job ADD CONSTRAINT FK_DFA05AD5C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id)');
        $this->addSql('ALTER TABLE spare_part_brand ADD CONSTRAINT FK_E02FC5B549B7A72 FOREIGN KEY (spare_part_id) REFERENCES spare_part (id)');
        $this->addSql('ALTER TABLE spare_part_brand ADD CONSTRAINT FK_E02FC5B544F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE brand_spare_part DROP FOREIGN KEY FK_D90FBBE844F5D008');
        $this->addSql('ALTER TABLE brand_spare_part DROP FOREIGN KEY FK_D90FBBE849B7A72');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D9395C3F3');
        $this->addSql('ALTER TABLE car DROP FOREIGN KEY FK_773DE69D7975B7E7');
        $this->addSql('ALTER TABLE maintenance_job_spare_part DROP FOREIGN KEY FK_7F26BB0A211D78A0');
        $this->addSql('ALTER TABLE maintenance_job_spare_part DROP FOREIGN KEY FK_7F26BB0A49B7A72');
        $this->addSql('ALTER TABLE model DROP FOREIGN KEY FK_D79572D944F5D008');
        $this->addSql('ALTER TABLE scheduled_maintenance_job DROP FOREIGN KEY FK_DFA05AD5F8D8CDF1');
        $this->addSql('ALTER TABLE scheduled_maintenance_job DROP FOREIGN KEY FK_DFA05AD5211D78A0');
        $this->addSql('ALTER TABLE scheduled_maintenance_job DROP FOREIGN KEY FK_DFA05AD5D62B0FA');
        $this->addSql('ALTER TABLE scheduled_maintenance_job DROP FOREIGN KEY FK_DFA05AD5C3C6F69F');
        $this->addSql('ALTER TABLE spare_part_brand DROP FOREIGN KEY FK_E02FC5B549B7A72');
        $this->addSql('ALTER TABLE spare_part_brand DROP FOREIGN KEY FK_E02FC5B544F5D008');
        $this->addSql('DROP TABLE brand');
        $this->addSql('DROP TABLE brand_spare_part');
        $this->addSql('DROP TABLE car');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE engineer');
        $this->addSql('DROP TABLE maintenance_job');
        $this->addSql('DROP TABLE maintenance_job_spare_part');
        $this->addSql('DROP TABLE model');
        $this->addSql('DROP TABLE scheduled_maintenance_job');
        $this->addSql('DROP TABLE spare_part');
        $this->addSql('DROP TABLE spare_part_brand');
        $this->addSql('DROP TABLE time_slot');
    }
}
