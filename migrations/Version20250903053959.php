<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250903053959 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create School entity and add school relationship to Student entity';
    }

    public function up(Schema $schema): void
    {
        // Create School table
        $this->addSql('CREATE TABLE school (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, degree VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        
        // Add school_id column to student table
        $this->addSql('ALTER TABLE student ADD school_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF33C32A47EE FOREIGN KEY (school_id) REFERENCES school (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_B723AF33C32A47EE ON student (school_id)');
    }

    public function down(Schema $schema): void
    {
        // Remove foreign key constraint and index
        $this->addSql('ALTER TABLE student DROP CONSTRAINT FK_B723AF33C32A47EE');
        $this->addSql('DROP INDEX IDX_B723AF33C32A47EE');
        
        // Remove school_id column from student table
        $this->addSql('ALTER TABLE student DROP school_id');
        
        // Drop School table
        $this->addSql('DROP TABLE school');
    }
}
