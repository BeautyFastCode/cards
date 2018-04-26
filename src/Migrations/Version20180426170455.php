<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180426170455 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE decks (id INTEGER NOT NULL, name VARCHAR(64) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE suites (id INTEGER NOT NULL, name VARCHAR(64) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE suites_decks (suite_id INTEGER NOT NULL, deck_id INTEGER NOT NULL, PRIMARY KEY(suite_id, deck_id))');
        $this->addSql('CREATE INDEX IDX_FA4439DD4FFCB518 ON suites_decks (suite_id)');
        $this->addSql('CREATE INDEX IDX_FA4439DD111948DC ON suites_decks (deck_id)');
        $this->addSql('CREATE TABLE cards (id INTEGER NOT NULL, deck_id INTEGER NOT NULL, question VARCHAR(255) DEFAULT NULL, answer VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4C258FD111948DC ON cards (deck_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE decks');
        $this->addSql('DROP TABLE suites');
        $this->addSql('DROP TABLE suites_decks');
        $this->addSql('DROP TABLE cards');
    }
}
