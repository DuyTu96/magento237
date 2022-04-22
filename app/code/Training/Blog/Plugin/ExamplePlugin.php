<?php

namespace Training\Blog\Plugin;

class ExamplePlugin
{
    public function beforeGetData()
    {
        dd(123);
        $title = $title . " to ";
        echo __METHOD__ . "</br>";

        return [$title];
    }
}
