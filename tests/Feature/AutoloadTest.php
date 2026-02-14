<?php

use App\DemoClass;

describe('autoload tests', function() {

	test('the autoloader calls a class that has been loaded', function() {
		$message = DemoClass::message();
		expect($message)->toBe('Hello World!');
	});

})->group('autoload');