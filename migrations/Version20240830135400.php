<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240830135400 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create Student table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE student (
            id SERIAL PRIMARY KEY,
            username VARCHAR(255) DEFAULT NULL,
            phone_number VARCHAR(20) DEFAULT NULL
        )');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE student');
    }
}
