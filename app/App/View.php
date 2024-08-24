<?php

namespace Rusdianto\Gevac\App;

class View
{
    public static function render(string $view, $model): void
    {
        require __DIR__ . "/../View/header.php";
        if ($view != "User/login") {
            require __DIR__ . "/../View/Component/navbar.php";
        }
        require __DIR__ . "/../View/" . $view . ".php";
        require __DIR__ . "/../View/footer.php";
    }

    public static function redirect(string $url)
    {
        header("Location: $url");
        if (getenv("mode") != "test") {
            exit();
        }
    }
}
