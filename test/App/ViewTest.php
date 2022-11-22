<?php

namespace Project\PHP\Login\App;
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;

class ViewTest  extends TestCase
{
    public function testRender()
    {
        View::render('Home/index', [
            "PHP Login Management"
        ]);
    
        $this->expectOutputRegex['PHP Login Management'];
        $this->expectOutputRegex['body'];
        $this->expectOutputRegex['html'];
        $this->expectOutputRegex['Register'];

    }
    
}