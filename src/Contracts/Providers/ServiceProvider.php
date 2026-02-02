<?php

namespace FrameworkFactory\Contracts\Providers {

    use FrameworkFactory\Contracts\Container\ContainerInstance;

	/**
	 * This class is to be extended by all service providers
	 */
    abstract class ServiceProvider
    {
        /**
         * Builds a new service provider
         *
         * @param ContainerInstance $container container instance
         */
        public function __construct(protected ContainerInstance $container) {}

        /**
         * Registers new container bindings
         *
         * @return void
         */
        public function register(): void
        {
            // ...
        }

        /**
         * Deferred binding ID(s)
         *
         * @return array
         */
        public function provides(): array
        {
            return [];
        }

        /**
         * Boots after all providers are registered
         *
         * @return void
         */
        public function boot(): void
        {
            // ...
        }
    }
}
