<?php

namespace FrameworkFactory\Application\Bootstrap {

    /**
     * A fluent API based class that is used as a replacement
     * for var_export().
     *
     * Used internally when creating the cache file during the
     * bootstrap process
     */
    final class Formatter
    {
        /** @var string $indentChar default indentation character */
        private string $indentChar = '    ';

        /** @var int $maxDepth max depth */
        private int $maxDepth = 10;

        /** @var bool $shortArrays use short arrays? */
        private bool $shortArrays = true;

        /** @var bool $stripNumericKeys strip numeric keys? */
        private bool $stripNumericKeys = false;

        /**
         * Build process
         *
         * @return self
         */
        public static function make(): self
        {
            return new self();
        }

        /**
         * Indents with spaces
         *
         * @return $this
         */
        public function indentWithSpaces(int $count): self
        {
            $this->indentChar = str_repeat(' ', $count);
            return $this;
        }

        /**
         * Indents with tabs
         *
         * @return $this
         */
        public function indentWithTabs(): self
        {
            $this->indentChar = "\t";
            return $this;
        }

        /**
         * Modifies the max depth
         *
         * @param int $depth
         *
         * @return $this
         */
        public function maxDepth(int $depth): self
        {
            $this->maxDepth = $depth;
            return $this;
        }

        /**
         * Strips numeric keys
         *
         * @param bool $state
         *
         * @return $this
         */
        public function stripNumericKeys(bool $state = true): self
        {
            $this->stripNumericKeys = $state;
            return $this;
        }

        /**
         * Export function
         *
         * @param mixed $value
         *
         * @return string
         */
        public function export(mixed $value): string
        {
            return $this->format($value, 0);
        }

        /**
         * Internal formatter
         *
         * @param mixed $value
         * @param int   $depth
         *
         * @return string
         */
        private function format(mixed $value, int $depth): string
        {
            if ($depth > $this->maxDepth) {
                return '/* max depth reached */';
            }

            return match (true) {
                is_array($value) => $this->formatArray($value, $depth),
                is_object($value) => $this->formatObject($value, $depth),
                is_string($value) => "'" . addslashes($value) . "'",
                is_bool($value) => $value ? 'true' : 'false',
                is_null($value) => 'null',
                is_int($value),
                is_float($value) => (string)$value,
                default => 'null',
            };
        }

        /**
         * Array formatter
         *
         * @param array $array
         * @param int   $depth
         *
         * @return string
         */
        private function formatArray(array $array, int $depth): string
        {
            if ($array === []) {
                return '[]';
            }

            $space = $this->indent($depth);
            $inner = $this->indent($depth + 1);

            $lines = [];
            $isList = array_is_list($array);

            foreach ($array as $key => $value) {
                $v = $this->format($value, $depth + 1);

                if ($isList && $this->stripNumericKeys) {
                    $lines[] = "{$inner}{$v},";
                    continue;
                }

                $k = is_int($key)
                    ? $key
                    : "'" . addslashes((string)$key) . "'";

                $lines[] = "{$inner}{$k} => {$v},";
            }

            return "[\n"
                . implode("\n", $lines)
                . "\n{$space}]";
        }

        /**
         * Object formatter
         *
         * @param object $object
         * @param int    $depth
         *
         * @return string
         */
        private function formatObject(object $object, int $depth): string
        {
            $class = get_class($object);
            $props = get_object_vars($object);

            if ($props === []) {
                return "new {$class}()";
            }

            $space = $this->indent($depth);
            $inner = $this->indent($depth + 1);

            $lines = [];

            foreach ($props as $key => $value) {
                $v = $this->format($value, $depth + 1);
                $lines[] = "{$inner}'{$key}' => {$v},";
            }

            return "new {$class}([\n"
                . implode("\n", $lines)
                . "\n{$space}])";
        }

        /**
         * Indentation formatting
         *
         * @param int $depth
         *
         * @return string
         */
        private function indent(int $depth): string
        {
            return str_repeat($this->indentChar, $depth);
        }
    }
}
