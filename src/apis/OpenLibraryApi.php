<?php

namespace jaymeh\craftcurrentlyreadingwidget\apis;

use GuzzleHttp\Client;
use jaymeh\craftcurrentlyreadingwidget\data\Book;
use jaymeh\craftcurrentlyreadingwidget\CurrentlyReading;
use jaymeh\craftcurrentlyreadingwidget\contracts\BookServiceInterface;

class OpenLibraryApi implements BookServiceInterface
{
    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
    public function getLabel(): string
    {
        return 'Open Library';
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'openlibrary';
    }

    /**
     * Get the URL for the person's currently reading list
     * 
     * @return string
     */
    protected function getPersonCurrentlyReadingUrl(): string
    {
        return 'https://openlibrary.org/people/' . $this->getPersonName() . '/books/currently-reading.json';
    }

    /**
     * Get the person's name
     * 
     * @return string
     */
    protected function getPersonName(): string
    {
        return CurrentlyReading::getInstance()->getSettings()->getPersonName();
    }

    /**
     * Get the URL for the cover image
     *
     * @param string $coverId
     * @return string
     */
    protected function getCoverImageUrl(string $coverId): string
    {
        return 'https://covers.openlibrary.org/b/id/' . $coverId . '-M.jpg';
    }
}
