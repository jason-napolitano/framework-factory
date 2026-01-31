<?php

use FrameworkFactory\Contracts\Application\ApplicationInstance;
use FrameworkFactory\Application;
use Tests\Providers;
use Tests\TestState;

describe('bootstrap tests', function() {

	test('the application bootstrap build process completes properly', function() {
		expect(TestState::$app)->toBeInstanceOf(ApplicationInstance::class);
	});

	test('the version number can be assigned to the application', function () {
		TestState::$app->asVersion('1.2.3');
		expect(Application::version())->toBe('1.2.3');
	});

	test('providers can be successfully added to the container', function() {
		expect(Application::providers())->toContain(Providers\DeferredServiceProvider::class);
	});

	test('the cache directory is successfully created', function() {
		expect(file_exists(TestState::$cachePath))->toBeTrue();
	});

	test('the cache file is successfully created and exists', function() {
		expect(file_exists(rtrim(TestState::$cachePath, '/') . '/app.php'))->toBeTrue();
	});

	test('the cache file includes the standard providers injected upon bootstrap', function() {
		$file = require rtrim(TestState::$cachePath, '/') . '/app.php';

		$providers = $file['providers'];

		expect($providers)->toContain(Providers\StandardServiceProvider::class);

	});

	test('the cache file includes the deferred providers injected upon bootstrap', function() {
		$file = require rtrim(TestState::$cachePath, '/') . '/app.php';

		$deferred = $file['deferred'];

		expect($deferred)
			->toHaveKey('deferred_provider')
			->and($deferred['deferred_provider'])
			->toContain(Providers\DeferredServiceProvider::class);

	});

	test('the cache file includes the correct aliases for deferred providers', function() {
		$file = require rtrim(TestState::$cachePath, '/') . '/app.php';

		$aliases = $file['aliases'];

		expect($aliases)
			->toHaveKey('deferred_provider')
			->and($aliases['deferred_provider'])
			->toEqual('deferred_provider');

	});
})->group('bootstrap');