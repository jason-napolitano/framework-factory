<?php


use function FrameworkFactory\Helpers\Support\str;

describe('support tests', function () {
    test('the str() helper returns a double-quoted string without quotes', function () {
        $value = str('"This is a double quoted string"')->stripQuotes()->get();
        expect($value)->toBe('This is a double quoted string');
    });

    test('the str() helper returns a single-quoted string without quotes', function () {
	    $value = str("'This is a single quoted string'")->stripQuotes()->get();
	    expect($value)->toBe('This is a single quoted string');
    });

	test('the str() helper returns a pluralized version of a word', function () {
		$value = str('cat')->plural()->get();
		expect($value)->toBe('cats');
	});

	test('the str() helper returns a singular version of a word', function () {
		$value = str('cats')->singular()->get();
		expect($value)->toBe('cat');
	});

	test('the str() helper returns a string that has been converted to a dot notation format', function () {
		$value = str('this is a sentence')->dot()->get();
		expect($value)->toBe('this.is.a.sentence');
	});

	test('the str() helper returns a string that has been converted to a snake format', function () {
		$value = str('this is a sentence')->snake()->get();
		expect($value)->toBe('this_is_a_sentence');
	});

	test('the str() helper returns a string that has been converted to a title format', function () {
		$value = str('this is a sentence')->title()->get();
		expect($value)->toBe('This Is A Sentence');
	});

	test('the str() helper returns a string that has been converted to a slug format', function () {
		$value = str('this is a sentence')->slug()->get();
		expect($value)->toBe('this-is-a-sentence');
	});

	test('the str() helper returns a string that has been converted to a lowercase format', function () {
		$value = str('WoRD')->lower()->get();
		expect($value)->toBe('word');
	});

	test('the str() helper returns a string that has been converted to an uppercase format', function () {
		$value = str('wOrd')->upper()->get();
		expect($value)->toBe('WORD');
	});

	test('the str() helper returns confirms whether or not a string\'s value is empty', function () {
		$value = str('')->empty();
		expect($value)->toBeTrue();
	});

	test('the str() helper returns the str() helper returns a string that has been properly trimmed', function () {
		$value = str('   word   ')->trim()->get();
		expect($value)->toBe('word');
	});

	test('\FrameworkFactory\Support\Str returns a valid v4 UUID', function () {
		$value = \FrameworkFactory\Support\Str::uuid();
		expect($value)->toBeUuid();
	});

	test('the str() helper returns a bcrypt representation of a string', function () {
		$password = 'secret';
		$hash = password_hash($password, PASSWORD_BCRYPT);

		expect(password_verify($password, $hash))->toBeTrue();
	});

	test('the str() helper returns an argon2i representation of a string', function () {
		$password = 'secret';
		$hash = password_hash($password, PASSWORD_ARGON2I);

		expect(password_verify($password, $hash))->toBeTrue();
	});
})->group('support');
