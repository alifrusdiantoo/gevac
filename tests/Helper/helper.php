<?php

namespace Rusdianto\Gevac\App {
    // Make dummy method header from PHP for unit test
    function header(string $value)
    {
        echo $value;
    }
}

namespace Rusdianto\Gevac\Middleware {
    function header(string $value)
    {
        echo $value;
    }
}

namespace Rusdianto\Gevac\Service {
    function setcookie(string $name, string $value)
    {
        echo "$name: $value";
    }
}
