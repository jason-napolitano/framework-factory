<?php

namespace FrameworkFactory\Helpers\Container {

    use FrameworkFactory\Application;

    /**
     * Returns a service that has been loaded into
     * the container
     *
     * @param string $id The ID of the loaded service
     *
     * @return mixed
     */
    function get(string $id): mixed
    {
        return Application::container()->get($id);
    }
}
