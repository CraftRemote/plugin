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

/**
 * @author    CraftRemote
 * @package   Craftremote
 * @since     1.1.0
 */
class BaseController extends Controller
{
    /**
     * @throws BadRequestHttpException
     */
    protected function requireApiToken()
    {
        $key = Craft::$app->request->getParam('key');

        if ($key !== Craftremote::$plugin->settings->apiKey) {
            throw new BadRequestHttpException('Valid API Key required');
        }
    }
}