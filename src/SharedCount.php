<?php

namespace humandirect\sharedcount;

use craft\base\Plugin;
use craft\web\twig\variables\CraftVariable;

use humandirect\sharedcount\models\Settings;
use humandirect\sharedcount\services\SharedCountService;
use humandirect\sharedcount\variables\SharedCountVariable;

use yii\base\Event;

/**
 * SharedCount class
 *
 * @author    Balazs Csaba <csaba.balazs@humandirect.eu>
 * @copyright 2018 Human Direct
 *
 * @property SharedCountService $sharedcount The SharedCount service
 */
class SharedCount extends Plugin
{
    /**
     * @var SharedCount
     */
    public static $plugin;

    /**
     * Initialize plugin.
     */
    public function init(): void
    {
        parent::init();
        self::$plugin = $this;

        Event::on(CraftVariable::class, CraftVariable::EVENT_INIT, function(Event $event) {
            /** @var CraftVariable $variable */
            $variable = $event->sender;
            $variable->set('sharedcount', SharedCountVariable::class);
        });

        $this->setComponents(['sharedcount' => SharedCountService::class]);

        \Craft::info(
            \Craft::t('sharedcount', '{name} plugin loaded', [
                'name' => $this->name
            ]),
            __METHOD__
        );
    }

    /**
     * Returns the sharedcount service.
     *
     * @return SharedCountService
     */
    public function getSharedCount(): SharedCountService
    {
        return $this->get('sharedcount');
    }

    /**
     * @inheritdoc
     */
    protected function createSettingsModel()
    {
        return new Settings();
    }

    /**
     * @inheritdoc
     */
    protected function settingsHtml(): string
    {
        // Get and pre-validate the settings
        $settings = $this->getSettings();
        $settings->validate();

        // Get the settings that are being defined by the config file
        $overrides = \Craft::$app->getConfig()->getConfigFromFile(strtolower($this->handle));

        return \Craft::$app->view->renderTemplate('sharedcount/settings', [
            'settings' => $settings,
            'overrides' => array_keys($overrides),
        ]);
    }
}
