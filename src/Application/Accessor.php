<?php

namespace FrameworkFactory\Application {

    use FrameworkFactory\Exceptions;
    use FrameworkFactory\Contracts;

    /**
     * The Accessor class acts a facade system. It grants
     * access to services that are bound to the container
     */
    abstract class Accessor
    {
        /** @var Contracts\Container\ContainerInstance $container the container instance */
        private static Contracts\Container\ContainerInstance $container;

        /** @var string $key the key used to resolve the container binding */
        protected static string $key;

        /**
         * Set the container which will be used for
         * binding resolution
         *
         * @param Contracts\Container\ContainerInstance $container
         *
         * @return void
         */
        public static function setContainer(Contracts\Container\ContainerInstance $container): void
        {
            static::$container = $container;
        }

        /**
         * Container bindings resolver
         *
         * @return mixed
         */
        protected static function resolve(): mixed
        {
            if (!isset(static::$container)) {
                throw new Exceptions\Container\ContainerException('Application container has not been set.');
            }

            return static::$container->get(static::$key);
        }

        /**
         * Forward the static calls to the bound
         * instance
         *
         * @param string $method
         * @param array  $arguments
         *
         * @return mixed
         */
        public static function __callStatic(string $method, array $arguments)
        {
            $instance = static::resolve();

            if (!method_exists($instance, $method)) {
                throw new \BadMethodCallException(
                    sprintf('Method %s::%s does not exist.', get_class($instance), $method)
                );
            }

            return $instance->$method(...$arguments);
        }
    }
}
