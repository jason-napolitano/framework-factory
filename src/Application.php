<?php

namespace FrameworkFactory {

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
    final class Application implements Contracts\Application\ApplicationInstance
    {
        /** @var Contracts\Container\ContainerInstance $container service container */
        protected static Contracts\Container\ContainerInstance $container;

        /** @var string|null $version current application version */
        private static ?string $version = null;

        /** @var array $providers base service providers */
        private static array $providers = [];

        /** @var string $basePath the base path for the application */
        protected static string $basePath;

        /** @var string $cachePath the path for the cached bootstrap file */
        protected static string $cachePath;

        /**
         * @inheritdoc
         */
        public static function build(string $basePath): self
        {
            // assign the base and cache paths
            self::$basePath = rtrim($basePath, '/') . DIRECTORY_SEPARATOR;
            self::setCachePath($basePath);

            // build a new container instance
            self::$container = new App\Container(self::$cachePath);

            // configure the facade / accessor system
            App\Accessor::setContainer(self::$container);

            // assign and return the application instance
            return new self();
        }

        /**
         * Builds the cache path location
         *
         * @param string $basePath
         *
         * @return void
         */
        private static function setCachePath(string $basePath): void
        {
            self::$cachePath = $basePath . 'cache';
        }

        /**
         * @inheritdoc
         */
        public function withProviders(array $providers): void
        {
            if (empty($providers)) {
                throw new Exceptions\Container\EmptyProvidersValue('The providers array cannot be empty');
            }

            // assign the providers
            self::$providers = $providers;
        }

        /**
         * @inheritdoc
         */
        public function asVersion(string $version): void
        {
            // assign the version
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
        public static function container(): Contracts\Container\ContainerInstance
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

        /**
         * @inheritdoc
         */
        public static function basePath(): string
        {
            return trim(self::$basePath);
        }
    }
}
