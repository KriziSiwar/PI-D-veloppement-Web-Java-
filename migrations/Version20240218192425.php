<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240218192425 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE contrat_posted_jobs (contrat_id INT NOT NULL, posted_jobs_id INT NOT NULL, INDEX IDX_F7DF96701823061F (contrat_id), INDEX IDX_F7DF96706023D033 (posted_jobs_id), PRIMARY KEY(contrat_id, posted_jobs_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contrat_posted_jobs ADD CONSTRAINT FK_F7DF96701823061F FOREIGN KEY (contrat_id) REFERENCES contrat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contrat_posted_jobs ADD CONSTRAINT FK_F7DF96706023D033 FOREIGN KEY (posted_jobs_id) REFERENCES posted_jobs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE assigned_jobs ADD no_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE assigned_jobs ADD CONSTRAINT FK_41EB973C1A65C546 FOREIGN KEY (no_id) REFERENCES contrat (id)');
        $this->addSql('CREATE INDEX IDX_41EB973C1A65C546 ON assigned_jobs (no_id)');
        $this->addSql('ALTER TABLE contrat ADD user_id_id INT NOT NULL, ADD date_creation DATE NOT NULL, ADD description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE contrat ADD CONSTRAINT FK_603499939D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_603499939D86650F ON contrat (user_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrat_posted_jobs DROP FOREIGN KEY FK_F7DF96701823061F');
        $this->addSql('ALTER TABLE contrat_posted_jobs DROP FOREIGN KEY FK_F7DF96706023D033');
        $this->addSql('DROP TABLE contrat_posted_jobs');
        $this->addSql('ALTER TABLE assigned_jobs DROP FOREIGN KEY FK_41EB973C1A65C546');
        $this->addSql('DROP INDEX IDX_41EB973C1A65C546 ON assigned_jobs');
        $this->addSql('ALTER TABLE assigned_jobs DROP no_id');
        $this->addSql('ALTER TABLE contrat DROP FOREIGN KEY FK_603499939D86650F');
        $this->addSql('DROP INDEX IDX_603499939D86650F ON contrat');
        $this->addSql('ALTER TABLE contrat DROP user_id_id, DROP date_creation, DROP description');
    }
}
