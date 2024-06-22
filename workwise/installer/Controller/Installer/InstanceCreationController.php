<?php


namespace OrangeHRM\Installer\Controller\Installer;

use OrangeHRM\Core\Vue\Component;
use OrangeHRM\Framework\Http\Request;
use OrangeHRM\Installer\Controller\AbstractInstallerVueController;
use OrangeHRM\Installer\Util\StateContainer;

class InstanceCreationController extends AbstractInstallerVueController
{
    /**
     * @inheritDoc
     */
    public function preRender(Request $request): void
    {
        $component = new Component('instance-creation-screen');
        $this->setComponent($component);
        StateContainer::getInstance()->setCurrentScreen(self::INSTANCE_CREATION_SCREEN);
    }
}
