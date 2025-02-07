<?php

namespace jaymeh\craftcurrentlyreadingwidget;

use Craft;
use craft\base\Plugin;
use jaymeh\craftcurrentlyreadingwidget\services\BookApiService;

/**
 * Currently Reading Widget plugin
 *
 * @method static CurrentlyReading getInstance()
 * @author Jaymeh <contact@jaymeh.co.uk>
 * @copyright Jaymeh
 * @license https://craftcms.github.io/license/ Craft License
 * @property-read BookApiService $bookApiService
 */
class CurrentlyReading extends Plugin
{
    public string $schemaVersion = '1.0.0';

    public static function config(): array
    {
        return [
            'components' => ['bookApiService' => BookApiService::class],
        ];
    }

    public function init(): void
    {
        parent::init();

        $this->attachEventHandlers();

        // Any code that creates an element query or loads Twig should be deferred until
        // after Craft is fully initialized, to avoid conflicts with other plugins/modules
        Craft::$app->onInit(function() {
            
        });
    }

    private function attachEventHandlers(): void
    {
        // Register event handlers here ...
        // (see https://craftcms.com/docs/5.x/extend/events.html to get started)
    }
}
