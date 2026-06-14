<?php

use FrameworkFactory\Application;
use FrameworkFactory\Contracts;

describe('bootstrap tests', function () {
    test('the application bootstrap build process completes properly', function () {
        expect(Tests\TestState::$app)->toBeInstanceOf(Contracts\Application\ApplicationInstance::class);
    });

    test('the application instance\'s custom config values can be assigned values using method chaining', function () {
        Tests\TestState::$app
            ->setTitle('My Application')
            ->setCustomUrl('https://google.com')
            ->setVersion('1.2.3')
            ->setAuthors([
                'John Doe',
                'Jane Doe',
            ]);

        expect(Application::title())->toBe('My Application')
            ->and(Application::customUrl())->toBe('https://google.com')
            ->and(Application::version())->toBe('1.2.3')
            ->and(Application::authors())->toBe([
                'John Doe',
                'Jane Doe',
            ]);

    });

})->group('bootstrap');
