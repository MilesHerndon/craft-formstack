<?php
/**
 * Formstack plugin for Craft CMS 3.x
 *
 * Plugin to integrate Formstack forms. 
 *
 * @link      https://milesherndon.com
 * @copyright Copyright (c) 2018 MilesHerndon
 */

namespace milesherndon\formstack\services;

use milesherndon\formstack\Formstack;

use Craft;
use craft\base\Component;

/**
 * Formstack Service
 *
 * All of your plugin’s business logic should go in services, including saving data,
 * retrieving data, etc. They provide APIs that your controllers, template variables,
 * and other plugins can interact with.
 *
 * https://craftcms.com/docs/plugins/services
 *
 * @author    MilesHerndon
 * @package   Formstack
 * @since     1.0.0
 */
class Formstack extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * This function can literally be anything you want, and you can have as many service
     * functions as you want
     *
     * From any other plugin file, call it like this:
     *
     *     Formstack::$plugin->formstack->exampleService()
     *
     * @return mixed
     */
    public function exampleService()
    {
        $result = 'something';

        return $result;
    }
}
