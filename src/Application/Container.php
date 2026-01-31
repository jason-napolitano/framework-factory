<?php

namespace FrameworkFactory\Application {

    use FrameworkFactory\Contracts\Container\ContainerInstance;
    use FrameworkFactory\Exceptions\Container\ServiceNotFound;
    use FrameworkFactory\Contracts\Container\ContextBuilder;
    use FrameworkFactory\Application\Context\Builder;

    class Container implements ContainerInstance
    {
        /** @var array $bindings container bindings */
        protected array $bindings = [];

        /** @var array $singletons singleton instances */
        protected array $singletons = [];

        /** @var array $aliases binding aliases */
        protected array $aliases = [];

        /** @var array $providers service providers */
        protected array $providers = [];

        /** @var bool $booted has a provider been booted? */
        protected bool $booted = false;

        /** @var array $deferred deferred providers */
        protected array $deferred = [];

        /** @var array $loadedProviders loaded providers */
        protected array $loadedProviders = [];

        /** @var array $afterResolving hooks for after a provider is loaded */
        protected array $afterResolving  = [];

        /** @var array $beforeResolving hooks for before a provider is loaded */
        protected array $beforeResolving = [];

        /** @var array $contextual lookup table of context overrides */
        protected array $contextual = [];

        /** @var array $buildStack current context build stack */
        protected array $buildStack = [];

        /** @var string $cacheFile the cached bootstrap file */
        protected string $cacheFile;

        /**
         * Builds the container instance
         *
         * @param string|null $cachePath Path to the cache directory
         */
        public function __construct(?string $cachePath = null)
        {
            $this->cacheFile = rtrim($cachePath, '/') . '/app.php';
        }

        /**
         * @inheritdoc
         */
        public function bind(string $id, callable $factory): void
        {
            $this->bindings[$id] = $factory;
        }

        /**
         * @inheritdoc
         */
        public function singleton(string $id, callable $factory): void
        {
            $this->bindings[$id] = function ($c) use ($id, $factory) {
                return $this->instances[$id] ??= $factory($c);
            };
        }

        /**
         * @inheritdoc
         */
        public function when(string $concrete): ContextBuilder
        {
            return new Builder($this, $concrete);
        }

        /**
         * @inheritdoc
         */
        public function addContextualBinding(string $concrete, string $abstract, callable|string $implementation): void
        {
            $this->contextual[$concrete][$abstract] = $implementation;
        }

        protected function resolveWithContext(string $id): mixed
        {
            // If resolving as a dependency of something else
            if (count($this->buildStack) > 1) {
                $parent = $this->buildStack[count($this->buildStack) - 2];

                if (isset($this->contextual[$parent][$id])) {
                    $concrete = $this->contextual[$parent][$id];

                    return is_callable($concrete)
                        ? $concrete($this)
                        : new $concrete();
                }
            }

            // Default binding
            return ($this->bindings[$id])($this);
        }

        /**
         * @inheritdoc
         */
        public function beforeResolving(string $id, callable $callback): void
        {
            $this->beforeResolving[$id][] = $callback;
        }

        /**
         * @inheritdoc
         */
        public function afterResolving(string $id, callable $callback): void
        {
            $this->afterResolving[$id][] = $callback;
        }

        /**
         * @inheritdoc
         */
        public function alias(string $alias, string $id): void
        {
            $this->aliases[$alias] = $id;
        }

        /**
         * @inheritdoc
         */
        public function get(string $id): mixed
        {
            $id = $this->aliases[$id] ?? $id;

            if (isset($this->instances[$id])) {
                return $this->instances[$id];
            }

            $this->buildStack[] = $id;

            try {
                foreach ($this->beforeResolving[$id] ?? [] as $cb) {
                    $cb($this, $id);
                }

                if (! isset($this->bindings[$id])) {
                    $this->loadDeferredProvider($id);
                }

                if (! isset($this->bindings[$id])) {
                    throw new ServiceNotFound("Service [$id] not bound.");
                }

                $object = $this->resolveWithContext($id);

                foreach ($this->afterResolving[$id] ?? [] as $cb) {
                    $cb($this, $object);
                }

                return $this->singletons[$id] = $object;
            } finally {
                array_pop($this->buildStack);
            }
        }

        /**
         * @inheritdoc
         */
        public function has(string $id): bool
        {
            return isset($this->bindings[$id]) || isset($this->aliases[$id]);
        }

        /**
         * @inheritdoc
         */
        public function registerProvider(string $provider): void
        {
            if (isset($this->loadedProviders[$provider])) {
                return;
            }

            $this->loadedProviders[$provider] = true;
            $this->providers[] = $provider;

            new $provider($this)->register();
        }

        protected function loadDeferredProvider(string $service): void
        {
            if (! isset($this->deferred[$service])) {
                return;
            }

            $provider = $this->deferred[$service];

            unset($this->deferred[$service]);

            $this->registerProvider($provider);
        }

        /**
         * Run the providers' boot methods
         *
         * @return void
         */
        public function bootProviders(): void
        {
            if ($this->booted) {
                return;
            }

            foreach ($this->providers as $provider) {
                new $provider($this)->boot();
            }

            $this->booted = true;
        }

        /**
         * @inheritdoc
         */
        public function bootstrap(array $providers): void
        {
            if ($this->cacheFileExists()) {
                $this->loadCache();
                return;
            }

            foreach ($providers as $provider) {
                $this->registerProvider($provider);
            }
        }

        /**
         * Does the cache file exist?
         *
         * @return bool
         */
        protected function cacheFileExists(): bool
        {
            return file_exists($this->cacheFile);
        }

        /**
         * Loads the cached file
         *
         * @return void
         */
        protected function loadCache(): void
        {
            $data = require $this->cacheFile;

            $this->deferred = $data['deferred'] ?? [];

            foreach ($data['aliases'] as $alias => $id) {
                $this->alias($alias, $id);
            }

            foreach ($data['providers'] as $provider) {
                $this->registerProvider($provider);
            }
        }

        /**
         * @inheritdoc
         */
        public function providers(): array
        {
            return $this->providers;
        }
    }
}
