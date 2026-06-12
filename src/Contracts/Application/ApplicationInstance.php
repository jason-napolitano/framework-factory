<?php

namespace FrameworkFactory\Contracts\Application {

	use FrameworkFactory\Exceptions;
    use FrameworkFactory\Contracts;

    /**
     * This represents the application's main entrypoint instance
     */
    interface ApplicationInstance
    {
        /**
         * The initial bootstrap process which builds
         * the container, generates a built-in
         * autoloader and returns the app instance
         *
         * @param string $basePath Path the base directory
         *
         * @return self
         */
        public static function build(string $basePath): self;

        /**
         * Registers multiple service providers
         *
         * @param array $providers
         *
         * @return void
         *
         * @throws Exceptions\Container\EmptyProvidersValue
         */
        public function withProviders(array $providers): void;

        /**
         * Fires up the application to finalize the bootstrap
         * process
         *
         * @return void
         */
        public function fire(): void;

        /**
         * A collection of service providers
         *
         * @return array<string>
         */
        public static function providers(): array;

        /**
         * Return an instance of the container
         *
         * @return Contracts\Container\ContainerInstance
         */
        public static function container(): Contracts\Container\ContainerInstance;

        /**
         * Returns the current application version
         *
         * @return string
         */
//        public static function version(): string;

        /**
         * Returns the application base path
         *
         * @return string
         */
        public static function basePath(): string;
    }
}
