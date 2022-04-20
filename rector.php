<?php

declare(strict_types=1);

use Rector\Core\Configuration\Option;
use Rector\Core\ValueObject\PhpVersion;
use Rector\Set\ValueObject\DowngradeLevelSetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator) {
	// get parameters
	$parameters = $containerConfigurator->parameters();

	$parameters->set(Option::PHP_VERSION_FEATURES, PhpVersion::PHP_70);

	// paths to refactor; solid alternative to CLI arguments
	$parameters->set(Option::PATHS, [
		__DIR__.'/fixtures',
		__DIR__.'/src',
		__DIR__.'/tests'
	]);

	// here we can define, what sets of rules will be applied
	$containerConfigurator->import(DowngradeLevelSetList::DOWN_TO_PHP_70);

	$parameters->set(Option::SKIP, [
		__DIR__.'/build/PHPStan/GetTokenDynamicReturnTypeExtension.php',
	]);
};
