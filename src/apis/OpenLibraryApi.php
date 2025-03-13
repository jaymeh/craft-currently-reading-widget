<?php

namespace jaymeh\craftcurrentlyreadingwidget\apis;

use GuzzleHttp\Client;
use jaymeh\craftcurrentlyreadingwidget\data\Book;
use jaymeh\craftcurrentlyreadingwidget\CurrentlyReading;
use jaymeh\craftcurrentlyreadingwidget\contracts\BookServiceInterface;

class OpenLibraryApi implements BookServiceInterface
{
    public function getCurrentlyReading(): array
    {
        $client = new Client();
        $response = $client->get($this->getPersonCurrentlyReadingUrl());

        $data = json_decode($response->getBody(), true);

        foreach ($data['reading_log_entries'] as $entry) {
            $books[] = new Book(
                $entry['work']['title'],
                implode(', ', $entry['work']['author_names']),
                $this->getCoverImageUrl($entry['work']['cover_id'])
            );
        }

        return $books;
    }

    protected function getPersonCurrentlyReadingUrl(): string
    {
        return 'https://openlibrary.org/people/' . $this->getPersonName() . '/books/currently-reading.json';
    }

    protected function getPersonName(): string
    {
        return CurrentlyReading::getInstance()->getSettings()->getPersonName();
    }

    protected function getCoverImageUrl(string $coverId): string
    {
        return 'https://covers.openlibrary.org/b/id/' . $coverId . '-M.jpg';
    }
}
