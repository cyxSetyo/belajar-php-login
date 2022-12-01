<?php
namespace Project\PHP\Login\Middleware;

interface Middleware
{
    function before() : void;
}