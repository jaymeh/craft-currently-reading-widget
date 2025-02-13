<?php

namespace jaymeh\craftcurrentlyreadingwidget\data;

/**
 * Data class for a book.
 */
class Book
{
    /**
     * Book title.
     *
     * @var string
     */
    protected string $title;

    /**
     * Book author.
     *
     * @var string
     */
    protected string $author;

    /**
     * Book cover image URL.
     *
     * @var string
     */
    protected string $coverImageUrl;

    /**
     * Constructor for class.
     *
     * @param string $title         The book title.
     * @param string $author        The book author.
     * @param string $coverImageUrl The book cover image URL.
     */
    public function __construct(string $title, string $author, string $coverImageUrl)
    {
        $this->title = $title;
        $this->author = $author;
        $this->coverImageUrl = $coverImageUrl;
    }

    /**
     * Gets the book title.
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Get the book author.
     *
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * Get the cover image url.
     *
     * @return string
     */
    public function getCoverImageUrl(): string
    {
        return $this->coverImageUrl;
    }
}
