<?php

namespace FrameworkFactory\Contracts\Container {

    use Psr\Container\ContainerInterface as PsrContainerInterface;

	/**
	 * This represents the PSR-11 container instance
	 */
    interface ContainerInstance extends PsrContainerInterface
    {
        /**
         * Binds a service to the container
         *
         * @param string   $id
         * @param callable $factory
         *
         * @return void
         */
        public function bind(string $id, callable $factory): void;

        /**
         * Binds a singleton service to the container
         *
         * @param string   $id
         * @param callable $factory
         *
         * @return void
         */
        public function singleton(string $id, callable $factory): void;

        /**
         * Context binding for the container
         *
         * @param string $concrete
         *
         * @return ContextBuilder
         */
        public function when(string $concrete): ContextBuilder;

        /**
         * Adds a context binding to the container
         *
         * @param string          $concrete
         * @param string          $abstract
         * @param callable|string $implementation
         *
         * @return void
         */
        public function addContextualBinding(string $concrete, string $abstract, callable|string $implementation): void;

        /**
         * A hook that is used to run before a provider
         * has been resolved
         *
         * @param string   $id
         * @param callable $callback
         *
         * @return void
         */
        public function beforeResolving(string $id, callable $callback): void;

        /**
         * A hook that is used to run after a provider
         * has been resolved
         *
         * @param string   $id
         * @param callable $callback
         *
         * @return void
         */
        public function afterResolving(string $id, callable $callback): void;

        /**
         * Assign an alias to a binding
         *
         * @param string $alias
         * @param string $id
         *
         * @return void
         */
        public function alias(string $alias, string $id): void;

        /**
         * Registers a service provider
         *
         * @param string $provider
         *
         * @return void
         */
        public function registerProvider(string $provider): void;

        /**
         * Bootstraps an array of providers
         *
         * @param array $providers
         *
         * @return void
         */
        public function bootstrap(array $providers): void;

        /**
         * Returns an array of currently registered service
         * providers
         *
         * @return array
         */
        public function providers(): array;
    }
}
