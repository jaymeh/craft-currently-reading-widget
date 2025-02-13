<?php

namespace jaymeh\craftcurrentlyreadingwidget\factories;

use jaymeh\craftcurrentlyreadingwidget\events\RegisterBookApiEvent;
use jaymeh\craftcurrentlyreadingwidget\contracts\BookServiceInterface;

class BookApiFactory
{
    /**
     * Creates a new instance of the book API.
     *
     * @param string $api The API to create.
     *
     * @return BookServiceInterface
     *
     * @throws InvalidBookApiException If the API is invalid.
     */
    public static function create(string $api): BookServiceInterface
    {
        $event = new RegisterBookApiEvent();
        $event->apis = [];

        Event::trigger(static::class, static::EVENT_REGISTER_BOOK_API, $event);

        if (!in_array($api, $event->apis)) {
            throw new InvalidBookApiException('Invalid book API.');
        }

        return new $api();
    }
}
