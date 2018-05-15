<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180515143804 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('ALTER TABLE suites ADD COLUMN deleted_at DATETIME DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_FA4439DD4FFCB518');
        $this->addSql('DROP INDEX IDX_FA4439DD111948DC');
        $this->addSql('CREATE TEMPORARY TABLE __temp__suites_decks AS SELECT suite_id, deck_id FROM suites_decks');
        $this->addSql('DROP TABLE suites_decks');
        $this->addSql('CREATE TABLE suites_decks (suite_id INTEGER NOT NULL, deck_id INTEGER NOT NULL, PRIMARY KEY(suite_id, deck_id), CONSTRAINT FK_FA4439DD4FFCB518 FOREIGN KEY (suite_id) REFERENCES suites (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_FA4439DD111948DC FOREIGN KEY (deck_id) REFERENCES decks (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO suites_decks (suite_id, deck_id) SELECT suite_id, deck_id FROM __temp__suites_decks');
        $this->addSql('DROP TABLE __temp__suites_decks');
        $this->addSql('CREATE INDEX IDX_FA4439DD4FFCB518 ON suites_decks (suite_id)');
        $this->addSql('CREATE INDEX IDX_FA4439DD111948DC ON suites_decks (deck_id)');
        $this->addSql('DROP INDEX IDX_4C258FD111948DC');
        $this->addSql('CREATE TEMPORARY TABLE __temp__cards AS SELECT id, deck_id, question, answer FROM cards');
        $this->addSql('DROP TABLE cards');
        $this->addSql('CREATE TABLE cards (id INTEGER NOT NULL, deck_id INTEGER NOT NULL, question VARCHAR(255) DEFAULT NULL COLLATE BINARY, answer VARCHAR(255) DEFAULT NULL COLLATE BINARY, PRIMARY KEY(id), CONSTRAINT FK_4C258FD111948DC FOREIGN KEY (deck_id) REFERENCES decks (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO cards (id, deck_id, question, answer) SELECT id, deck_id, question, answer FROM __temp__cards');
        $this->addSql('DROP TABLE __temp__cards');
        $this->addSql('CREATE INDEX IDX_4C258FD111948DC ON cards (deck_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_4C258FD111948DC');
        $this->addSql('CREATE TEMPORARY TABLE __temp__cards AS SELECT id, deck_id, question, answer FROM cards');
        $this->addSql('DROP TABLE cards');
        $this->addSql('CREATE TABLE cards (id INTEGER NOT NULL, deck_id INTEGER NOT NULL, question VARCHAR(255) DEFAULT NULL, answer VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO cards (id, deck_id, question, answer) SELECT id, deck_id, question, answer FROM __temp__cards');
        $this->addSql('DROP TABLE __temp__cards');
        $this->addSql('CREATE INDEX IDX_4C258FD111948DC ON cards (deck_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__suites AS SELECT id, name FROM suites');
        $this->addSql('DROP TABLE suites');
        $this->addSql('CREATE TABLE suites (id INTEGER NOT NULL, name VARCHAR(64) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO suites (id, name) SELECT id, name FROM __temp__suites');
        $this->addSql('DROP TABLE __temp__suites');
        $this->addSql('DROP INDEX IDX_FA4439DD4FFCB518');
        $this->addSql('DROP INDEX IDX_FA4439DD111948DC');
        $this->addSql('CREATE TEMPORARY TABLE __temp__suites_decks AS SELECT suite_id, deck_id FROM suites_decks');
        $this->addSql('DROP TABLE suites_decks');
        $this->addSql('CREATE TABLE suites_decks (suite_id INTEGER NOT NULL, deck_id INTEGER NOT NULL, PRIMARY KEY(suite_id, deck_id))');
        $this->addSql('INSERT INTO suites_decks (suite_id, deck_id) SELECT suite_id, deck_id FROM __temp__suites_decks');
        $this->addSql('DROP TABLE __temp__suites_decks');
        $this->addSql('CREATE INDEX IDX_FA4439DD4FFCB518 ON suites_decks (suite_id)');
        $this->addSql('CREATE INDEX IDX_FA4439DD111948DC ON suites_decks (deck_id)');
    }
}
