<?php

namespace jaymeh\craftcurrentlyreadingwidget\apis;

use jaymeh\craftcurrentlyreadingwidget\contracts\BookServiceInterface;

class OpenLibraryApi implements BookServiceInterface
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        // Constructor logic here.
    }

    // Display name...
    public function getName(): string
    {
        return 'Open Library';
    }

    /**
     * {@inheritdoc}
     */
    public function getCurrentlyReading(): array
    {
        return [];
    }

    private function authenticate()
    {
        // Authentication logic here.
    }
}
