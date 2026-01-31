<?php

namespace FrameworkFactory\Contracts\Providers {

    use FrameworkFactory\Contracts\Container\ContainerInstance;

    abstract class ServiceProvider
    {
        /** @var ContainerInstance $container container instance */
        protected ContainerInstance $container;

        /**
         * Builds a new service provider
         *
         * @param ContainerInstance $container
         */
        public function __construct(ContainerInstance $container)
        {
            $this->container = $container;
        }

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
