<?php

namespace jaymeh\craftcurrentlyreadingwidget\services;

use yii\base\Component;
use jaymeh\craftcurrentlyreadingwidget\CurrentlyReading;
use jaymeh\craftcurrentlyreadingwidget\events\RegisterBookApiEvent;
use jaymeh\craftcurrentlyreadingwidget\contracts\BookServiceInterface;
use jaymeh\craftcurrentlyreadingwidget\exceptions\InvalidBookApiException;

/**
 * Book Api Service service
 */
class BookApiService extends Component
{
    /**
     * The registered APIs.
     *
     * @var array
     */
    protected array $apis = [];

    /**
     * Reference to the API service.
     *
     * @var BookServiceInterface
     */
    protected ?BookServiceInterface $api = null;

    /**
     * The event that is triggered when a new API is registered.
     */
    const EVENT_REGISTER_BOOK_API = 'registerBookApi';

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

        $event = new RegisterBookApiEvent([]);
        $this->trigger(self::EVENT_REGISTER_BOOK_API, $event);

        $this->apis = $event->apis;

        // Initialize all APIs
        $initializedApis = [];
        foreach ($this->apis as $key => $api) {
            if (! $this->_validateApi($api)) {
                throw new InvalidBookApiException("Invalid API class provided ($api). Please ensure it implements the BookServiceInterface.");
            }
            $initializedApis[$key] = new $api();
        }

        $this->apis = $initializedApis;

        // Load API from settings.
        $source = CurrentlyReading::getInstance()->getSettings()->getSource();
        if (! isset($initializedApis[$source])) {
            throw new InvalidBookApiException("Invalid API source provided ($source). Please ensure it is a valid key in the array.");
        }

        $this->api = $initializedApis[$source];
        return $this->api;
    }

    /**
     * Get the registered APIs.
     *
     * @return BookServiceInterface[]
     */
    public function getApis(): array
    {
        return $this->apis;
    }

    /**
     * Get the currently reading books.
     *
     * @return Book[]
     */
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
