<?php


namespace OrangeHRM\Installer\Controller\Installer;

use OrangeHRM\Core\Vue\Component;
use OrangeHRM\Framework\Http\Request;
use OrangeHRM\Installer\Controller\AbstractInstallerVueController;
use OrangeHRM\Installer\Util\StateContainer;

class InstallerController extends AbstractInstallerVueController
{
    /**
     * @inheritDoc
     */
    public function preRender(Request $request): void
    {
        $component = new Component('install-process-screen');
        $this->setComponent($component);
        StateContainer::getInstance()->setCurrentScreen(self::INSTALLATION_SCREEN);
    }
}
