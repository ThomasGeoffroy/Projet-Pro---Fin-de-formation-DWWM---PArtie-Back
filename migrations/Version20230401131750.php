<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230401131750 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, address VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_order_product DROP FOREIGN KEY FK_FFDDB114462F07AF');
        $this->addSql('ALTER TABLE product_order_product DROP FOREIGN KEY FK_FFDDB1144584665A');
        $this->addSql('DROP TABLE product_order_product');
        $this->addSql('ALTER TABLE product CHANGE size size VARCHAR(16) DEFAULT NULL');
        $this->addSql('ALTER TABLE product_order DROP FOREIGN KEY FK_5475E8C48C26A5E8');
        $this->addSql('DROP INDEX UNIQ_5475E8C48C26A5E8 ON product_order');
        $this->addSql('ALTER TABLE product_order ADD product_id INT DEFAULT NULL, CHANGE order_number_id order_code_id INT NOT NULL');
        $this->addSql('ALTER TABLE product_order ADD CONSTRAINT FK_5475E8C4D1A0575C FOREIGN KEY (order_code_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE product_order ADD CONSTRAINT FK_5475E8C44584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_5475E8C4D1A0575C ON product_order (order_code_id)');
        $this->addSql('CREATE INDEX IDX_5475E8C44584665A ON product_order (product_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_order_product (product_order_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_FFDDB1144584665A (product_id), INDEX IDX_FFDDB114462F07AF (product_order_id), PRIMARY KEY(product_order_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE product_order_product ADD CONSTRAINT FK_FFDDB114462F07AF FOREIGN KEY (product_order_id) REFERENCES product_order (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_order_product ADD CONSTRAINT FK_FFDDB1144584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE customer');
        $this->addSql('ALTER TABLE product CHANGE size size VARCHAR(16) NOT NULL');
        $this->addSql('ALTER TABLE product_order DROP FOREIGN KEY FK_5475E8C4D1A0575C');
        $this->addSql('ALTER TABLE product_order DROP FOREIGN KEY FK_5475E8C44584665A');
        $this->addSql('DROP INDEX IDX_5475E8C4D1A0575C ON product_order');
        $this->addSql('DROP INDEX IDX_5475E8C44584665A ON product_order');
        $this->addSql('ALTER TABLE product_order DROP product_id, CHANGE order_code_id order_number_id INT NOT NULL');
        $this->addSql('ALTER TABLE product_order ADD CONSTRAINT FK_5475E8C48C26A5E8 FOREIGN KEY (order_number_id) REFERENCES `order` (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5475E8C48C26A5E8 ON product_order (order_number_id)');
    }
}
