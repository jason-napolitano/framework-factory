<?php

use FrameworkFactory\Contracts\Application\ApplicationInstance;
use Tests\Providers\DemoServiceProvider;
use FrameworkFactory\Application;
use Tests\TestState;

test('the application bootstrap build process completes properly', function() {
	expect(TestState::$app)->toBeInstanceOf(ApplicationInstance::class);
});

test('the version number can be assigned to the application', function () {
	TestState::$app->asVersion('1.2.3');
	expect(Application::version())->toBe('1.2.3');
});

test('providers can be successfully added to the container', function() {
	expect(Application::providers())->toContain(DemoServiceProvider::class);
});

test('the cache directory is successfully created', function() {
	expect(file_exists(TestState::$cachePath))->toBeTrue();
});

test('the cache file is successfully created and exists', function() {
	expect(file_exists(rtrim(TestState::$cachePath, '/') . '/app.php'))->toBeTrue();
});

test('the cache file includes the providers injected upon bootstrap', function() {
	$file = require rtrim(TestState::$cachePath, '/') . '/app.php';

	$deferred = $file['deferred'];

	expect($deferred)
		->toHaveKey('demo')
		->and($deferred['demo'])
		->toContain(DemoServiceProvider::class);

});