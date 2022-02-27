<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220227152643 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE attendance (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, schedule_id_id INT NOT NULL, INDEX IDX_6DE30D919D86650F (user_id_id), INDEX IDX_6DE30D91831D5E0B (schedule_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE day (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE period (id INT AUTO_INCREMENT NOT NULL, start_time TIME NOT NULL COMMENT \'(DC2Type:time_immutable)\', end_time TIME NOT NULL COMMENT \'(DC2Type:time_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE schedule (id INT AUTO_INCREMENT NOT NULL, day_id_id INT NOT NULL, subject_id_id INT NOT NULL, period_id_id INT NOT NULL, is_odd TINYINT(1) NOT NULL, INDEX IDX_5A3811FBC68922B3 (day_id_id), INDEX IDX_5A3811FB6ED75F8F (subject_id_id), INDEX IDX_5A3811FB4EEC1632 (period_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subject (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE attendance ADD CONSTRAINT FK_6DE30D919D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE attendance ADD CONSTRAINT FK_6DE30D91831D5E0B FOREIGN KEY (schedule_id_id) REFERENCES schedule (id)');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FBC68922B3 FOREIGN KEY (day_id_id) REFERENCES day (id)');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FB6ED75F8F FOREIGN KEY (subject_id_id) REFERENCES subject (id)');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FB4EEC1632 FOREIGN KEY (period_id_id) REFERENCES period (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE schedule DROP FOREIGN KEY FK_5A3811FBC68922B3');
        $this->addSql('ALTER TABLE schedule DROP FOREIGN KEY FK_5A3811FB4EEC1632');
        $this->addSql('ALTER TABLE attendance DROP FOREIGN KEY FK_6DE30D91831D5E0B');
        $this->addSql('ALTER TABLE schedule DROP FOREIGN KEY FK_5A3811FB6ED75F8F');
        $this->addSql('DROP TABLE attendance');
        $this->addSql('DROP TABLE day');
        $this->addSql('DROP TABLE period');
        $this->addSql('DROP TABLE schedule');
        $this->addSql('DROP TABLE subject');
        $this->addSql('ALTER TABLE user CHANGE username username VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
