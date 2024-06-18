<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240423213403 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE actualite (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, date_publication DATE NOT NULL, description VARCHAR(255) NOT NULL, categorie VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE assigned_jobs (id INT AUTO_INCREMENT NOT NULL, no_id INT DEFAULT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_41EB973C1A65C546 (no_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, auteur VARCHAR(255) NOT NULL, commentaire VARCHAR(255) NOT NULL, date_publication DATE NOT NULL, note INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contract_modification (id INT AUTO_INCREMENT NOT NULL, contrat_id INT NOT NULL, field_name VARCHAR(255) NOT NULL, old_value VARCHAR(255) NOT NULL, new_value VARCHAR(255) NOT NULL, timestamp DATETIME NOT NULL, INDEX IDX_AF330061823061F (contrat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contrat (id INT AUTO_INCREMENT NOT NULL, organisation_id INT DEFAULT NULL, user_id INT DEFAULT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, montant INT DEFAULT NULL, statut VARCHAR(255) NOT NULL, projet VARCHAR(255) NOT NULL, freelancer VARCHAR(255) NOT NULL, date_creation DATETIME NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_603499939E6B1585 (organisation_id), INDEX IDX_60349993A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contrat_posted_jobs (contrat_id INT NOT NULL, posted_jobs_id INT NOT NULL, INDEX IDX_F7DF96701823061F (contrat_id), INDEX IDX_F7DF96706023D033 (posted_jobs_id), PRIMARY KEY(contrat_id, posted_jobs_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, price INT NOT NULL, location VARCHAR(255) NOT NULL, statut VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, nb_participant INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE organisation (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, telephone VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, contact VARCHAR(255) DEFAULT NULL, domaine_activite VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE posted_jobs (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, required_skills VARCHAR(255) NOT NULL, budget_estimate INT NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE promotion (id INT AUTO_INCREMENT NOT NULL, event_id INT DEFAULT NULL, qr_code VARCHAR(255) NOT NULL, discount INT NOT NULL, INDEX IDX_C11D7DD171F7E88B (event_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE proposal (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, client VARCHAR(255) NOT NULL, freelancer VARCHAR(255) NOT NULL, budget DOUBLE PRECISION NOT NULL, delai VARCHAR(255) NOT NULL, statut VARCHAR(255) NOT NULL, date_soummission DATE NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, fichiers VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reclamation (id INT AUTO_INCREMENT NOT NULL, objet VARCHAR(255) NOT NULL, contenu VARCHAR(255) NOT NULL, statut VARCHAR(255) NOT NULL, date_reclamation DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, profile_picture VARCHAR(255) DEFAULT NULL, job_title VARCHAR(255) DEFAULT NULL, professional_overview VARCHAR(255) DEFAULT NULL, expertise VARCHAR(255) DEFAULT NULL, phone INT DEFAULT NULL, rate INT DEFAULT NULL, language JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', company_name VARCHAR(255) DEFAULT NULL, company_description VARCHAR(255) DEFAULT NULL, industry VARCHAR(255) DEFAULT NULL, company_website VARCHAR(255) DEFAULT NULL, company_logo VARCHAR(255) DEFAULT NULL, reset_token VARCHAR(255) DEFAULT NULL, last_login DATE DEFAULT NULL, friends_list JSON DEFAULT NULL COMMENT \'(DC2Type:json)\', UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE assigned_jobs ADD CONSTRAINT FK_41EB973C1A65C546 FOREIGN KEY (no_id) REFERENCES contrat (id)');
        $this->addSql('ALTER TABLE contract_modification ADD CONSTRAINT FK_AF330061823061F FOREIGN KEY (contrat_id) REFERENCES contrat (id)');
        $this->addSql('ALTER TABLE contrat ADD CONSTRAINT FK_603499939E6B1585 FOREIGN KEY (organisation_id) REFERENCES organisation (id)');
        $this->addSql('ALTER TABLE contrat ADD CONSTRAINT FK_60349993A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE contrat_posted_jobs ADD CONSTRAINT FK_F7DF96701823061F FOREIGN KEY (contrat_id) REFERENCES contrat (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE contrat_posted_jobs ADD CONSTRAINT FK_F7DF96706023D033 FOREIGN KEY (posted_jobs_id) REFERENCES posted_jobs (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE promotion ADD CONSTRAINT FK_C11D7DD171F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assigned_jobs DROP FOREIGN KEY FK_41EB973C1A65C546');
        $this->addSql('ALTER TABLE contract_modification DROP FOREIGN KEY FK_AF330061823061F');
        $this->addSql('ALTER TABLE contrat DROP FOREIGN KEY FK_603499939E6B1585');
        $this->addSql('ALTER TABLE contrat DROP FOREIGN KEY FK_60349993A76ED395');
        $this->addSql('ALTER TABLE contrat_posted_jobs DROP FOREIGN KEY FK_F7DF96701823061F');
        $this->addSql('ALTER TABLE contrat_posted_jobs DROP FOREIGN KEY FK_F7DF96706023D033');
        $this->addSql('ALTER TABLE promotion DROP FOREIGN KEY FK_C11D7DD171F7E88B');
        $this->addSql('DROP TABLE actualite');
        $this->addSql('DROP TABLE assigned_jobs');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE contract_modification');
        $this->addSql('DROP TABLE contrat');
        $this->addSql('DROP TABLE contrat_posted_jobs');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE organisation');
        $this->addSql('DROP TABLE posted_jobs');
        $this->addSql('DROP TABLE promotion');
        $this->addSql('DROP TABLE proposal');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
