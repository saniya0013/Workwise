<?php


namespace OrangeHRM\Installer\Controller\Installer\Api;

use OrangeHRM\Authentication\Dto\UserCredential;
use OrangeHRM\Core\Exception\KeyHandlerException;
use OrangeHRM\Framework\Http\Request;
use OrangeHRM\Framework\Http\Response;
use OrangeHRM\Installer\Util\AppSetupUtility;
use OrangeHRM\Installer\Util\DataRegistrationUtility;
use OrangeHRM\Installer\Util\StateContainer;

class ConfigFileAPI extends \OrangeHRM\Installer\Controller\Upgrader\Api\ConfigFileAPI
{
    /**
     * @inheritDoc
     */
    protected function handlePost(Request $request): array
    {
        if (StateContainer::getInstance()->isSetDbInfo()) {
            $dbInfo = StateContainer::getInstance()->getDbInfo();

            if ($dbInfo[StateContainer::ENABLE_DATA_ENCRYPTION]) {
                try {
                    $appSetupUtility = new AppSetupUtility();
                    $appSetupUtility->writeKeyFile();
                } catch (KeyHandlerException $exception) {
                    $this->getResponse()->setStatusCode(Response::HTTP_CONFLICT);
                    return
                        [
                            'error' => [
                                'status' => $this->getResponse()->getStatusCode(),
                                'message' => $exception->getMessage()
                            ]
                        ];
                }
            }

            $dbUser = $dbInfo[StateContainer::ORANGEHRM_DB_USER] ?? $dbInfo[StateContainer::DB_USER];
            $dbPassword = isset($dbInfo[StateContainer::ORANGEHRM_DB_USER])
                ? $dbInfo[StateContainer::ORANGEHRM_DB_PASSWORD]
                : $dbInfo[StateContainer::DB_PASSWORD];
            StateContainer::getInstance()->storeDbInfo(
                $dbInfo[StateContainer::DB_HOST],
                $dbInfo[StateContainer::DB_PORT],
                new UserCredential($dbUser, $dbPassword),
                $dbInfo[StateContainer::DB_NAME]
            );
        }
        return parent::handlePost($request);
    }

    /**
     * @inheritDoc
     */
    protected function getRegistrationType(): int
    {
        return DataRegistrationUtility::REGISTRATION_TYPE_INSTALLER_STARTED;
    }
}
