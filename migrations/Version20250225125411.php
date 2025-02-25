<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250225125411 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE spare_part_brand DROP FOREIGN KEY FK_E02FC5B544F5D008');
        $this->addSql('ALTER TABLE spare_part_brand DROP FOREIGN KEY FK_E02FC5B549B7A72');
        $this->addSql('DROP TABLE spare_part_brand');
        $this->addSql('ALTER TABLE spare_part ADD brand_id INT NOT NULL');
        $this->addSql('ALTER TABLE spare_part ADD CONSTRAINT FK_E3D09D3644F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id)');
        $this->addSql('CREATE INDEX IDX_E3D09D3644F5D008 ON spare_part (brand_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE spare_part_brand (spare_part_id INT NOT NULL, brand_id INT NOT NULL, INDEX IDX_E02FC5B549B7A72 (spare_part_id), INDEX IDX_E02FC5B544F5D008 (brand_id), PRIMARY KEY(spare_part_id, brand_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE spare_part_brand ADD CONSTRAINT FK_E02FC5B544F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE spare_part_brand ADD CONSTRAINT FK_E02FC5B549B7A72 FOREIGN KEY (spare_part_id) REFERENCES spare_part (id)');
        $this->addSql('ALTER TABLE spare_part DROP FOREIGN KEY FK_E3D09D3644F5D008');
        $this->addSql('DROP INDEX IDX_E3D09D3644F5D008 ON spare_part');
        $this->addSql('ALTER TABLE spare_part DROP brand_id');
    }
}
