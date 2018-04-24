<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180424213229 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE suites_decks (suite_id INTEGER NOT NULL, deck_id INTEGER NOT NULL, PRIMARY KEY(suite_id, deck_id))');
        $this->addSql('CREATE INDEX IDX_FA4439DD4FFCB518 ON suites_decks (suite_id)');
        $this->addSql('CREATE INDEX IDX_FA4439DD111948DC ON suites_decks (deck_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__deck AS SELECT id, name FROM deck');
        $this->addSql('DROP TABLE deck');
        $this->addSql('CREATE TABLE deck (id INTEGER NOT NULL, name VARCHAR(64) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO deck (id, name) SELECT id, name FROM __temp__deck');
        $this->addSql('DROP TABLE __temp__deck');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE suites_decks');
        $this->addSql('CREATE TEMPORARY TABLE __temp__deck AS SELECT id, name FROM deck');
        $this->addSql('DROP TABLE deck');
        $this->addSql('CREATE TABLE deck (id INTEGER NOT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO deck (id, name) SELECT id, name FROM __temp__deck');
        $this->addSql('DROP TABLE __temp__deck');
    }
}
