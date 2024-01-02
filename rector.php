<?php
/**
 * Rector Rules
 * 
 * @see https://github.com/rectorphp/rector/blob/main/docs/rector_rules_overview.md
 */

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Core\ValueObject\PhpVersion;
use Rector\Set\ValueObject\SetList;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Strict\Rector\Empty_\DisallowedEmptyRuleFixerRector;
use Rector\CodeQuality\Rector\BooleanAnd\SimplifyEmptyArrayCheckRector;
use Rector\CodeQuality\Rector\Empty_\SimplifyEmptyCheckOnEmptyArrayRector;
use Rector\CodingStyle\Rector\Closure\StaticClosureRector;
use Rector\CodingStyle\Rector\Stmt\NewlineAfterStatementRector;
use Rector\Naming\Rector\ClassMethod\RenameParamToMatchTypeRector;
use Rector\Php53\Rector\Ternary\TernaryToElvisRector;
use Rector\Php71\Rector\FuncCall\RemoveExtraParametersRector;
use Rector\Php74\Rector\Closure\ClosureToArrowFunctionRector;
use Rector\Php81\Rector\Array_\FirstClassCallableRector;


return static function ( RectorConfig $rectorConfig ): void {
	$rectorConfig->paths(
		[
			__DIR__
		]
	);
	
	$rectorConfig->skip(
		[
			__DIR__ . '/.git',
			__DIR__ . '/.github',
			__DIR__ . '/.vscode',
			__DIR__ . '/assets',
			__DIR__ . '/dist',
			__DIR__ . '/node_modules',
			__DIR__ . '/phpstan',
			__DIR__ . '/vendor',
			DisallowedEmptyRuleFixerRector::class,
			SimplifyEmptyArrayCheckRector::class,
			SimplifyEmptyCheckOnEmptyArrayRector::class,
			StaticClosureRector::class,
			NewlineAfterStatementRector::class,
			RenameParamToMatchTypeRector::class,
			TernaryToElvisRector::class,
			RemoveExtraParametersRector::class,
			ClosureToArrowFunctionRector::class,
			FirstClassCallableRector::class,
		]
	);

	$rectorConfig->autoloadPaths(
		[
			__DIR__ . '/vendor/php-stubs/wordpress-stubs/wordpress-stubs.php',
			__DIR__ . '/vendor/php-stubs/wp-cli-stubs/wp-cli-stubs.php',
			__DIR__ . '/vendor/php-stubs/acf-pro-stubs/acf-pro-stubs.php',
			__DIR__ . '/vendor/php-stubs/genesis-stubs/genesis-stubs.php',
		]
	);

	$rectorConfig->phpstanConfigs(
		[
			__DIR__ . '/phpstan.neon',
		]
	);

	$rectorConfig->sets(
		[
			SetList::STRICT_BOOLEANS,
			SetList::GMAGICK_TO_IMAGICK,
			SetList::NAMING,
			SetList::PRIVATIZATION,
			SetList::TYPE_DECLARATION,
			SetList::EARLY_RETURN,
			SetList::INSTANCEOF,
			SetList::DEAD_CODE,
			SetList::CODE_QUALITY,
			SetList::CODING_STYLE,
			SetList::PHP_82,
			LevelSetList::UP_TO_PHP_82,
		]
	);

	$rectorConfig->phpVersion( PhpVersion::PHP_82 );
};
