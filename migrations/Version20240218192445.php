<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240218192445 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrat ADD user_id_id INT NOT NULL, ADD date_creation DATE NOT NULL, ADD description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE contrat ADD CONSTRAINT FK_603499939D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_603499939D86650F ON contrat (user_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrat DROP FOREIGN KEY FK_603499939D86650F');
        $this->addSql('DROP INDEX IDX_603499939D86650F ON contrat');
        $this->addSql('ALTER TABLE contrat DROP user_id_id, DROP date_creation, DROP description');
    }
}
