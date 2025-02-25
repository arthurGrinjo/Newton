<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250224204038 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add date, start and end to TimeSlot.';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE time_slot ADD date DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', ADD start INT NOT NULL, ADD end INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE time_slot DROP date, DROP start, DROP end');
    }
}
