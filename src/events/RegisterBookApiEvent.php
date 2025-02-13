<?php

namespace jaymeh\craftcurrentlyreadingwidget\events;

use yii\base\Event;

class RegisterBookApiEvent extends Event
{
    /**
     * Classes used for the API.
     *
     * @var string[]
     */
    public array $apis;
}
