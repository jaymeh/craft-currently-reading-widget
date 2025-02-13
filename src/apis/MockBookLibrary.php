<?php

namespace jaymeh\craftcurrentlyreadingwidget\apis;

use jaymeh\craftcurrentlyreadingwidget\contracts\BookServiceInterface;

class MockBookLibrary implements BookServiceInterface
{
    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public function getCurrentlyReading(): array
    {
        return [];
    }
}
