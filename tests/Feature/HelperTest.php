<?php

use FrameworkFactory\Application;

describe('helper tests', function () {
    test('Application::get() calls services that have been bound to the container', function () {
        /** @var \Tests\Services\DemoService $message */
        $message = Application::get('standard_provider')->message('hello world');

        expect($message)->toBe('hello world');
    });
})->group('helpers');
