<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250701091652 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE evenements ADD location_id INT DEFAULT NULL, DROP location
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE evenements ADD CONSTRAINT FK_E10AD40064D218E FOREIGN KEY (location_id) REFERENCES departements (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_E10AD40064D218E ON evenements (location_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE evenements DROP FOREIGN KEY FK_E10AD40064D218E
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_E10AD40064D218E ON evenements
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE evenements ADD location VARCHAR(255) NOT NULL, DROP location_id
        SQL);
    }
}
