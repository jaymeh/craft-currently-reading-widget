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

    // TODO: Add a label method.

    // TODO: Add a name method.
}
