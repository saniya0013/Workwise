<?php

namespace OrangeHRM\Installer\Controller\Installer\Api;

use OrangeHRM\Framework\Http\Request;
use OrangeHRM\Installer\Controller\AbstractInstallerRestController;
use OrangeHRM\Installer\Util\InstanceCreationHelper;

class CountryAPI extends AbstractInstallerRestController
{
    /**
     * @inheritDoc
     */
    protected function handleGet(Request $request): array
    {
        return [
            'data' => InstanceCreationHelper::COUNTRIES,
        ];
    }
}
