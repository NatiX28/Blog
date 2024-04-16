<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240416074136 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article ADD image LONGTEXT DEFAULT NULL, DROP description');
        $this->addSql('ALTER TABLE utilisateur DROP etablissement, DROP ville');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article ADD description VARCHAR(255) NOT NULL, DROP image');
        $this->addSql('ALTER TABLE utilisateur ADD etablissement VARCHAR(255) DEFAULT NULL, ADD ville VARCHAR(255) NOT NULL');
    }
}
