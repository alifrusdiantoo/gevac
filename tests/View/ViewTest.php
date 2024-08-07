<?php

namespace Rusdianto\Gevac\View;

use PHPUnit\Framework\TestCase;
use Rusdianto\Gevac\App\View;

class ViewTest extends TestCase
{
    public function testRender()
    {
        View::render("Peserta/index", [
            "title" => "Gevac | Data Peserta"
        ]);

        $this->expectOutputRegex("[head]");
        $this->expectOutputRegex("[Gevac | Data Peserta]");
        $this->expectOutputRegex("[html]");
        $this->expectOutputRegex("[body]");
    }
}
