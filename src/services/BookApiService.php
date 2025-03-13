<?php

namespace jaymeh\craftcurrentlyreadingwidget\services;

use yii\base\Component;
use jaymeh\craftcurrentlyreadingwidget\CurrentlyReading;
use jaymeh\craftcurrentlyreadingwidget\events\RegisterBookApiEvent;
use jaymeh\craftcurrentlyreadingwidget\contracts\BookServiceInterface;
use jaymeh\craftcurrentlyreadingwidget\apis\MockApi;
use jaymeh\craftcurrentlyreadingwidget\apis\OpenLibraryApi;
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
    protected ?BookServiceInterface $api = null;

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
     * @throws InvalidBookApiException If the API is invalid.
     *
     * @return BookServiceInterface
     */
    public function getApi(): BookServiceInterface
    {
        if ($this->api) {
            return $this->api;
        }

        // Fire off event to allow other plugins to register their own apis.
        $apis = [
            'mock'        => MockApi::class,
            'openlibrary' => OpenLibraryApi::class,
        ];

        $event = new RegisterBookApiEvent(['apis' => $apis]);
        $this->trigger(RegisterBookApiEvent::class, $event);

        // Initialize all APIs
        $initializedApis = [];
        foreach ($event->apis as $key => $api) {
            if (! $this->_validateApi($api)) {
                throw new InvalidBookApiException("Invalid API class provided ($api). Please ensure it implements the BookServiceInterface.");
            }
            $initializedApis[$key] = new $api();
        }

        // Load API from settings.
        $source = CurrentlyReading::getInstance()->getSettings()->getSource();
        if (! isset($initializedApis[$source])) {
            throw new InvalidBookApiException("Invalid API source provided ($source). Please ensure it is a valid key in the array.");
        }

        $this->api = $initializedApis[$source];
        return $this->api;
    }

    public function getCurrentlyReading(): array
    {
        return $this->getApi()->getCurrentlyReading();
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
