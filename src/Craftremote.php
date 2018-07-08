<?php
/**
 * craftremote plugin for Craft CMS 3.x
 *
 * Remotely manage your Craft CMS installs.
 *
 * @link      https://rias.be
 * @copyright Copyright (c) 2018 Rias
 */

namespace craftremote\plugin;

use craftremote\plugin\models\Settings;
use craftremote\plugin\services\CraftremoteService as CraftremoteServiceService;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\web\UrlManager;
use craft\events\RegisterUrlRulesEvent;

use yii\base\Event;

/**
 * Class Craftremote
 *
 * @author    CraftRemote
 * @package   Craftremote
 * @since     1.0.0
 *
 * @property  CraftremoteServiceService $craftremoteService
 */
class Craftremote extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var Craftremote
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_SITE_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                $event->rules['craftremote/info'] = 'craftremote/info/index';
            }
        );

        Event::on(
            Plugins::class,
            Plugins::EVENT_BEFORE_SAVE_PLUGIN_SETTINGS,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                    $settings = Craft::$app->request->getParam('settings');

                    if (isset($settings['regenerate'])) {
                        $user = Craft::$app->getUser()->getIdentity();
                        $newKey = $this->generateApiToken();
                        $this->setSettings(['apiKey' => $newKey]);

                        Craft::$app->session->setNotice(Craft::t('craftremote', 'Generated a new API Key.'));
                        Craft::$app->session->addFlash('apiKey', $newKey);

                        return Craft::$app->response->redirect(Craft::$app->request->getUrl())->sendAndClose();
                    }
                }
            }
        );
    }

    protected function createSettingsModel()
    {
        return new Settings();
    }

    protected function settingsHtml()
    {
        return Craft::$app->getView()->renderTemplate('craftremote/settings', [
            'settings' => $this->getSettings()
        ]);
    }

    /**
     * Generates a new API token.
     *
     * @return string
     */
    private function generateApiToken(): string
    {
        return strtolower(static::key(40));
    }

    /**
     * Generates a new license key.
     *
     * @param int $length
     * @param string $extraChars
     * @return string
     */
    private function key(int $length, string $extraChars = ''): string
    {
        $licenseKey = '';
        $codeAlphabet = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'.$extraChars;
        $alphabetLength = strlen($codeAlphabet);
        $log = log($alphabetLength, 2);
        $bytes = (int)($log / 8) + 1; // length in bytes
        $bits = (int)$log + 1; // length in bits
        $filter = (int)(1 << $bits) - 1; // set all lower bits to 1
        for ($i = 0; $i < $length; $i++) {
            do {
                $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
                $rnd = $rnd & $filter; // discard irrelevant bits
            } while ($rnd >= $alphabetLength);
            $licenseKey .= $codeAlphabet[$rnd];
        }
        return $licenseKey;
    }

}
