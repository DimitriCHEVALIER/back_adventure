<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210308173922 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE benefice_by_owned_crypto (id INT AUTO_INCREMENT NOT NULL, owned_crypto_id INT NOT NULL, benefice_net DOUBLE PRECISION NOT NULL, impot DOUBLE PRECISION NOT NULL, impot_declared TINYINT(1) DEFAULT \'0\' NOT NULL, INDEX IDX_76CB56BAD6F6758 (owned_crypto_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE benefice_by_owned_crypto ADD CONSTRAINT FK_76CB56BAD6F6758 FOREIGN KEY (owned_crypto_id) REFERENCES owned_crypto (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE benefice_by_owned_crypto');
    }
}
