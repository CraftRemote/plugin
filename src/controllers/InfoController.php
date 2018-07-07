<?php
/**
 * craftremote plugin for Craft CMS 3.x
 *
 * Remotely manage your Craft CMS installs.
 *
 * @link      https://rias.be
 * @copyright Copyright (c) 2018 Rias
 */

namespace rias\craftremote\controllers;

use rias\craftremote\Craftremote;

use Craft;
use craft\web\Controller;
use yii\web\BadRequestHttpException;
use yii\web\UnauthorizedHttpException;

/**
 * @author    Rias
 * @package   Craftremote
 * @since     1.0.0
 */
class InfoController extends Controller
{

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = ['index'];

    // Public Methods
    // =========================================================================

    /**
     * @return mixed
     */
    public function actionIndex()
    {
        $this->requireApiToken();

        $updates = Craft::$app->updates->getUpdates(true);

        return $this->asJson([
            'version' => Craft::$app->getVersion(),
            'plugins' => (array) Craft::$app->getPlugins()->getAllPluginInfo(),
            'updates' => $updates->toArray(),
        ]);
    }

    protected function requireApiToken()
    {
        $key = Craft::$app->request->getParam('key');

        if ($key !== Craftremote::$plugin->settings->apiKey) {
            throw new BadRequestHttpException('Valid API Key required');
        }
    }
}
