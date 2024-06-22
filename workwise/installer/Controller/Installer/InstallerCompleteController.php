<?php


namespace OrangeHRM\Installer\Controller\Installer;

use OrangeHRM\Config\Config;
use OrangeHRM\Core\Helper\VueControllerHelper;
use OrangeHRM\Core\Vue\Component;
use OrangeHRM\Core\Vue\Prop;
use OrangeHRM\Framework\Http\Request;
use OrangeHRM\Installer\Controller\AbstractInstallerVueController;
use OrangeHRM\Installer\Util\Logger;
use OrangeHRM\Installer\Util\StateContainer;

class InstallerCompleteController extends AbstractInstallerVueController
{
    /**
     * @inheritDoc
     */
    public function preRender(Request $request): void
    {
        $component = new Component('installer-complete-screen');
        $component->addProp(
            new Prop(VueControllerHelper::PRODUCT_VERSION, Prop::TYPE_STRING, Config::PRODUCT_VERSION)
        );
        $this->setComponent($component);
        StateContainer::getInstance()->setCurrentScreen(self::INSTALLATION_COMPLETE_SCREEN);
        StateContainer::getInstance()->clean();

        Logger::getLogger()->info(
            'OrangeHRM ' . Config::PRODUCT_VERSION . ' status: ' . var_export(Config::isInstalled(), true)
        );
    }
}
