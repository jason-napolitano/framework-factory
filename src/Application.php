<?php

namespace FrameworkFactory {

    use FrameworkFactory\Contracts\Application\ApplicationInstance;
    use FrameworkFactory\Contracts\Container\ContainerInstance;
    use FrameworkFactory\Application as App;

	/**
	 * This is the application entry point used to build and
	 * bootstrap an application. It sets up the container and
	 * configures the core libraries.
	 *
	 * USAGE:
	 * ```
	 * $app = Application::build(...);
	 *
	 * // app configuration ...
	 *
	 * $app->fire()
	 * ```
	 */
    final class Application implements ApplicationInstance
    {
        /** @var ContainerInstance $container service container */
        protected static ContainerInstance $container;

        /** @var string $version current application version */
        private static string $version = '1.0.0';

        /** @var array $providers base service providers */
        private static array $providers = [];

		protected static string $cachePath;

        /**
         * @inheritdoc
         */
        public static function build(?string $cachePath = null): self
        {
            // build a new container instance
            // container setup
            self::$container = new App\Container($cachePath);

	        // configure the facade /accessor system
	        App\Accessor::setContainer(self::$container);

            // assign and return the application instance
            return new self();
        }

        /**
         * @inheritdoc
         */
        public function withProviders(array $providers): void
        {
            if (empty($providers)) {
                throw new Exceptions\Container\EmptyProvidersValue('The providers array cannot be empty');
            }

            self::$providers = $providers;
        }

	    /**
	     * @inheritdoc
	     */
	    public function asVersion(string $version): void
	    {
		    self::$version = $version;
	    }

        /**
         * @inheritdoc
         */
        public function fire(): void
        {
            // run the bootstrap build process
            App\Bootstrap::build(self::$container, self::$providers, self::$cachePath);

            // bootstrap service providers
            self::$container->bootstrap(self::$providers);
            self::$container->bootProviders();
        }

        /**
         * @inheritdoc
         */
        public static function providers(): array
        {
            return self::$providers;
        }

        /**
         * @inheritdoc
         */
        public static function container(): ContainerInstance
        {
            return self::$container;
        }

        /**
         * @inheritdoc
         */
        public static function version(): string
        {
            return self::$version;
        }
    }
}
