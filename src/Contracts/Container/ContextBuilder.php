<?php

namespace FrameworkFactory\Contracts\Container {

	/**
	 * This represents to context builder's fluent API
	 */
    interface ContextBuilder
    {
        /**
         * Chooses which binding the conditional rule is for
         *
         * @param string $abstract
         *
         * @return $this
         */
        public function needs(string $abstract): self;

        /**
         * Called when a binding calls need() to override a dependency
         *
         * @param callable|string $implementation
         *
         * @return void
         */
        public function give(callable|string $implementation): void;
    }
}
