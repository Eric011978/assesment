<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220213214756 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE guideline (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, external_id VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE guideline_navigation (id INT AUTO_INCREMENT NOT NULL, guideline_id INT DEFAULT NULL, module_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, external_id VARCHAR(255) NOT NULL, INDEX IDX_FBBEC451CC0B46A8 (guideline_id), INDEX IDX_FBBEC451AFC2B591 (module_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE module (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, external_id VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE module_hyperlink (id INT AUTO_INCREMENT NOT NULL, module_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, url VARCHAR(255) NOT NULL, external_id VARCHAR(255) NOT NULL, INDEX IDX_C86719E1AFC2B591 (module_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE module_reference (id INT AUTO_INCREMENT NOT NULL, module_id INT DEFAULT NULL, content VARCHAR(255) NOT NULL, external_id VARCHAR(255) NOT NULL, INDEX IDX_F4C256DBAFC2B591 (module_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE guideline_navigation ADD CONSTRAINT FK_FBBEC451CC0B46A8 FOREIGN KEY (guideline_id) REFERENCES guideline (id)');
        $this->addSql('ALTER TABLE guideline_navigation ADD CONSTRAINT FK_FBBEC451AFC2B591 FOREIGN KEY (module_id) REFERENCES module (id)');
        $this->addSql('ALTER TABLE module_hyperlink ADD CONSTRAINT FK_C86719E1AFC2B591 FOREIGN KEY (module_id) REFERENCES module (id)');
        $this->addSql('ALTER TABLE module_reference ADD CONSTRAINT FK_F4C256DBAFC2B591 FOREIGN KEY (module_id) REFERENCES module (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE guideline_navigation DROP FOREIGN KEY FK_FBBEC451CC0B46A8');
        $this->addSql('ALTER TABLE guideline_navigation DROP FOREIGN KEY FK_FBBEC451AFC2B591');
        $this->addSql('ALTER TABLE module_hyperlink DROP FOREIGN KEY FK_C86719E1AFC2B591');
        $this->addSql('ALTER TABLE module_reference DROP FOREIGN KEY FK_F4C256DBAFC2B591');
        $this->addSql('DROP TABLE guideline');
        $this->addSql('DROP TABLE guideline_navigation');
        $this->addSql('DROP TABLE module');
        $this->addSql('DROP TABLE module_hyperlink');
        $this->addSql('DROP TABLE module_reference');
    }
}
