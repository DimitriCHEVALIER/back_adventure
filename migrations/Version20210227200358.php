<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210227200358 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cryptocurrency (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, original_currency_id INT NOT NULL, new_currency_id INT NOT NULL, plateforme_id INT DEFAULT NULL, amount_old_currency INT NOT NULL, amount_new_currency INT NOT NULL, INDEX IDX_F5299398CF2B615C (original_currency_id), INDEX IDX_F5299398AA2B300E (new_currency_id), INDEX IDX_F5299398391E226B (plateforme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE owned_crypto (id INT AUTO_INCREMENT NOT NULL, crytocurrency_id INT NOT NULL, plateforme_id INT DEFAULT NULL, amount INT NOT NULL, euro_amount_origin INT DEFAULT NULL, INDEX IDX_77063C7765F980E9 (crytocurrency_id), INDEX IDX_77063C77391E226B (plateforme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398CF2B615C FOREIGN KEY (original_currency_id) REFERENCES cryptocurrency (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398AA2B300E FOREIGN KEY (new_currency_id) REFERENCES cryptocurrency (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398391E226B FOREIGN KEY (plateforme_id) REFERENCES plateforme (id)');
        $this->addSql('ALTER TABLE owned_crypto ADD CONSTRAINT FK_77063C7765F980E9 FOREIGN KEY (crytocurrency_id) REFERENCES cryptocurrency (id)');
        $this->addSql('ALTER TABLE owned_crypto ADD CONSTRAINT FK_77063C77391E226B FOREIGN KEY (plateforme_id) REFERENCES plateforme (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398CF2B615C');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398AA2B300E');
        $this->addSql('ALTER TABLE owned_crypto DROP FOREIGN KEY FK_77063C7765F980E9');
        $this->addSql('DROP TABLE cryptocurrency');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE owned_crypto');
    }
}
