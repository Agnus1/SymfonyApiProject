<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220227153210 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attendance DROP FOREIGN KEY FK_6DE30D91831D5E0B');
        $this->addSql('ALTER TABLE attendance DROP FOREIGN KEY FK_6DE30D919D86650F');
        $this->addSql('DROP INDEX IDX_6DE30D91831D5E0B ON attendance');
        $this->addSql('DROP INDEX IDX_6DE30D919D86650F ON attendance');
        $this->addSql('ALTER TABLE attendance ADD user_id INT NOT NULL, ADD schedule_id INT NOT NULL, DROP user_id_id, DROP schedule_id_id');
        $this->addSql('ALTER TABLE attendance ADD CONSTRAINT FK_6DE30D91A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE attendance ADD CONSTRAINT FK_6DE30D91A40BC2D5 FOREIGN KEY (schedule_id) REFERENCES schedule (id)');
        $this->addSql('CREATE INDEX IDX_6DE30D91A76ED395 ON attendance (user_id)');
        $this->addSql('CREATE INDEX IDX_6DE30D91A40BC2D5 ON attendance (schedule_id)');
        $this->addSql('ALTER TABLE schedule DROP FOREIGN KEY FK_5A3811FB4EEC1632');
        $this->addSql('ALTER TABLE schedule DROP FOREIGN KEY FK_5A3811FB6ED75F8F');
        $this->addSql('ALTER TABLE schedule DROP FOREIGN KEY FK_5A3811FBC68922B3');
        $this->addSql('DROP INDEX IDX_5A3811FB4EEC1632 ON schedule');
        $this->addSql('DROP INDEX IDX_5A3811FB6ED75F8F ON schedule');
        $this->addSql('DROP INDEX IDX_5A3811FBC68922B3 ON schedule');
        $this->addSql('ALTER TABLE schedule ADD day_id INT NOT NULL, ADD subject_id INT NOT NULL, ADD period_id INT NOT NULL, DROP day_id_id, DROP subject_id_id, DROP period_id_id');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FB9C24126 FOREIGN KEY (day_id) REFERENCES day (id)');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FB23EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id)');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FBEC8B7ADE FOREIGN KEY (period_id) REFERENCES period (id)');
        $this->addSql('CREATE INDEX IDX_5A3811FB9C24126 ON schedule (day_id)');
        $this->addSql('CREATE INDEX IDX_5A3811FB23EDC87 ON schedule (subject_id)');
        $this->addSql('CREATE INDEX IDX_5A3811FBEC8B7ADE ON schedule (period_id)');
        $this->addSql('ALTER TABLE user ADD full_name VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attendance DROP FOREIGN KEY FK_6DE30D91A76ED395');
        $this->addSql('ALTER TABLE attendance DROP FOREIGN KEY FK_6DE30D91A40BC2D5');
        $this->addSql('DROP INDEX IDX_6DE30D91A76ED395 ON attendance');
        $this->addSql('DROP INDEX IDX_6DE30D91A40BC2D5 ON attendance');
        $this->addSql('ALTER TABLE attendance ADD user_id_id INT NOT NULL, ADD schedule_id_id INT NOT NULL, DROP user_id, DROP schedule_id');
        $this->addSql('ALTER TABLE attendance ADD CONSTRAINT FK_6DE30D91831D5E0B FOREIGN KEY (schedule_id_id) REFERENCES schedule (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE attendance ADD CONSTRAINT FK_6DE30D919D86650F FOREIGN KEY (user_id_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_6DE30D91831D5E0B ON attendance (schedule_id_id)');
        $this->addSql('CREATE INDEX IDX_6DE30D919D86650F ON attendance (user_id_id)');
        $this->addSql('ALTER TABLE day CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE schedule DROP FOREIGN KEY FK_5A3811FB9C24126');
        $this->addSql('ALTER TABLE schedule DROP FOREIGN KEY FK_5A3811FB23EDC87');
        $this->addSql('ALTER TABLE schedule DROP FOREIGN KEY FK_5A3811FBEC8B7ADE');
        $this->addSql('DROP INDEX IDX_5A3811FB9C24126 ON schedule');
        $this->addSql('DROP INDEX IDX_5A3811FB23EDC87 ON schedule');
        $this->addSql('DROP INDEX IDX_5A3811FBEC8B7ADE ON schedule');
        $this->addSql('ALTER TABLE schedule ADD day_id_id INT NOT NULL, ADD subject_id_id INT NOT NULL, ADD period_id_id INT NOT NULL, DROP day_id, DROP subject_id, DROP period_id');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FB4EEC1632 FOREIGN KEY (period_id_id) REFERENCES period (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FB6ED75F8F FOREIGN KEY (subject_id_id) REFERENCES subject (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FBC68922B3 FOREIGN KEY (day_id_id) REFERENCES day (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_5A3811FB4EEC1632 ON schedule (period_id_id)');
        $this->addSql('CREATE INDEX IDX_5A3811FB6ED75F8F ON schedule (subject_id_id)');
        $this->addSql('CREATE INDEX IDX_5A3811FBC68922B3 ON schedule (day_id_id)');
        $this->addSql('ALTER TABLE subject CHANGE name name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user DROP full_name, CHANGE username username VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE email email VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
