<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250206152506 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaires ADD commentaires_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commentaires ADD CONSTRAINT FK_D9BEC0C417C4B2B0 FOREIGN KEY (commentaires_id) REFERENCES vehicules (id)');
        $this->addSql('CREATE INDEX IDX_D9BEC0C417C4B2B0 ON commentaires (commentaires_id)');
        $this->addSql('ALTER TABLE reservations ADD reservation_id INT DEFAULT NULL, ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239B83297E7 FOREIGN KEY (reservation_id) REFERENCES vehicules (id)');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_4DA239B83297E7 ON reservations (reservation_id)');
        $this->addSql('CREATE INDEX IDX_4DA239A76ED395 ON reservations (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaires DROP FOREIGN KEY FK_D9BEC0C417C4B2B0');
        $this->addSql('DROP INDEX IDX_D9BEC0C417C4B2B0 ON commentaires');
        $this->addSql('ALTER TABLE commentaires DROP commentaires_id');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA239B83297E7');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA239A76ED395');
        $this->addSql('DROP INDEX IDX_4DA239B83297E7 ON reservations');
        $this->addSql('DROP INDEX IDX_4DA239A76ED395 ON reservations');
        $this->addSql('ALTER TABLE reservations DROP reservation_id, DROP user_id');
    }
}
