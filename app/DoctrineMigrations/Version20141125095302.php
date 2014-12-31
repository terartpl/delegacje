<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20141125095302 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        $this->addSql("ALTER TABLE  `delegations` CHANGE  `engine_capacity`  `engine_capacity` TINYINT( 3 ) UNSIGNED NULL DEFAULT NULL");
        $this->addSql("ALTER TABLE  `delegations` CHANGE  `is_saved`  `status` TINYINT( 1 ) NOT NULL");
        $this->addSql("ALTER TABLE  `delegations` ADD  `advance` DECIMAL( 10, 2 ) NOT NULL DEFAULT  '0'");
        $this->addSql("ALTER TABLE  `users` ADD  `email` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
        $this->addSql("ALTER TABLE  `company` ADD  `street` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL");
        $this->addSql("ALTER TABLE  `company` ADD  `number` VARCHAR( 15 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL");
        $this->addSql("ALTER TABLE  `company` ADD  `zip_code` VARCHAR( 15 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL");
        $this->addSql("ALTER TABLE  `company` ADD  `locality` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL");
        $this->addSql("ALTER TABLE  `company` ADD  `country` INT( 11 ) UNSIGNED NULL DEFAULT NULL");
        $this->addSql("ALTER TABLE  `company` ADD  `nip` VARCHAR( 10 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL");
        $this->addSql("ALTER TABLE  `delegation_type` CHANGE  `name`  `trans` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
        $this->addSql("ALTER TABLE  `delegation_type` ADD  `locale` VARCHAR( 2 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , ADD INDEX (  `locale` )");
        $this->addSql("ALTER TABLE  `delegation_type` ADD  `hash_key` VARCHAR( 255 ) NOT NULL , ADD INDEX (  `hash_key` )");
        $this->addSql("ALTER TABLE  `type_of_expenditure` ADD FOREIGN KEY (  `expenditure` ) REFERENCES  `delegations`.`translations` (`hash_key`) ON DELETE CASCADE ON UPDATE CASCADE ;");
        $this->addSql("ALTER TABLE  `users` ADD UNIQUE (`email`)");

    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql("ALTER TABLE  `delegations` CHANGE  `status`  `is_saved` TINYINT( 1 ) NOT NULL");
        $this->addSql("ALTER TABLE `delegations` DROP `advance`");
        $this->addSql("ALTER TABLE `company` DROP `street`");
        $this->addSql("ALTER TABLE `users` DROP `email`");
        $this->addSql("ALTER TABLE  `company` DROP `number`");
        $this->addSql("ALTER TABLE  `company` DROP `zip_code`");
        $this->addSql("ALTER TABLE  `company` DROP `locality`");
        $this->addSql("ALTER TABLE  `company` DROP `country`");
        $this->addSql("ALTER TABLE  `company` DROP `nip`");
        $this->addSql("ALTER TABLE  `delegation_type` CHANGE  `trans`  `name` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
        $this->addSql("ALTER TABLE  `delegation_type` DROP `locale`");
        $this->addSql("ALTER TABLE  `delegation_type` DROP `hash_key`");
        $this->addSql("ALTER TABLE  `users` DROP `email`");
    }
}
