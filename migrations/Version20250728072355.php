<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250728072355 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cepage (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pays (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE region (id INT AUTO_INCREMENT NOT NULL, pays_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, INDEX IDX_F62F176A6E44244 (pays_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE region ADD CONSTRAINT FK_F62F176A6E44244 FOREIGN KEY (pays_id) REFERENCES pays (id)');
        $this->addSql('ALTER TABLE commentaires_bouteilles DROP FOREIGN KEY FK_F70500DFA76ED395');
        $this->addSql('ALTER TABLE commentaires_bouteilles DROP FOREIGN KEY FK_F70500DFCF18BB82');
        $this->addSql('ALTER TABLE commentaires_bouteilles DROP FOREIGN KEY FK_F70500DFF1966394');
        $this->addSql('ALTER TABLE notes_bouteilles DROP FOREIGN KEY FK_3CBC2648A76ED395');
        $this->addSql('ALTER TABLE notes_bouteilles DROP FOREIGN KEY FK_3CBC2648F1966394');
        $this->addSql('ALTER TABLE notes_caves DROP FOREIGN KEY FK_802729C07F05B85');
        $this->addSql('ALTER TABLE notes_caves DROP FOREIGN KEY FK_802729C0A76ED395');
        $this->addSql('DROP TABLE commentaires_bouteilles');
        $this->addSql('DROP TABLE notes_bouteilles');
        $this->addSql('DROP TABLE notes_caves');
        $this->addSql('DROP INDEX unique_bouteille_combo ON bouteilles');
        $this->addSql('ALTER TABLE bouteilles ADD cepage_id INT DEFAULT NULL, ADD type_id INT DEFAULT NULL, ADD pays_id INT DEFAULT NULL, ADD region_id INT DEFAULT NULL, DROP region, DROP pays, DROP type, DROP cepage');
        $this->addSql('ALTER TABLE bouteilles ADD CONSTRAINT FK_6475D7CC8AC6BB8A FOREIGN KEY (cepage_id) REFERENCES cepage (id)');
        $this->addSql('ALTER TABLE bouteilles ADD CONSTRAINT FK_6475D7CCC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE bouteilles ADD CONSTRAINT FK_6475D7CCA6E44244 FOREIGN KEY (pays_id) REFERENCES pays (id)');
        $this->addSql('ALTER TABLE bouteilles ADD CONSTRAINT FK_6475D7CC98260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('CREATE INDEX IDX_6475D7CC8AC6BB8A ON bouteilles (cepage_id)');
        $this->addSql('CREATE INDEX IDX_6475D7CCC54C8C93 ON bouteilles (type_id)');
        $this->addSql('CREATE INDEX IDX_6475D7CCA6E44244 ON bouteilles (pays_id)');
        $this->addSql('CREATE INDEX IDX_6475D7CC98260155 ON bouteilles (region_id)');
        $this->addSql('ALTER TABLE user ADD reset_token VARCHAR(255) DEFAULT NULL, ADD reset_token_expires_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bouteilles DROP FOREIGN KEY FK_6475D7CC8AC6BB8A');
        $this->addSql('ALTER TABLE bouteilles DROP FOREIGN KEY FK_6475D7CCA6E44244');
        $this->addSql('ALTER TABLE bouteilles DROP FOREIGN KEY FK_6475D7CC98260155');
        $this->addSql('ALTER TABLE bouteilles DROP FOREIGN KEY FK_6475D7CCC54C8C93');
        $this->addSql('CREATE TABLE commentaires_bouteilles (id INT AUTO_INCREMENT NOT NULL, bouteille_id INT DEFAULT NULL, user_id INT DEFAULT NULL, reponse_id INT DEFAULT NULL, commentaire LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_F70500DFF1966394 (bouteille_id), INDEX IDX_F70500DFA76ED395 (user_id), INDEX IDX_F70500DFCF18BB82 (reponse_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE notes_bouteilles (id INT AUTO_INCREMENT NOT NULL, bouteille_id INT DEFAULT NULL, user_id INT DEFAULT NULL, note DOUBLE PRECISION NOT NULL, INDEX IDX_3CBC2648F1966394 (bouteille_id), INDEX IDX_3CBC2648A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE notes_caves (id INT AUTO_INCREMENT NOT NULL, cave_id INT DEFAULT NULL, user_id INT DEFAULT NULL, note DOUBLE PRECISION NOT NULL, INDEX IDX_802729C07F05B85 (cave_id), INDEX IDX_802729C0A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE commentaires_bouteilles ADD CONSTRAINT FK_F70500DFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE commentaires_bouteilles ADD CONSTRAINT FK_F70500DFCF18BB82 FOREIGN KEY (reponse_id) REFERENCES commentaires_bouteilles (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE commentaires_bouteilles ADD CONSTRAINT FK_F70500DFF1966394 FOREIGN KEY (bouteille_id) REFERENCES bouteilles (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE notes_bouteilles ADD CONSTRAINT FK_3CBC2648A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE notes_bouteilles ADD CONSTRAINT FK_3CBC2648F1966394 FOREIGN KEY (bouteille_id) REFERENCES bouteilles (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE notes_caves ADD CONSTRAINT FK_802729C07F05B85 FOREIGN KEY (cave_id) REFERENCES caves (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE notes_caves ADD CONSTRAINT FK_802729C0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE region DROP FOREIGN KEY FK_F62F176A6E44244');
        $this->addSql('DROP TABLE cepage');
        $this->addSql('DROP TABLE pays');
        $this->addSql('DROP TABLE region');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP INDEX IDX_6475D7CC8AC6BB8A ON bouteilles');
        $this->addSql('DROP INDEX IDX_6475D7CCC54C8C93 ON bouteilles');
        $this->addSql('DROP INDEX IDX_6475D7CCA6E44244 ON bouteilles');
        $this->addSql('DROP INDEX IDX_6475D7CC98260155 ON bouteilles');
        $this->addSql('ALTER TABLE bouteilles ADD region VARCHAR(255) NOT NULL, ADD pays VARCHAR(255) NOT NULL, ADD type VARCHAR(255) NOT NULL, ADD cepage VARCHAR(255) NOT NULL, DROP cepage_id, DROP type_id, DROP pays_id, DROP region_id');
        $this->addSql('CREATE UNIQUE INDEX unique_bouteille_combo ON bouteilles (nom, millesime, region, cepage)');
        $this->addSql('ALTER TABLE user DROP reset_token, DROP reset_token_expires_at');
    }
}
