<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250224154612 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Remove property spareparts from brand and remove table.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE brand_spare_part DROP FOREIGN KEY FK_D90FBBE849B7A72');
        $this->addSql('ALTER TABLE brand_spare_part DROP FOREIGN KEY FK_D90FBBE844F5D008');
        $this->addSql('DROP TABLE brand_spare_part');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE brand_spare_part (brand_id INT NOT NULL, spare_part_id INT NOT NULL, INDEX IDX_D90FBBE844F5D008 (brand_id), INDEX IDX_D90FBBE849B7A72 (spare_part_id), PRIMARY KEY(brand_id, spare_part_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE brand_spare_part ADD CONSTRAINT FK_D90FBBE849B7A72 FOREIGN KEY (spare_part_id) REFERENCES spare_part (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE brand_spare_part ADD CONSTRAINT FK_D90FBBE844F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id)');
    }
}
