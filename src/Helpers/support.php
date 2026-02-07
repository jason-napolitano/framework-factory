<?php

namespace FrameworkFactory\Helpers\Support {

    use FrameworkFactory\Support\Str;

    function str(string $string): Str
    {
        return Str::make($string);
    }

}
