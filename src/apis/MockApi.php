<?php

namespace jaymeh\craftcurrentlyreadingwidget\apis;

use jaymeh\craftcurrentlyreadingwidget\data\Book;
use jaymeh\craftcurrentlyreadingwidget\contracts\BookServiceInterface;

class MockApi implements BookServiceInterface
{
    public function getCurrentlyReading(): array
    {
        return [
            new Book('The Great Gatsby','F. Scott Fitzgerald','https://placehold.co/150'),
            new Book('The Great Gatsby','F. Scott Fitzgerald','https://placehold.co/150'),
        ];
    }
}
