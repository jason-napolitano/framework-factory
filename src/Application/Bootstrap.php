<?php

namespace FrameworkFactory\Application {

    use FrameworkFactory\Exceptions\FileSystem\DirectoryNotCreated;
    use FrameworkFactory\Contracts\Container\ContainerInstance;
    use FrameworkFactory\Contracts\Providers\ServiceProvider;
    use FrameworkFactory\Application\Bootstrap\Formatter;

    class Bootstrap
    {
        /**
         * Bootstraps the application by creating a cache file
         *
         * @param ContainerInstance      $container
         * @param array<ServiceProvider> $providers
         * @param string                 $cachePath
         *
         * @return void
         */
        public static function build(ContainerInstance $container, array $providers, string $cachePath): void
        {
            $eager = [];
            $deferred = [];
            $aliases = [];

            foreach ($providers as $provider) {
                $instance = new $provider($container);
                $services = $instance->provides();

                if ($services) {
                    foreach ($services as $service) {
                        $deferred[$service] = $provider;
                        $aliases[$service] = $service;
                    }
                } else {
                    $eager[] = $provider;
                }
            }

            $cache = [
                'providers' => $eager,
                'deferred'  => $deferred,
                'aliases'   => $aliases,
            ];

            if (!is_dir($cachePath) && !mkdir($cachePath, 0775, true) && !is_dir($cachePath)) {
                throw new DirectoryNotCreated(sprintf('Directory "%s" was not created', $cachePath));
            }

            file_put_contents(rtrim($cachePath, '/') . '/app.php', self::export($cache));
        }

        /**
         * Exports the contents of the cache file
         *
         * @param array $data
         *
         * @return string
         */
        protected static function export(array $data): string
        {
            return "<?php\n\nreturn " . Formatter::make()->indentWithTabs()->export($data) . ";\n";
        }
    }
}
