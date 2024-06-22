<?php


namespace OrangeHRM\Installer\Controller\Installer\Api;

use InvalidArgumentException;
use OrangeHRM\Authentication\Dto\UserCredential;
use OrangeHRM\Framework\Http\Request;
use OrangeHRM\Framework\Http\Response;
use OrangeHRM\Installer\Controller\AbstractInstallerRestController;
use OrangeHRM\Installer\Util\StateContainer;

class AdminUserAPI extends AbstractInstallerRestController
{
    /**
     * @inheritDoc
     */
    protected function handlePost(Request $request): array
    {
        try {
            $firstName = $this->checkAndGetField($request, 'firstName');
            $lastName = $this->checkAndGetField($request, 'lastName');
            $email = $this->checkAndGetField($request, 'email');
            $username = $this->checkAndGetField($request, 'username');
            $password = $this->checkAndGetField($request, 'password');
        } catch (InvalidArgumentException $e) {
            $this->getResponse()->setStatusCode(Response::HTTP_BAD_REQUEST);
            return [
                'error' => [
                    'status' => $this->getResponse()->getStatusCode(),
                    'message' => $e->getMessage(),
                ]
            ];
        }

        $contact = $request->request->get('contact');
        $registrationConsent = $request->request->getBoolean('registrationConsent', true);

        StateContainer::getInstance()->storeAdminUserData(
            $firstName,
            $lastName,
            $email,
            new UserCredential($username, $password),
            $contact
        );
        StateContainer::getInstance()->storeRegConsent($registrationConsent);
        return [
            'firstName' => $firstName,
            'lastName' => $lastName,
            'email' => $email,
            'username' => $username,
            'contact' => $contact,
            'registrationConsent' => $registrationConsent,
        ];
    }

    /**
     * @param Request $request
     * @param string $name
     * @return string|null
     */
    private function checkAndGetField(Request $request, string $name): ?string
    {
        if ($request->request->has($name)) {
            if (!empty($request->request->get($name))) {
                return $request->request->get($name);
            }
        }
        throw new InvalidArgumentException("`$name` is required");
    }

    /**
     * @inheritDoc
     */
    protected function handleGet(Request $request): array
    {
        $adminUserData = StateContainer::getInstance()->getAdminUserData();
        return [
            'data' => [
                'firstName' => $adminUserData[StateContainer::ADMIN_FIRST_NAME],
                'lastName' => $adminUserData[StateContainer::ADMIN_LAST_NAME],
                'email' => $adminUserData[StateContainer::ADMIN_EMAIL],
                'username' => $adminUserData[StateContainer::ADMIN_USERNAME],
                'contact' => $adminUserData[StateContainer::ADMIN_CONTACT],
                'registrationConsent' => StateContainer::getInstance()->getRegConsent(),
            ],
        ];
    }
}