<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240218202035 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrat DROP FOREIGN KEY FK_603499936C6A4201');
        $this->addSql('ALTER TABLE contrat DROP FOREIGN KEY FK_60349993714C3B67');
        $this->addSql('DROP INDEX IDX_603499936C6A4201 ON contrat');
        $this->addSql('DROP INDEX IDX_60349993714C3B67 ON contrat');
        $this->addSql('ALTER TABLE contrat CHANGE organisation_id_id organisation_id INT DEFAULT NULL, CHANGE user_id_id_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE contrat ADD CONSTRAINT FK_603499939E6B1585 FOREIGN KEY (organisation_id) REFERENCES organisation (id)');
        $this->addSql('ALTER TABLE contrat ADD CONSTRAINT FK_60349993A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_603499939E6B1585 ON contrat (organisation_id)');
        $this->addSql('CREATE INDEX IDX_60349993A76ED395 ON contrat (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrat DROP FOREIGN KEY FK_603499939E6B1585');
        $this->addSql('ALTER TABLE contrat DROP FOREIGN KEY FK_60349993A76ED395');
        $this->addSql('DROP INDEX IDX_603499939E6B1585 ON contrat');
        $this->addSql('DROP INDEX IDX_60349993A76ED395 ON contrat');
        $this->addSql('ALTER TABLE contrat CHANGE organisation_id organisation_id_id INT DEFAULT NULL, CHANGE user_id user_id_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE contrat ADD CONSTRAINT FK_603499936C6A4201 FOREIGN KEY (organisation_id_id) REFERENCES organisation (id)');
        $this->addSql('ALTER TABLE contrat ADD CONSTRAINT FK_60349993714C3B67 FOREIGN KEY (user_id_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_603499936C6A4201 ON contrat (organisation_id_id)');
        $this->addSql('CREATE INDEX IDX_60349993714C3B67 ON contrat (user_id_id_id)');
    }
}
