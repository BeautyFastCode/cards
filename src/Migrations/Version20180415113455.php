<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180415113455 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__suites AS SELECT id, name FROM suites');
        $this->addSql('DROP TABLE suites');
        $this->addSql('CREATE TABLE suites (id INTEGER NOT NULL, name VARCHAR(64) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO suites (id, name) SELECT id, name FROM __temp__suites');
        $this->addSql('DROP TABLE __temp__suites');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__suites AS SELECT id, name FROM suites');
        $this->addSql('DROP TABLE suites');
        $this->addSql('CREATE TABLE suites (id INTEGER NOT NULL, name VARCHAR(128) NOT NULL COLLATE BINARY, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO suites (id, name) SELECT id, name FROM __temp__suites');
        $this->addSql('DROP TABLE __temp__suites');
    }
}
