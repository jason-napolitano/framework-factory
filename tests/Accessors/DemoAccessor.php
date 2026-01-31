<?php

namespace Tests\Accessors {

	use FrameworkFactory\Application\Accessor;

	/**
	 * @method static message(string $message): string
	 */
	class DemoAccessor extends Accessor
	{
		/** @inheritdoc */
		protected static string $key = 'standard_provider';
	}
}