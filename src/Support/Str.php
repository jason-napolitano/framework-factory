<?php

namespace FrameworkFactory\Support {

    class Str
    {
        /** @var string $string the string to be modified */
        private static string $string;

        /** @var array|string[] $plural Array of pluralized words */
        private static array $plural = [
            '/(quiz)$/i'                     => "$1zes",
            '/^(ox)$/i'                      => "$1en",
            '/([m|l])ouse$/i'                => "$1ice",
            '/(matr|vert|ind)ix|ex$/i'       => "$1ices",
            '/(x|ch|ss|sh)$/i'               => "$1es",
            '/([^aeiouy]|qu)y$/i'            => "$1ies",
            '/(hive)$/i'                     => "$1s",
            '/(?:([^f])fe|([lr])f)$/i'       => "$1$2ves",
            '/(shea|lea|loa|thie)f$/i'       => "$1ves",
            '/sis$/i'                        => "ses",
            '/([ti])um$/i'                   => "$1a",
            '/(tomat|potat|ech|her|vet)o$/i' => "$1oes",
            '/(bu)s$/i'                      => "$1ses",
            '/(alias)$/i'                    => "$1es",
            '/(octop)us$/i'                  => "$1i",
            '/(ax|test)is$/i'                => "$1es",
            '/(us)$/i'                       => "$1es",
            '/s$/i'                          => "s",
            '/$/'                            => "s",
        ];

        /** @var array|string[] $singular Array of singular words */
        private static array $singular = [
            '/(quiz)zes$/i'                                                    => "$1",
            '/(matr)ices$/i'                                                   => "$1ix",
            '/(vert|ind)ices$/i'                                               => "$1ex",
            '/^(ox)en$/i'                                                      => "$1",
            '/(alias)es$/i'                                                    => "$1",
            '/(octop|vir)i$/i'                                                 => "$1us",
            '/(cris|ax|test)es$/i'                                             => "$1is",
            '/(shoe)s$/i'                                                      => "$1",
            '/(o)es$/i'                                                        => "$1",
            '/(bus)es$/i'                                                      => "$1",
            '/([m|l])ice$/i'                                                   => "$1ouse",
            '/(x|ch|ss|sh)es$/i'                                               => "$1",
            '/(m)ovies$/i'                                                     => "$1ovie",
            '/(s)eries$/i'                                                     => "$1eries",
            '/([^aeiouy]|qu)ies$/i'                                            => "$1y",
            '/([lr])ves$/i'                                                    => "$1f",
            '/(tive)s$/i'                                                      => "$1",
            '/(hive)s$/i'                                                      => "$1",
            '/(li|wi|kni)ves$/i'                                               => "$1fe",
            '/(shea|loa|lea|thie)ves$/i'                                       => "$1f",
            '/(^analy)ses$/i'                                                  => "$1sis",
            '/((a)naly|(b)a|(d)iagno|(p)arenthe|(p)rogno|(s)ynop|(t)he)ses$/i' => "$1$2sis",
            '/([ti])a$/i'                                                      => "$1um",
            '/(n)ews$/i'                                                       => "$1ews",
            '/(h|bl)ouses$/i'                                                  => "$1ouse",
            '/(corpse)s$/i'                                                    => "$1",
            '/(us)es$/i'                                                       => "$1",
            '/s$/i'                                                            => "",
        ];

        /** @var array|string[] $irregular Array of irregular words */
        private static array $irregular = [
            'move'   => 'moves',
            'foot'   => 'feet',
            'goose'  => 'geese',
            'sex'    => 'sexes',
            'child'  => 'children',
            'man'    => 'men',
            'tooth'  => 'teeth',
            'person' => 'people',
            'valve'  => 'valves',
        ];

        public static function make(string $string): self
        {
            self::$string = $string;
            return new self();
        }

        /**
         * Removes quotes from a string
         *
         * @return self
         */
        public function stripQuotes(): self
        {
            self::$string = $this->replace(["'", '"'], '');
            return $this;
        }

        /**
         * Return a singluarized string
         *
         * @return self
         */
        public function singular(): self
        {
            // check for irregular singular forms
            $this->pluralSingularCheck();

            // check for matches using regular expressions
            foreach (self::$singular as $pattern => $result) {
                if (preg_match($pattern, self::$string)) {
                    self::$string = preg_replace($pattern, $result, self::$string);
                }
            }

            return $this;
        }

        /**
         * Return a pluralized string
         *
         * @return self
         */
        public function plural(): self
        {
            // check for irregular plural forms
            $this->pluralSingularCheck();

            // check for matches using regular expressions
            foreach (self::$plural as $pattern => $result) {
                if (preg_match($pattern, self::$string)) {
                    self::$string = preg_replace($pattern, $result, self::$string);
                }
            }

            return $this;
        }

        /**
         * Singular / plural validation check
         *
         * @return void
         */
        private function pluralSingularCheck(): void
        {
            // check for irregular singular forms
            foreach (self::$irregular as $pattern => $result) {
                $pattern = '/' . $pattern . '$/i';
                if (preg_match($pattern, self::$string)) {
                    self::$string = preg_replace($pattern, $result, self::$string);
                }
            }
        }

        /**
         * Wrapper for trim(...)
         *
         * @return self
         */
        public function trim(): self
        {
            self::$string = trim(self::$string);
            return $this;
        }

        /**
         * Wrapper for strtolower(...)
         *
         * @return self
         *
         * @see \strtolower()
         *
         */
        public function lower(): self
        {
            self::$string = strtolower(self::$string);
            return $this;
        }

        /**
         * Wrapper for strtoupper(...)
         *
         * @return self
         *
         * @see \strtoupper()
         *
         */
        public function upper(): self
        {
            self::$string = strtoupper(self::$string);
            return $this;
        }

        /**
         * Returns a title cased string
         *
         * @return self
         */
        public function title(): self
        {
            self::$string = ucwords(self::$string);
            return $this;
        }

        /**
         * Check if a string is empty
         *
         * @return bool
         */
        public function empty(): bool
        {
            return self::$string === '';
        }

        /**
         * Converts string to a slug format
         *
         * @param
         *
         * @return self
         */
        public function slug(): self
        {
            self::$string = strtolower($this->replace(' ', '-'));
            return $this;
        }

        /**
         * Converts a string to snake case format
         *
         * @return self
         */
        public function snake(): self
        {
            self::$string = $this->replace(' ', '_');
            return $this;
        }

        /**
         * Create a dot notation string
         *
         * @return self
         */
        public function dot(): self
        {
            self::$string = $this->replace(' ', '.');
            return $this;
        }

        /**
         * Replaces characters in a string
         *
         * @param string|array<string> $search
         * @param string               $replace
         *
         * @return string
         */
        public function replace(string|array $search, string $replace): string
        {
            return str_replace($search, $replace, static::$string);
        }

        /**
         * Hashes a string using bcrypt
         *
         * @return string
         */
        public function bcrypt(): string
        {
            return password_hash(self::$string, PASSWORD_BCRYPT);
        }

        /**
         * Hashes a string using argon2i
         *
         * @return string
         */
        public function argon2i(): string
        {
            return password_hash(self::$string, PASSWORD_ARGON2I);
        }

        /**
         * Generate a UUID
         *
         * @return string
         */
        public static function uuid(): string
        {
	        $data = random_bytes(16);
	        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);

	        // Set variant to RFC 4122
	        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

	        return sprintf(
		        '%s-%s-%s-%s-%s',
		        bin2hex(substr($data, 0, 4)),
		        bin2hex(substr($data, 4, 2)),
		        bin2hex(substr($data, 6, 2)),
		        bin2hex(substr($data, 8, 2)),
		        bin2hex(substr($data, 10, 6))
	        );
        }

        public function get(): string
        {
            return self::$string;
        }
    }
}
