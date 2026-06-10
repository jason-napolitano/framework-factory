<?php

namespace Tests\Providers {

    use FrameworkFactory\Contracts;
    use Tests\Services\DemoService;

    class DeferredServiceProvider extends Contracts\Providers\ServiceProvider
    {
        /**
         * @inheritdoc
         */
        public function register(): void
        {
            $this->singleton('deferred_provider', fn () => new DemoService());
        }

        /**
         * @inheritdoc
         */
        public function provides(): array
        {
            return ['deferred_provider'];
        }
    }
}
