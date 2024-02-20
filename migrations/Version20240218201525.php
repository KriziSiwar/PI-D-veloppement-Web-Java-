<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240218201525 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrat DROP FOREIGN KEY FK_603499939D86650F');
        $this->addSql('DROP INDEX IDX_603499939D86650F ON contrat');
        $this->addSql('ALTER TABLE contrat CHANGE user_id_id user_id_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE contrat ADD CONSTRAINT FK_60349993714C3B67 FOREIGN KEY (user_id_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_60349993714C3B67 ON contrat (user_id_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrat DROP FOREIGN KEY FK_60349993714C3B67');
        $this->addSql('DROP INDEX IDX_60349993714C3B67 ON contrat');
        $this->addSql('ALTER TABLE contrat CHANGE user_id_id_id user_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE contrat ADD CONSTRAINT FK_603499939D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_603499939D86650F ON contrat (user_id_id)');
    }
}
