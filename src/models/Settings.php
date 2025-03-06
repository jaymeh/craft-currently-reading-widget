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
    private ?string $_personName  = null;

    /**
     * {@inheritdoc}
     */
    public function attributes()
    {
        $names = parent::attributes();
        $names[] = 'source';
        $names[] = 'personName';
        return $names;
    }

    /**
     * {@inheritdoc}
     */
    public function fields(): array
    {
        return [
            'source' => fn () => $this->getSource(false),
            'personName' => fn () => $this->getPersonName(false),
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
    public function setSource(string $value): void
    {
        $this->_source = $value;
    }

    /**
     * Gets the API Source.
     *
     * @param boolean $parse
     * @return string|null
     */
    public function getPersonName($parse = true): ?string
    {
        return ($parse ? App::parseEnv($this->_personName) : $this->_personName ?? '');
    }

    /**
     * Sets the Person name.
     *
     * @param string $value
     * @return void
     */
    public function setPersonName(string $value): void
    {
        $this->_personName = $value;
    }

    /**
     * {@inheritdoc}
     */
    protected function defineRules(): array
    {
        return array_merge(parent::defineRules(), [
            [['source'], 'required'],
            [['source'], 'string'],
            [['personName'], 'required'],
            [['personName'], 'string'],
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
                    'personName',
                ],
            ],
        ];
    }
}
