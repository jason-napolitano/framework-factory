<?php

use Tests\Accessors;

describe('accessor tests', function() {
	test('services loaded into the container can be accessed via accessors', function() {
		$message = Accessors\DemoAccessor::message('hello world');

		expect($message)->toBe('hello world');
	});
})->group('accessors');
