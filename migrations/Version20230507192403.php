<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230507192403 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE evenement_utilisateur (evenement_id INT NOT NULL, utilisateur_id INT NOT NULL, INDEX IDX_8C897598FD02F13 (evenement_id), INDEX IDX_8C897598FB88E14F (utilisateur_id), PRIMARY KEY(evenement_id, utilisateur_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rating (id INT AUTO_INCREMENT NOT NULL, iduser INT NOT NULL, rating INT NOT NULL, idequipement INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE evenement_utilisateur ADD CONSTRAINT FK_8C897598FD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evenement_utilisateur ADD CONSTRAINT FK_8C897598FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES utilisateur (id)');
        $this->addSql('DROP TABLE calendrier');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE employe DROP age, DROP salaire, DROP numtelephone');
        $this->addSql('ALTER TABLE evenement ADD date DATE NOT NULL, ADD image VARCHAR(255) DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL, DROP date_debut, DROP date_fin, CHANGE description lieu VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE participation DROP nom_utilisateur, DROP telphone');
        $this->addSql('ALTER TABLE produit ADD image VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE terrain DROP image');
        $this->addSql('ALTER TABLE utilisateur ADD roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', ADD is_verified TINYINT(1) NOT NULL, DROP role, CHANGE nom nom VARCHAR(100) NOT NULL, CHANGE prenom prenom VARCHAR(100) NOT NULL, CHANGE email email VARCHAR(180) NOT NULL, CHANGE telephone telephone VARCHAR(20) NOT NULL, CHANGE mdps password VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B3E7927C74 ON utilisateur (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE calendrier (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, start DATETIME NOT NULL, end DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, headers LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, queue_name VARCHAR(190) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E016BA31DB (delivered_at), INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE evenement_utilisateur DROP FOREIGN KEY FK_8C897598FD02F13');
        $this->addSql('ALTER TABLE evenement_utilisateur DROP FOREIGN KEY FK_8C897598FB88E14F');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('DROP TABLE evenement_utilisateur');
        $this->addSql('DROP TABLE rating');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('ALTER TABLE employe ADD age INT NOT NULL, ADD salaire DOUBLE PRECISION NOT NULL, ADD numtelephone INT NOT NULL');
        $this->addSql('ALTER TABLE evenement ADD date_fin DATE NOT NULL, DROP image, DROP updated_at, CHANGE date date_debut DATE NOT NULL, CHANGE lieu description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE participation ADD nom_utilisateur VARCHAR(255) NOT NULL, ADD telphone INT NOT NULL');
        $this->addSql('ALTER TABLE produit DROP image');
        $this->addSql('ALTER TABLE terrain ADD image VARCHAR(500) DEFAULT NULL');
        $this->addSql('DROP INDEX UNIQ_1D1C63B3E7927C74 ON utilisateur');
        $this->addSql('ALTER TABLE utilisateur ADD role INT NOT NULL, DROP roles, DROP is_verified, CHANGE email email VARCHAR(255) NOT NULL, CHANGE nom nom VARCHAR(255) NOT NULL, CHANGE prenom prenom VARCHAR(255) NOT NULL, CHANGE telephone telephone VARCHAR(255) NOT NULL, CHANGE password mdps VARCHAR(255) NOT NULL');
    }
}
