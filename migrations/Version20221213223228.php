<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221213223228 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE carte_invitation (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, prix VARCHAR(255) NOT NULL, photo VARCHAR(255) NOT NULL, decription VARCHAR(255) NOT NULL, INDEX IDX_3F9BB6FFA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE centres_mariages (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, prix VARCHAR(255) NOT NULL, photo VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, pack VARCHAR(255) NOT NULL, INDEX IDX_428469B4A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE carte_invitation ADD CONSTRAINT FK_3F9BB6FFA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE centres_mariages ADD CONSTRAINT FK_428469B4A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carte_invitation DROP FOREIGN KEY FK_3F9BB6FFA76ED395');
        $this->addSql('ALTER TABLE centres_mariages DROP FOREIGN KEY FK_428469B4A76ED395');
        $this->addSql('DROP TABLE carte_invitation');
        $this->addSql('DROP TABLE centres_mariages');
    }
}
