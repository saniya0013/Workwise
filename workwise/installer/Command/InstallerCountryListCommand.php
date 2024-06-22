<?php


namespace OrangeHRM\Installer\Command;

use OrangeHRM\Installer\Framework\InstallerCommand;
use OrangeHRM\Installer\Util\InstanceCreationHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class InstallerCountryListCommand extends InstallerCommand
{
    /**
     * @inheritDoc
     */
    public function getCommandName(): string
    {
        return 'install:country-list';
    }

    /**
     * @inheritDoc
     */
    protected function configure(): void
    {
        $this->addOption('country', 'c', InputOption::VALUE_REQUIRED);
    }

    /**
     * @inheritDoc
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $countries = array_combine(
            array_column(InstanceCreationHelper::COUNTRIES, 'id'),
            array_column(InstanceCreationHelper::COUNTRIES, 'label')
        );
        asort($countries);
        $countries = array_map(fn ($country) => strtolower($country), $countries);

        $country = $input->getOption('country');
        if ($country !== null) {
            $countries = array_flip($countries);
            $country = $countries[strtolower($country)] ?? null;
            if ($country == null) {
                $this->getIO()->error('Invalid country');
                return self::FAILURE;
            }
            $this->getIO()->writeln($country);
            return self::SUCCESS;
        }

        $countries = array_map(static function ($k, $v) {
            return " <comment>[$k]</comment> $v";
        }, array_keys($countries), array_values($countries));
        $this->getIO()->writeln($countries);
        return self::SUCCESS;
    }
}
