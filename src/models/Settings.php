<?php

namespace jaymeh\craftcurrentlyreadingwidget\models;

use craft\base\Model;
use craft\helpers\App;
use craft\behaviors\EnvAttributeParserBehavior;

/**
 * Settings model
 *
 * @property-write string $source
 */
class Settings extends Model
{
    /**
     * Source for looking up books.
     *
     * @var string|null
     */
    private ?string $_source = null;

    /**
     * API Key for Open API.
     *
     * @var string|null
     */
    private ?string $_openAPIKey = null;

    /**
     * Secret Key for Open API.
     *
     * @var string|null
     */
    private ?string $_openAPISecret = null;

    /**
     * {@inheritdoc}
     */
    public function attributes()
    {
        $names = parent::attributes();
        $names[] = 'source';

        return $names;
    }

    /**
     * {@inheritdoc}
     */
    public function fields(): array
    {
        return [
            'source' => fn() => $this->getSource(false),
        ];
    }

    /**
     * Gets the API Source.
     *
     * @param boolean $parse
     * @return string|null
     */
    public function getSource($parse = true): ?string
    {
        return ($parse ? App::parseEnv($this->_source) : $this->_source ?? '');
    }

    /**
     * Sets the API source.
     *
     * @param string $value
     * @return void
     */
    public function setSource(string $value): void {
        $this->_source = $value;
    }

    /**
     * Gets the API Source.
     *
     * @param boolean $parse
     * @return string|null
     */
    public function getOpenAPIKey($parse = true): ?string
    {
        return ($parse ? App::parseEnv($this->_openAPIKey) : $this->_openAPIKey ?? '');
    }

    /**
     * Sets the API source.
     *
     * @param string $value
     * @return void
     */
    public function setOpenAPIKey(string $value): void {
        $this->_openAPIKey = $value;
    }

        /**
     * Gets the API Source.
     *
     * @param boolean $parse
     * @return string|null
     */
    public function getOpenAPISecret($parse = true): ?string
    {
        return ($parse ? App::parseEnv($this->_openAPISecret) : $this->_openAPISecret ?? '');
    }

    /**
     * Sets the API source.
     *
     * @param string $value
     * @return void
     */
    public function setOpenAPISecret(string $value): void {
        $this->_openAPISecret = $value;
    }

    /**
     * {@inheritdoc}
     */
    protected function defineRules(): array
    {
        return array_merge(parent::defineRules(), [
            [['source'], 'required'],
            [['source'], 'string'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function defineBehaviors(): array
    {
        return [
            'parser' => [
                'class' => EnvAttributeParserBehavior::class,
                'attributes' => [
                    'source',
                ],
            ],
        ];
    }
}
