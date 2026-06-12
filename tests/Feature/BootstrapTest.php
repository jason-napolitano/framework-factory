<?php

use FrameworkFactory\Application;
use FrameworkFactory\Contracts;

describe('bootstrap tests', function () {
	test('the application bootstrap build process completes properly', function () {
		expect(Tests\TestState::$app)->toBeInstanceOf(Contracts\Application\ApplicationInstance::class);
	});

	test('the application config values can be assigned values using method chaining', function () {
		Tests\TestState::$app
			->setTitle('My Application')
			->setVersion('1.2.3')
			->setAuthors([
				'John Doe',
				'Jane Doe',
			]);

		expect(Application::title())->toBe('My Application')
			->and(Application::version())->toBe('1.2.3')
			->and(Application::authors())->toBe([
				'John Doe',
				'Jane Doe',
			]);

	});
})->group('bootstrap');
