<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240223205259 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_64C19C1DFAB7B3B ON category (url_key)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D34A04ADDFAB7B3B ON product (url_key)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_64C19C1DFAB7B3B ON category');
        $this->addSql('DROP INDEX UNIQ_D34A04ADDFAB7B3B ON product');
    }
}
