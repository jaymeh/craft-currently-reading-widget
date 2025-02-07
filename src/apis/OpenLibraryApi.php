<?php

namespace jaymeh\craftcurrentlyreadingwidget\apis;

use jaymeh\craftcurrentlyreadingwidget\contracts\BookServiceInterface;

class OpenLibraryApi implements BookServiceInterface
{
    public function __construct(array $config = [])
    {
        // Constructor logic here.
    }
}