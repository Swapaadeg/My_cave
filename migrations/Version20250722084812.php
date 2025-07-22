<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250722084812 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bouteilles ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bouteilles ADD CONSTRAINT FK_6475D7CCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_6475D7CCA76ED395 ON bouteilles (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bouteilles DROP FOREIGN KEY FK_6475D7CCA76ED395');
        $this->addSql('DROP INDEX IDX_6475D7CCA76ED395 ON bouteilles');
        $this->addSql('ALTER TABLE bouteilles DROP user_id');
    }
}
