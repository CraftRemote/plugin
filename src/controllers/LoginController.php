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

use craft\elements\User;

use Craft;
use yii\web\BadRequestHttpException;

/**
 * @author    CraftRemote
 * @package   Craftremote
 * @since     1.1.0
 */
class LoginController extends BaseController
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

        $user = User::find()->admin()->one();
        Craft::$app->getUser()->loginByUserId($user->id);

        return $this->redirect(Craft::$app->getConfig()->getGeneral()->baseCpUrl . '/' . Craft::$app->getConfig()->getGeneral()->cpTrigger);
    }
}