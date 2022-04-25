<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220424094327 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A54CC8505A');
        $this->addSql('CREATE TABLE centre_formation (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, num_tel VARCHAR(255) DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offre_emploi (id INT AUTO_INCREMENT NOT NULL, sujet VARCHAR(255) NOT NULL, periode INT NOT NULL, date_debut DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offre_stage (id INT AUTO_INCREMENT NOT NULL, societe_id INT NOT NULL, sujet VARCHAR(255) NOT NULL, periode INT NOT NULL, date_debut DATE DEFAULT NULL, INDEX IDX_955674F2FCF77503 (societe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE offre_stage ADD CONSTRAINT FK_955674F2FCF77503 FOREIGN KEY (societe_id) REFERENCES societe (id)');
        $this->addSql('DROP TABLE offre');
        $this->addSql('DROP INDEX IDX_2694D7A54CC8505A ON demande');
        $this->addSql('ALTER TABLE demande ADD offres_emploi_id INT DEFAULT NULL, CHANGE offre_id offre_stage_id INT NOT NULL');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5195A2A28 FOREIGN KEY (offre_stage_id) REFERENCES offre_stage (id)');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A545E53A FOREIGN KEY (offres_emploi_id) REFERENCES offre_emploi (id)');
        $this->addSql('CREATE INDEX IDX_2694D7A5195A2A28 ON demande (offre_stage_id)');
        $this->addSql('CREATE INDEX IDX_2694D7A545E53A ON demande (offres_emploi_id)');
        $this->addSql('ALTER TABLE formation ADD centre_formation_id INT NOT NULL');
        $this->addSql('ALTER TABLE formation ADD CONSTRAINT FK_404021BF89FEAA37 FOREIGN KEY (centre_formation_id) REFERENCES centre_formation (id)');
        $this->addSql('CREATE INDEX IDX_404021BF89FEAA37 ON formation (centre_formation_id)');
        $this->addSql('ALTER TABLE societe ADD offre_emploi_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE societe ADD CONSTRAINT FK_19653DBDB08996ED FOREIGN KEY (offre_emploi_id) REFERENCES offre_emploi (id)');
        $this->addSql('CREATE INDEX IDX_19653DBDB08996ED ON societe (offre_emploi_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE formation DROP FOREIGN KEY FK_404021BF89FEAA37');
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A545E53A');
        $this->addSql('ALTER TABLE societe DROP FOREIGN KEY FK_19653DBDB08996ED');
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A5195A2A28');
        $this->addSql('CREATE TABLE offre (id INT AUTO_INCREMENT NOT NULL, societe_id INT NOT NULL, sujet VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, periode INT NOT NULL, date_debut DATE DEFAULT NULL, type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_AF86866FFCF77503 (societe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866FFCF77503 FOREIGN KEY (societe_id) REFERENCES societe (id)');
        $this->addSql('DROP TABLE centre_formation');
        $this->addSql('DROP TABLE offre_emploi');
        $this->addSql('DROP TABLE offre_stage');
        $this->addSql('DROP INDEX IDX_2694D7A5195A2A28 ON demande');
        $this->addSql('DROP INDEX IDX_2694D7A545E53A ON demande');
        $this->addSql('ALTER TABLE demande DROP offres_emploi_id, CHANGE offre_stage_id offre_id INT NOT NULL');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A54CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id)');
        $this->addSql('CREATE INDEX IDX_2694D7A54CC8505A ON demande (offre_id)');
        $this->addSql('DROP INDEX IDX_404021BF89FEAA37 ON formation');
        $this->addSql('ALTER TABLE formation DROP centre_formation_id');
        $this->addSql('DROP INDEX IDX_19653DBDB08996ED ON societe');
        $this->addSql('ALTER TABLE societe DROP offre_emploi_id');
    }
}
