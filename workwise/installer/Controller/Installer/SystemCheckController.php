<?php


namespace OrangeHRM\Installer\Controller\Installer;

use OrangeHRM\Core\Vue\Component;
use OrangeHRM\Core\Vue\Prop;
use OrangeHRM\Framework\Http\Request;
use OrangeHRM\Installer\Controller\AbstractInstallerVueController;
use OrangeHRM\Installer\Util\StateContainer;

class SystemCheckController extends AbstractInstallerVueController
{
    /**
     * @inheritDoc
     */
    public function preRender(Request $request): void
    {
        $component = new Component('system-check-screen');
        $component->addProp(new Prop('installer', Prop::TYPE_BOOLEAN, true));
        $this->setComponent($component);
        StateContainer::getInstance()->setCurrentScreen(self::SYSTEM_CHECK_SCREEN);
    }
}
