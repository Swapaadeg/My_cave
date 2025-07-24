<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250724140959 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaires_bouteilles DROP FOREIGN KEY FK_F70500DFA76ED395');
        $this->addSql('ALTER TABLE commentaires_bouteilles DROP FOREIGN KEY FK_F70500DFCF18BB82');
        $this->addSql('ALTER TABLE commentaires_bouteilles DROP FOREIGN KEY FK_F70500DFF1966394');
        $this->addSql('ALTER TABLE notes_caves DROP FOREIGN KEY FK_802729C07F05B85');
        $this->addSql('ALTER TABLE notes_caves DROP FOREIGN KEY FK_802729C0A76ED395');
        $this->addSql('ALTER TABLE notes_bouteilles DROP FOREIGN KEY FK_3CBC2648A76ED395');
        $this->addSql('ALTER TABLE notes_bouteilles DROP FOREIGN KEY FK_3CBC2648F1966394');
        $this->addSql('DROP TABLE commentaires_bouteilles');
        $this->addSql('DROP TABLE notes_caves');
        $this->addSql('DROP TABLE notes_bouteilles');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commentaires_bouteilles (id INT AUTO_INCREMENT NOT NULL, bouteille_id INT DEFAULT NULL, user_id INT DEFAULT NULL, reponse_id INT DEFAULT NULL, commentaire LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_F70500DFF1966394 (bouteille_id), INDEX IDX_F70500DFA76ED395 (user_id), INDEX IDX_F70500DFCF18BB82 (reponse_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE notes_caves (id INT AUTO_INCREMENT NOT NULL, cave_id INT DEFAULT NULL, user_id INT DEFAULT NULL, note DOUBLE PRECISION NOT NULL, INDEX IDX_802729C07F05B85 (cave_id), INDEX IDX_802729C0A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE notes_bouteilles (id INT AUTO_INCREMENT NOT NULL, bouteille_id INT DEFAULT NULL, user_id INT DEFAULT NULL, note DOUBLE PRECISION NOT NULL, INDEX IDX_3CBC2648F1966394 (bouteille_id), INDEX IDX_3CBC2648A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE commentaires_bouteilles ADD CONSTRAINT FK_F70500DFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE commentaires_bouteilles ADD CONSTRAINT FK_F70500DFCF18BB82 FOREIGN KEY (reponse_id) REFERENCES commentaires_bouteilles (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE commentaires_bouteilles ADD CONSTRAINT FK_F70500DFF1966394 FOREIGN KEY (bouteille_id) REFERENCES bouteilles (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE notes_caves ADD CONSTRAINT FK_802729C07F05B85 FOREIGN KEY (cave_id) REFERENCES caves (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE notes_caves ADD CONSTRAINT FK_802729C0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE notes_bouteilles ADD CONSTRAINT FK_3CBC2648A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE notes_bouteilles ADD CONSTRAINT FK_3CBC2648F1966394 FOREIGN KEY (bouteille_id) REFERENCES bouteilles (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
