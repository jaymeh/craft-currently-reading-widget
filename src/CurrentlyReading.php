<?php

namespace jaymeh\craftcurrentlyreadingwidget;

use Craft;
use craft\web\View;
use craft\base\Event;
use craft\base\Model;
use craft\base\Plugin;
use yii\base\Event as YiiBaseEvent;
use craft\web\twig\variables\CraftVariable;
use craft\events\RegisterTemplateRootsEvent;
use jaymeh\craftcurrentlyreadingwidget\apis\MockApi;
use jaymeh\craftcurrentlyreadingwidget\models\Settings;
use jaymeh\craftcurrentlyreadingwidget\apis\OpenLibraryApi;
use jaymeh\craftcurrentlyreadingwidget\services\BookApiService;
use jaymeh\craftcurrentlyreadingwidget\events\RegisterBookApiEvent;

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
    /**
     * Version of the plugin.
     *
     * @var string
     */
    public string $schemaVersion = '1.0.0';

    /**
     * Whether the plugin has a control panel settings page.
     *
     * @var boolean
     */
    public bool $hasCpSettings = true;

    /**
     * The components of the plugin.
     *
     * @return array
     */
    public static function config(): array
    {
        return [
            'components' => [
                'bookApiService' => BookApiService::class,
            ],
        ];
    }

    public function init(): void
    {
        parent::init();

        $this->attachEventHandlers();
        $this->setTemplateRoots();
    }

    /**
     * Gets the source options.
     *
     * @return array
     */
    public function getSourceOptions(): array
    {
        // Get all the apis.
        $apis = $this->bookApiService->getApis();

        return array_map(function ($api) {
            return [
                'label' => $api->getLabel(),
                'value' => $api->getName(),
            ];
        }, $apis);
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

    /**
     * Sets the template roots.
     *
     * @return void
     */
    protected function setTemplateRoots()
    {
        Event::on(
            View::class,
            View::EVENT_REGISTER_SITE_TEMPLATE_ROOTS,
            function (RegisterTemplateRootsEvent $event) {
                $event->roots['currently-reading'] = __DIR__ . '/templates/currently-reading';
            }
        );
    }

    /**
     * Attaches the event handlers.
     *
     * @return void
     */
    private function attachEventHandlers(): void
    {
        // Register event handlers here ...
        // (see https://craftcms.com/docs/5.x/extend/events.html to get started)
        // TODO: There has to be a better way to do this.
        Event::on(
            CraftVariable::class,
            CraftVariable::EVENT_INIT,
            function (YiiBaseEvent $event) {
                /** @var CraftVariable $variable */
                $variable = $event->sender;
                $variable->set('currentlyReadingWidget', function () {
                    return CurrentlyReading::getInstance();
                });
            }
        );
        
        // Register the event handlers for the book API service.
        Event::on(
            BookApiService::class,
            BookApiService::EVENT_REGISTER_BOOK_API,
            function (RegisterBookApiEvent $event) {
                $event->apis['mock'] = MockApi::class;
                $event->apis['openlibrary'] = OpenLibraryApi::class;
            }
        );
    }
}
