<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240512094625 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE url_mapping (url_key VARCHAR(255) NOT NULL, entity_type VARCHAR(255) NOT NULL, entity_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_F4957AD681257D5D (entity_id), PRIMARY KEY(url_key)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('DROP INDEX UNIQ_64C19C1DFAB7B3B ON category');
        $this->addSql('ALTER TABLE category ADD url_mapping_key VARCHAR(255) DEFAULT NULL, DROP url_key');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C12B44F1CA FOREIGN KEY (url_mapping_key) REFERENCES url_mapping (url_key)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_64C19C12B44F1CA ON category (url_mapping_key)');
        $this->addSql('DROP INDEX UNIQ_D34A04ADDFAB7B3B ON product');
        $this->addSql('ALTER TABLE product ADD url_mapping_key VARCHAR(255) DEFAULT NULL, DROP url_key');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD2B44F1CA FOREIGN KEY (url_mapping_key) REFERENCES url_mapping (url_key)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D34A04AD2B44F1CA ON product (url_mapping_key)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C12B44F1CA');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD2B44F1CA');
        $this->addSql('DROP TABLE url_mapping');
        $this->addSql('DROP INDEX UNIQ_D34A04AD2B44F1CA ON product');
        $this->addSql('ALTER TABLE product ADD url_key VARCHAR(255) NOT NULL, DROP url_mapping_key');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D34A04ADDFAB7B3B ON product (url_key)');
        $this->addSql('DROP INDEX UNIQ_64C19C12B44F1CA ON category');
        $this->addSql('ALTER TABLE category ADD url_key VARCHAR(255) NOT NULL, DROP url_mapping_key');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_64C19C1DFAB7B3B ON category (url_key)');
    }
}
