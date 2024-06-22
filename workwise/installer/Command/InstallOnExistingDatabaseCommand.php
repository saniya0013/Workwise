<?php


namespace OrangeHRM\Installer\Command;

use OrangeHRM\Authentication\Dto\UserCredential;
use OrangeHRM\Installer\Util\AppSetupUtility;
use OrangeHRM\Installer\Util\StateContainer;

class InstallOnExistingDatabaseCommand extends InstallOnNewDatabaseCommand
{
    use InstallerCommandHelperTrait;

    /**
     * @inheritDoc
     */
    public function getCommandName(): string
    {
        return 'install:on-existing-database';
    }

    protected function databaseInformation(): void
    {
        dbInfo:
        $this->getIO()->title('Database Configuration');
        $this->getIO()->block('Please enter your database configuration information below.');
        $dbHost = $this->getRequiredField('Database Host Name');
        $dbPort = $this->getIO()->ask(
            'Database Host Port',
            3306,
            fn (?string $value) => $this->databasePortValidator($value)
        );
        $dbName = $this->getRequiredField('Database Name'); // not validated because existing database
        $dbUser = $this->getRequiredField('OrangeHRM Database Username');
        $dbPassword = $this->getIO()->askHidden('OrangeHRM Database User Password <comment>(hidden)</comment>');
        $enableDataEncryption = $this->getIO()->confirm('Enable Data Encryption', false);

        StateContainer::getInstance()->storeDbInfo(
            $dbHost,
            $dbPort,
            new UserCredential($dbUser, $dbPassword),
            $dbName,
            null,
            $enableDataEncryption
        );
        StateContainer::getInstance()->setDbType(AppSetupUtility::INSTALLATION_DB_TYPE_EXISTING);

        $connection = $this->getAppSetupUtility()->connectToDatabase();
        if ($connection->hasError()) {
            $this->getIO()->error($connection->getErrorMessage());
            StateContainer::getInstance()->clearDbInfo();
            goto dbInfo;
        }
        if (!$this->getAppSetupUtility()->isExistingDatabaseEmpty()) {
            $this->getIO()->error('Provided Database Not Empty');
            StateContainer::getInstance()->clearDbInfo();
            goto dbInfo;
        }
    }
}
