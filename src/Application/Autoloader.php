<?php

namespace FrameworkFactory\Application {

    class Autoloader
    {
        /** @var array<string, array<int, string>> $prefixes */
        protected array $prefixes = [];

        /**
         * Register loader with SPL.
         *
         * @return void
         */
        public function register(): void
        {
            spl_autoload_register([$this, 'loadClass']);
        }

        /**
         * Add a PSR-4 namespace prefix.
         *
         * @param string $prefix
         * @param string $baseDir
         * @param bool   $prepend
         *
         * @return self
         */
        public function addNamespace(string $prefix, string $baseDir, bool $prepend = false): self
        {
            $prefix = trim($prefix, '\\') . '\\';
            $baseDir = rtrim($baseDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

            if (!isset($this->prefixes[$prefix])) {
                $this->prefixes[$prefix] = [];
            }

            if ($prepend) {
                array_unshift($this->prefixes[$prefix], $baseDir);
            } else {
                $this->prefixes[$prefix][] = $baseDir;
            }

            return $this;
        }

        /**
         * Load a class.
         *
         * @param string $class
         *
         * @return bool
         */
        public function loadClass(string $class): bool
        {
            if (isset($this->classmap[$class])) {
                require $this->classmap[$class];
                return true;
            }

            $prefix = $class;

            while (false !== $pos = strrpos($prefix, '\\')) {
                $prefix = substr($class, 0, $pos + 1);
                $relativeClass = substr($class, $pos + 1);

                if ($this->loadMappedFile($prefix, $relativeClass)) {
                    return true;
                }

                $prefix = rtrim($prefix, '\\');
            }

            return false;
        }

        /**
         * Attempt to load a mapped file.
         *
         * @param string $prefix
         * @param string $relativeClass
         *
         * @return bool
         */
        protected function loadMappedFile(string $prefix, string $relativeClass): bool
        {
            if (!isset($this->prefixes[$prefix])) {
                return false;
            }

            foreach ($this->prefixes[$prefix] as $baseDir) {
                $file = $baseDir
                    . str_replace('\\', DIRECTORY_SEPARATOR, $relativeClass)
                    . '.php';

                if ($this->requireFile($file)) {
                    return true;
                }
            }

            return false;
        }

        /**
         * Require the file if it exists.
         *
         * @param string $file
         *
         * @return bool
         */
        protected function requireFile(string $file): bool
        {
            if (file_exists($file)) {
                require $file;
                return true;
            }

            return false;
        }
    }
}
