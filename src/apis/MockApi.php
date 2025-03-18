<?php

namespace jaymeh\craftcurrentlyreadingwidget\apis;

use jaymeh\craftcurrentlyreadingwidget\data\Book;
use jaymeh\craftcurrentlyreadingwidget\contracts\BookServiceInterface;

class MockApi implements BookServiceInterface
{
    /**
     * {@inheritdoc}
     */
    public function getCurrentlyReading(): array
    {
        return [
            new Book('The Great Gatsby','F. Scott Fitzgerald','https://placehold.co/150'),
            new Book('The Great Gatsby','F. Scott Fitzgerald','https://placehold.co/150'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getLabel(): string
    {
        return 'Mock API';
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'mock';
    }
}
