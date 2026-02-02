<?php

/*
 * The helpers contained within this namespace are there to assist
 * in working with the container using a procedural API.
 */
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
