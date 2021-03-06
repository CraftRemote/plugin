<?php
/**
 * craftremote plugin for Craft CMS 3.x
 *
 * Remotely manage your Craft CMS installs.
 *
 * @link      https://rias.be
 * @copyright Copyright (c) 2018 Rias
 */

namespace craftremote\plugin\controllers;

use craftremote\plugin\Craftremote;

use Craft;
use craft\web\Controller;
use yii\web\BadRequestHttpException;
use yii\web\UnauthorizedHttpException;

/**
 * @author    CraftRemote
 * @package   Craftremote
 * @since     1.0.0
 */
class InfoController extends BaseController
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
     * @throws BadRequestHttpException
     */
    public function actionIndex()
    {
        $this->requireApiToken();

        $updates = Craft::$app->updates->getUpdates(true);

        $data = [
            'version' => Craft::$app->getVersion(),
            'plugins' => (array) Craft::$app->getPlugins()->getAllPluginInfo(),
            'updates' => $updates->toArray(),
        ];

        return $this->asJson($data);
    }
}
