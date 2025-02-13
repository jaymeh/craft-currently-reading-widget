<?php

namespace jaymeh\craftcurrentlyreadingwidget;

use Craft;
use craft\base\Model;
use craft\base\Plugin;
use jaymeh\craftcurrentlyreadingwidget\models\Settings;
use jaymeh\craftcurrentlyreadingwidget\services\BookApiService;

/**
 * Currently Reading Widget plugin
 *
 * @method static CurrentlyReading getInstance()
 * @author Jaymeh <contact@jaymeh.co.uk>
 * @copyright Jaymeh
 * @license https://craftcms.github.io/license/ Craft License
 *
 * @property-read BookApiService $bookApiService
 * @property-read \jaymeh\craftcurrentlyreadingwidget\models\Settings $settings
 */
class CurrentlyReading extends Plugin
{
    public string $schemaVersion = '1.0.0';

    /** @var bool Whether the plugin has a settings page in the control panel */
    public bool $hasCpSettings = true;

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

    /**
     * Gets the source options.
     *
     * @return array
     */
    public function getSourceOptions(): array
    {
        // TODO: Make this dynamically load from the available APIs.

        return [
            'source'      => '$CURRENTLY_READING_SOURCE_FIELD',
            'openlibrary' => 'Open Library',
            'mock'        => 'Mock',
        ];
    }

    /**
     * Creates and returns the model used to store the plugin’s settings.
     *
     * @return Model|null
     */
    protected function createSettingsModel(): ?Model
    {
        return Craft::createObject(Settings::class);
    }

    /**
     * @inheritdoc
     */
    public function getSettingsResponse(): mixed
    {
        $view = Craft::$app->getView();
        $namespace = $view->getNamespace();
        $view->setNamespace('settings');
        $settingsHtml = $this->settingsHtml();
        $view->setNamespace($namespace);

        /** @var Controller $controller */
        $controller = Craft::$app->controller;

        $overrides = Craft::$app->getConfig()->getConfigFromFile(strtolower($this->handle));

        return $controller->renderTemplate('currently-reading-widget/_settings', [
            'plugin' => $this,
            'settingsHtml' => $settingsHtml,
            'settings' => $this->getSettings(),
            'overrides' => array_keys($overrides),
        ]);
    }

    private function attachEventHandlers(): void
    {
        // Register event handlers here ...
        // (see https://craftcms.com/docs/5.x/extend/events.html to get started)
    }
}
