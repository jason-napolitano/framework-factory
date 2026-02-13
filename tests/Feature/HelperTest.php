<?php

use function FrameworkFactory\Helpers\Container\get;

describe('helper tests', function () {
    test('the get() helper function calls services loaded into the container', function () {
        /** @var \Tests\Services\DemoService $message */
        $message = get('standard_provider')->message('hello world');

        expect($message)->toBe('hello world');
    });
})->group('helpers');
