<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240305150523 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contract_modification ADD contrat_id INT NOT NULL, CHANGE timestamp timestamp DATETIME NOT NULL');
        $this->addSql('ALTER TABLE contract_modification ADD CONSTRAINT FK_AF330061823061F FOREIGN KEY (contrat_id) REFERENCES contrat (id)');
        $this->addSql('CREATE INDEX IDX_AF330061823061F ON contract_modification (contrat_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contract_modification DROP FOREIGN KEY FK_AF330061823061F');
        $this->addSql('DROP INDEX IDX_AF330061823061F ON contract_modification');
        $this->addSql('ALTER TABLE contract_modification DROP contrat_id, CHANGE timestamp timestamp VARCHAR(255) NOT NULL');
    }
}
