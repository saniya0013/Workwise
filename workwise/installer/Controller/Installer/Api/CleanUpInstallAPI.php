<?php


namespace OrangeHRM\Installer\Controller\Installer\Api;

use OrangeHRM\Framework\Http\Request;
use OrangeHRM\Installer\Controller\AbstractInstallerRestController;
use OrangeHRM\Installer\Util\AppSetupUtility;
use OrangeHRM\Installer\Util\StateContainer;

class CleanUpInstallAPI extends AbstractInstallerRestController
{
    /**
     * @inheritDoc
     */
    protected function handlePost(Request $request): array
    {
        $appSetupUtility = new AppSetupUtility();

        if (StateContainer::getInstance()->getDbType() === AppSetupUtility::INSTALLATION_DB_TYPE_NEW) {
            $appSetupUtility->dropDatabase();
        } else {
            $appSetupUtility->cleanUpInstallOnFailure();
        }

        return [];
    }
}
