<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250717134704 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bouteilles (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, region VARCHAR(255) NOT NULL, pays VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, millesime INT NOT NULL, cepage VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE caves (id INT AUTO_INCREMENT NOT NULL, cave_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_1AD0C1607F05B85 (cave_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE caves_bouteilles (caves_id INT NOT NULL, bouteilles_id INT NOT NULL, INDEX IDX_39EBB8C97AA43AD1 (caves_id), INDEX IDX_39EBB8C910E27C1B (bouteilles_id), PRIMARY KEY(caves_id, bouteilles_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaires_bouteilles (id INT AUTO_INCREMENT NOT NULL, bouteille_id INT DEFAULT NULL, user_id INT DEFAULT NULL, reponse_id INT DEFAULT NULL, commentaire LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_F70500DFF1966394 (bouteille_id), INDEX IDX_F70500DFA76ED395 (user_id), INDEX IDX_F70500DFCF18BB82 (reponse_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaires_caves (id INT AUTO_INCREMENT NOT NULL, cave_id INT DEFAULT NULL, user_id INT DEFAULT NULL, reponse_id INT DEFAULT NULL, commentaire LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_8C71AE937F05B85 (cave_id), INDEX IDX_8C71AE93A76ED395 (user_id), INDEX IDX_8C71AE93CF18BB82 (reponse_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notes_bouteilles (id INT AUTO_INCREMENT NOT NULL, bouteille_id INT DEFAULT NULL, user_id INT DEFAULT NULL, note DOUBLE PRECISION NOT NULL, INDEX IDX_3CBC2648F1966394 (bouteille_id), INDEX IDX_3CBC2648A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notes_caves (id INT AUTO_INCREMENT NOT NULL, cave_id INT DEFAULT NULL, user_id INT DEFAULT NULL, note DOUBLE PRECISION NOT NULL, INDEX IDX_802729C07F05B85 (cave_id), INDEX IDX_802729C0A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE caves ADD CONSTRAINT FK_1AD0C1607F05B85 FOREIGN KEY (cave_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE caves_bouteilles ADD CONSTRAINT FK_39EBB8C97AA43AD1 FOREIGN KEY (caves_id) REFERENCES caves (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE caves_bouteilles ADD CONSTRAINT FK_39EBB8C910E27C1B FOREIGN KEY (bouteilles_id) REFERENCES bouteilles (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commentaires_bouteilles ADD CONSTRAINT FK_F70500DFF1966394 FOREIGN KEY (bouteille_id) REFERENCES bouteilles (id)');
        $this->addSql('ALTER TABLE commentaires_bouteilles ADD CONSTRAINT FK_F70500DFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commentaires_bouteilles ADD CONSTRAINT FK_F70500DFCF18BB82 FOREIGN KEY (reponse_id) REFERENCES commentaires_bouteilles (id)');
        $this->addSql('ALTER TABLE commentaires_caves ADD CONSTRAINT FK_8C71AE937F05B85 FOREIGN KEY (cave_id) REFERENCES caves (id)');
        $this->addSql('ALTER TABLE commentaires_caves ADD CONSTRAINT FK_8C71AE93A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commentaires_caves ADD CONSTRAINT FK_8C71AE93CF18BB82 FOREIGN KEY (reponse_id) REFERENCES commentaires_caves (id)');
        $this->addSql('ALTER TABLE notes_bouteilles ADD CONSTRAINT FK_3CBC2648F1966394 FOREIGN KEY (bouteille_id) REFERENCES bouteilles (id)');
        $this->addSql('ALTER TABLE notes_bouteilles ADD CONSTRAINT FK_3CBC2648A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE notes_caves ADD CONSTRAINT FK_802729C07F05B85 FOREIGN KEY (cave_id) REFERENCES caves (id)');
        $this->addSql('ALTER TABLE notes_caves ADD CONSTRAINT FK_802729C0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE caves DROP FOREIGN KEY FK_1AD0C1607F05B85');
        $this->addSql('ALTER TABLE caves_bouteilles DROP FOREIGN KEY FK_39EBB8C97AA43AD1');
        $this->addSql('ALTER TABLE caves_bouteilles DROP FOREIGN KEY FK_39EBB8C910E27C1B');
        $this->addSql('ALTER TABLE commentaires_bouteilles DROP FOREIGN KEY FK_F70500DFF1966394');
        $this->addSql('ALTER TABLE commentaires_bouteilles DROP FOREIGN KEY FK_F70500DFA76ED395');
        $this->addSql('ALTER TABLE commentaires_bouteilles DROP FOREIGN KEY FK_F70500DFCF18BB82');
        $this->addSql('ALTER TABLE commentaires_caves DROP FOREIGN KEY FK_8C71AE937F05B85');
        $this->addSql('ALTER TABLE commentaires_caves DROP FOREIGN KEY FK_8C71AE93A76ED395');
        $this->addSql('ALTER TABLE commentaires_caves DROP FOREIGN KEY FK_8C71AE93CF18BB82');
        $this->addSql('ALTER TABLE notes_bouteilles DROP FOREIGN KEY FK_3CBC2648F1966394');
        $this->addSql('ALTER TABLE notes_bouteilles DROP FOREIGN KEY FK_3CBC2648A76ED395');
        $this->addSql('ALTER TABLE notes_caves DROP FOREIGN KEY FK_802729C07F05B85');
        $this->addSql('ALTER TABLE notes_caves DROP FOREIGN KEY FK_802729C0A76ED395');
        $this->addSql('DROP TABLE bouteilles');
        $this->addSql('DROP TABLE caves');
        $this->addSql('DROP TABLE caves_bouteilles');
        $this->addSql('DROP TABLE commentaires_bouteilles');
        $this->addSql('DROP TABLE commentaires_caves');
        $this->addSql('DROP TABLE notes_bouteilles');
        $this->addSql('DROP TABLE notes_caves');
    }
}
