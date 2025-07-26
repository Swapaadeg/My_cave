<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250725152553 extends AbstractMigration
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
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bouteilles DROP FOREIGN KEY FK_6475D7CC8AC6BB8A');
        $this->addSql('ALTER TABLE bouteilles DROP FOREIGN KEY FK_6475D7CCA6E44244');
        $this->addSql('ALTER TABLE bouteilles DROP FOREIGN KEY FK_6475D7CC98260155');
        $this->addSql('ALTER TABLE bouteilles DROP FOREIGN KEY FK_6475D7CCC54C8C93');
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
    }
}
