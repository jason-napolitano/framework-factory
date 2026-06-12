<?php

namespace FrameworkFactory\Application\Traits {

	/**
	 * Allows for application configuration to be dynamically
	 * assigned, and retrieved for each application instance.
	 *
	 * Config getters:
	 * @method static description(): string
	 * @method static version(): string
	 * @method static authors(): array
	 * @method static title(): string
	 *
	 * Config setters:
	 * @method setDescription(string $description): void
	 * @method setAuthors(array $authors): void
	 * @method setVersion(string $title): void
	 * @method setTitle(string $title): void
	 */
	trait HasOptions
	{
		/** @var array|string[] $options configurable options */
		private static array $options = [
			'description',
			'version',
			'authors',
			'title',
		];

		/**
		 * Return the config option from the options array,
		 * or null otherwise
		 *
		 * @param string $name
		 * @param array  $arguments
		 *
		 * @return string
		 */
		public static function __callStatic(string $name, array $arguments)
		{
			return self::$options[$name] ?? null;
		}

		/**
		 * Set the value of an option and return an instance
		 * of the application for method chaining
		 *
		 * @param string $method
		 * @param array  $arguments
		 *
		 * @return $this
		 */
		public function __call(string $method, array $arguments)
		{
			try {
				$option = lcfirst(substr($method, 3));
				self::$options[$option] = $arguments[0] ?? null;
				return $this;

			} catch (\Throwable) {
				throw new \BadMethodCallException(
					sprintf('%s::%s() does not exist.', static::class, $method)
				);
			}
		}
	}
}