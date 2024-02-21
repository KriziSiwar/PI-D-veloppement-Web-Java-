<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240221204030 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE assigned_jobs_posted_jobs (assigned_jobs_id INT NOT NULL, posted_jobs_id INT NOT NULL, INDEX IDX_945BD43B42E8FEA8 (assigned_jobs_id), INDEX IDX_945BD43B6023D033 (posted_jobs_id), PRIMARY KEY(assigned_jobs_id, posted_jobs_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE assigned_jobs_freelancer (assigned_jobs_id INT NOT NULL, freelancer_id INT NOT NULL, INDEX IDX_7336B69E42E8FEA8 (assigned_jobs_id), INDEX IDX_7336B69E8545BDF5 (freelancer_id), PRIMARY KEY(assigned_jobs_id, freelancer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, start_date DATETIME DEFAULT NULL, end_date DATETIME DEFAULT NULL, price INT NOT NULL, location VARCHAR(255) NOT NULL, statut VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, nb_participant INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE proposal_freelancer (proposal_id INT NOT NULL, freelancer_id INT NOT NULL, INDEX IDX_3E1CE29EF4792058 (proposal_id), INDEX IDX_3E1CE29E8545BDF5 (freelancer_id), PRIMARY KEY(proposal_id, freelancer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE proposal_posted_jobs (proposal_id INT NOT NULL, posted_jobs_id INT NOT NULL, INDEX IDX_9416FE6FF4792058 (proposal_id), INDEX IDX_9416FE6F6023D033 (posted_jobs_id), PRIMARY KEY(proposal_id, posted_jobs_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reclamation_freelancer (reclamation_id INT NOT NULL, freelancer_id INT NOT NULL, INDEX IDX_74FF22B92D6BA2D9 (reclamation_id), INDEX IDX_74FF22B98545BDF5 (freelancer_id), PRIMARY KEY(reclamation_id, freelancer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE assigned_jobs_posted_jobs ADD CONSTRAINT FK_945BD43B42E8FEA8 FOREIGN KEY (assigned_jobs_id) REFERENCES assigned_jobs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE assigned_jobs_posted_jobs ADD CONSTRAINT FK_945BD43B6023D033 FOREIGN KEY (posted_jobs_id) REFERENCES posted_jobs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE assigned_jobs_freelancer ADD CONSTRAINT FK_7336B69E42E8FEA8 FOREIGN KEY (assigned_jobs_id) REFERENCES assigned_jobs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE assigned_jobs_freelancer ADD CONSTRAINT FK_7336B69E8545BDF5 FOREIGN KEY (freelancer_id) REFERENCES freelancer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE proposal_freelancer ADD CONSTRAINT FK_3E1CE29EF4792058 FOREIGN KEY (proposal_id) REFERENCES proposal (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE proposal_freelancer ADD CONSTRAINT FK_3E1CE29E8545BDF5 FOREIGN KEY (freelancer_id) REFERENCES freelancer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE proposal_posted_jobs ADD CONSTRAINT FK_9416FE6FF4792058 FOREIGN KEY (proposal_id) REFERENCES proposal (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE proposal_posted_jobs ADD CONSTRAINT FK_9416FE6F6023D033 FOREIGN KEY (posted_jobs_id) REFERENCES posted_jobs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reclamation_freelancer ADD CONSTRAINT FK_74FF22B92D6BA2D9 FOREIGN KEY (reclamation_id) REFERENCES reclamation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reclamation_freelancer ADD CONSTRAINT FK_74FF22B98545BDF5 FOREIGN KEY (freelancer_id) REFERENCES freelancer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE promotion ADD CONSTRAINT FK_C11D7DD171F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE proposal DROP freelancer, DROP fichiers');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE promotion DROP FOREIGN KEY FK_C11D7DD171F7E88B');
        $this->addSql('ALTER TABLE assigned_jobs_posted_jobs DROP FOREIGN KEY FK_945BD43B42E8FEA8');
        $this->addSql('ALTER TABLE assigned_jobs_posted_jobs DROP FOREIGN KEY FK_945BD43B6023D033');
        $this->addSql('ALTER TABLE assigned_jobs_freelancer DROP FOREIGN KEY FK_7336B69E42E8FEA8');
        $this->addSql('ALTER TABLE assigned_jobs_freelancer DROP FOREIGN KEY FK_7336B69E8545BDF5');
        $this->addSql('ALTER TABLE proposal_freelancer DROP FOREIGN KEY FK_3E1CE29EF4792058');
        $this->addSql('ALTER TABLE proposal_freelancer DROP FOREIGN KEY FK_3E1CE29E8545BDF5');
        $this->addSql('ALTER TABLE proposal_posted_jobs DROP FOREIGN KEY FK_9416FE6FF4792058');
        $this->addSql('ALTER TABLE proposal_posted_jobs DROP FOREIGN KEY FK_9416FE6F6023D033');
        $this->addSql('ALTER TABLE reclamation_freelancer DROP FOREIGN KEY FK_74FF22B92D6BA2D9');
        $this->addSql('ALTER TABLE reclamation_freelancer DROP FOREIGN KEY FK_74FF22B98545BDF5');
        $this->addSql('DROP TABLE assigned_jobs_posted_jobs');
        $this->addSql('DROP TABLE assigned_jobs_freelancer');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE proposal_freelancer');
        $this->addSql('DROP TABLE proposal_posted_jobs');
        $this->addSql('DROP TABLE reclamation_freelancer');
        $this->addSql('ALTER TABLE proposal ADD freelancer VARCHAR(255) NOT NULL, ADD fichiers VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
    }
}
