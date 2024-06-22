<?php


use OrangeHRM\Framework\Http\Request;
use OrangeHRM\Installer\Exception\SessionStorageNotWritable;
use OrangeHRM\Installer\Framework\HttpKernel;
use Symfony\Component\ErrorHandler\Debug;

function trimVersion($currentVersion, $points)
{
    $pattern = '/^(\d+)' . str_repeat('\.(\d+)', $points) . '/';
    preg_match($pattern, $currentVersion, $matches);
    return $matches[0];
}

function isInSupportedPHPRange()
{
    $systemRequirements = require realpath(__DIR__ . '/config/system_requirements.php');
    $max = $systemRequirements['phpversion']['max'];
    $min = $systemRequirements['phpversion']['min'];
    $currentVersion = phpversion();

    $message = "PHP version should be higher than `$min` and lower than `$max`, detected version is `$currentVersion`.";

    if (!(version_compare(trimVersion($currentVersion, substr_count($min, '.')), $min, '>=') &&
        version_compare(trimVersion($currentVersion, substr_count($max, '.')), $max, '<='))) {
        die($message);
    }

    if (in_array($currentVersion, $systemRequirements['phpversion']['excludeRange'])) {
        die($message);
    }
}

isInSupportedPHPRange();

require realpath(__DIR__ . '/../src/vendor/autoload.php');

$env = 'prod';
$debug = 'prod' !== $env;

if ($debug) {
    umask(0000);
    Debug::enable();
}

$kernel = new HttpKernel($env, $debug);
$request = Request::createFromGlobals();
try {
    $response = $kernel->handleRequest($request);
    $response->send();
    $kernel->terminate($request, $response);
} catch (SessionStorageNotWritable $e) {
    die($e->getMessage());
}
