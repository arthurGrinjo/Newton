<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250224150618 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add duraction to job and price to sparepart.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE maintenance_job ADD duration INT NOT NULL');
        $this->addSql('ALTER TABLE spare_part ADD price INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE maintenance_job DROP duration');
        $this->addSql('ALTER TABLE spare_part DROP price');
    }
}
