<?php
/**
 * craftremote plugin for Craft CMS 3.x
 *
 * Remotely manage your Craft CMS installs.
 *
 * @link      https://rias.be
 * @copyright Copyright (c) 2018 Rias
 */

namespace rias\craftremote\services;

use rias\craftremote\Craftremote;

use Craft;
use craft\base\Component;

/**
 * @author    Rias
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
