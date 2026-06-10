<?php

namespace Tests\Providers {

    use FrameworkFactory\Contracts;
    use Tests\Services\DemoService;

    class StandardServiceProvider extends Contracts\Providers\ServiceProvider
    {
        /**
         * @inheritdoc
         */
        public function register(): void
        {
            $this->bind('standard_provider', fn () => new DemoService());
        }
    }
}
