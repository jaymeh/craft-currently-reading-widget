<?php

namespace jaymeh\craftcurrentlyreadingwidget\services;

use yii\base\Component;
use jaymeh\craftcurrentlyreadingwidget\events\RegisterBookApiEvent;
use jaymeh\craftcurrentlyreadingwidget\contracts\BookServiceInterface;
use jaymeh\craftcurrentlyreadingwidget\exceptions\InvalidBookApiException;

/**
 * Book Api Service service
 */
class BookApiService extends Component
{
    /**
     * Reference to the API service.
     *
     * @var BookServiceInterface
     */
    protected BookServiceInterface $api;

    /**
     * Constructor for class.
     */
    public function __construct()
    {
        $this->api = $this->getApi();
    }

    /**
     * Get the Book API to use.
     *
     * @return BookServiceInterface
     */
    protected function getApi(): BookServiceInterface
    {
        // Fire off event to allow other plugins to register their own apis.
        $apis = [];

        $event = new RegisterBookApiEvent(['apis' => $apis]);

        $this->trigger(RegisterBookApiEvent::class, $event);

        // Loop through the apis and validate them.
        foreach ($event->apis as $api) {
            if (! $this->_validateApi($api)) {
                // Throw an exception.
                throw new InvalidBookApiException("Invalid API class provided ($api). Please ensure it implements the BookServiceInterface.");
            }

            $apis[] = new $api();
        }

        // Determine the api to use.
        return $apis[0];

        // This could come from configuration or an ENV Variable.
    }

    /**
     * Validates the API class.
     *
     * @param string $apiClass The class to validate.
     *
     * @return boolean
     */
    private function _validateApi(string $apiClass): bool
    {
        // Get the class, check it implements the interface.
        $reflection = new \ReflectionClass($apiClass);

        return $reflection->implementsInterface(BookServiceInterface::class);
    }
}
