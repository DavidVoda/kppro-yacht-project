<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220119191023 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE reservation (id UUID NOT NULL, yacht_id UUID NOT NULL, start_time TIMESTAMP(0) WITH TIME ZONE NOT NULL, end_time TIMESTAMP(0) WITH TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_42C84955A1837812 ON reservation (yacht_id)');
        $this->addSql('COMMENT ON COLUMN reservation.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN reservation.yacht_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN reservation.start_time IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('COMMENT ON COLUMN reservation.end_time IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('CREATE TABLE review (id UUID NOT NULL, yacht_id UUID NOT NULL, text VARCHAR(255) NOT NULL, rating INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_794381C6A1837812 ON review (yacht_id)');
        $this->addSql('COMMENT ON COLUMN review.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN review.yacht_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE yacht (id UUID NOT NULL, name VARCHAR(255) NOT NULL, model VARCHAR(255) NOT NULL, passenger_count INT NOT NULL, price_per_day VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN yacht.id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955A1837812 FOREIGN KEY (yacht_id) REFERENCES yacht (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6A1837812 FOREIGN KEY (yacht_id) REFERENCES yacht (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->throwIrreversibleMigrationException();
    }
}
