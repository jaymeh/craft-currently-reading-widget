<?php

namespace jaymeh\craftcurrentlyreadingwidget\contracts;

/**
 * Book Api Service service
 */
interface BookServiceInterface
{
    /**
     * Returns a list of books currently being read.
     *
     * @return Book[]
     */
    public function getCurrentlyReading(): array;

    /**
     * Get the label for the book service. This will be used to identify the book service in the settings.
     *
     * @return string
     */
    public function getLabel(): string;

    /**
     * Get the name for the book service. This will be used as the key for the book service.
     *
     * @return string
     */
    public function getName(): string;
}
