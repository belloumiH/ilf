<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200126162317 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Insert default skill';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' != $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql(
            'INSERT INTO
            ilf_user(username,username_canonical,email,email_canonical,enabled,salt,password,roles)
             VALUES ("adminIlf",
             "adminilf",
             "haythem.belloumi@gmail.com",
             "haythem.belloumi@gmail.com",
             1,
             "MNZizSzMhK.7Dbn9Ul5353JSIefeCLWXcBWFjAP.iyE",
             "$2y$13$Cxrs8plw9lFR4k6EwuU.M.4Xwu9zVten11qLS5Qp/Ic5wjUxOJVs6",
             "a:1:{i:0;s:10:\"ROLE_ADMIN\";}")'
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}
