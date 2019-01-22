<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190117135324 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE actor (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, age INT DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, note INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE actor_movie (actor_id INT NOT NULL, movie_id INT NOT NULL, INDEX IDX_39DA19FB10DAF24A (actor_id), INDEX IDX_39DA19FB8F93B6FC (movie_id), PRIMARY KEY(actor_id, movie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movie (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, year DATETIME DEFAULT NULL, kind VARCHAR(255) DEFAULT NULL, country VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, trailer VARCHAR(255) DEFAULT NULL, synopsis VARCHAR(255) DEFAULT NULL, director VARCHAR(255) DEFAULT NULL, time TIME DEFAULT NULL, note INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, actor_id INT DEFAULT NULL, movie_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, comment LONGTEXT NOT NULL, INDEX IDX_9474526C10DAF24A (actor_id), INDEX IDX_9474526C8F93B6FC (movie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE actor_movie ADD CONSTRAINT FK_39DA19FB10DAF24A FOREIGN KEY (actor_id) REFERENCES actor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE actor_movie ADD CONSTRAINT FK_39DA19FB8F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C10DAF24A FOREIGN KEY (actor_id) REFERENCES actor (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C8F93B6FC FOREIGN KEY (movie_id) REFERENCES movie (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE actor_movie DROP FOREIGN KEY FK_39DA19FB10DAF24A');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C10DAF24A');
        $this->addSql('ALTER TABLE actor_movie DROP FOREIGN KEY FK_39DA19FB8F93B6FC');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C8F93B6FC');
        $this->addSql('DROP TABLE actor');
        $this->addSql('DROP TABLE actor_movie');
        $this->addSql('DROP TABLE movie');
        $this->addSql('DROP TABLE comment');
    }
}
