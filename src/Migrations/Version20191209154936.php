<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191209154936 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE season RENAME INDEX idx_f0e45ba9e12deda1 TO IDX_F0E45BA93EB8070A');
        $this->addSql('ALTER TABLE episode RENAME INDEX idx_ddaa1cda68756988 TO IDX_DDAA1CDA4EC001D1');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE episode RENAME INDEX idx_ddaa1cda4ec001d1 TO IDX_DDAA1CDA68756988');
        $this->addSql('ALTER TABLE season RENAME INDEX idx_f0e45ba93eb8070a TO IDX_F0E45BA9E12DEDA1');
    }
}
