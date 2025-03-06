<?php

namespace jaymeh\craftcurrentlyreadingwidget\services\apis;

use jaymeh\craftcurrentlyreadingwidget\contracts\BookServiceInterface;

class MockService implements BookServiceInterface
{
    public function getCurrentlyReading(): array
    {
        return [];
    }
}
