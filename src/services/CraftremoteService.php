<?php
/**
 * craftremote plugin for Craft CMS 3.x
 *
 * Remotely manage your Craft CMS installs.
 *
 * @link      https://rias.be
 * @copyright Copyright (c) 2018 Rias
 */

namespace craftremote\plugin\services;

use craftremote\plugin\Craftremote;

use Craft;
use craft\base\Component;

/**
 * @author    CraftRemote
 * @package   Craftremote
 * @since     1.0.0
 */
class CraftremoteService extends Component
{
    // Public Methods
    // =========================================================================

    /*
     * @return mixed
     */
    public function exampleService()
    {
        $result = 'something';

        return $result;
    }
}
