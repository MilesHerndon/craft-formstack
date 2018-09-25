<?php
/**
 * Formstack plugin for Craft CMS 3.x
 *
 * Plugin to integrate Formstack forms.
 *
 * @link      https://milesherndon.com
 * @copyright Copyright (c) 2018 MilesHerndon
 */

namespace milesherndon\formstack\variables;

use milesherndon\formstack\Formstack;

use Craft;

/**
 * Formstack Variable
 *
 * Craft allows plugins to provide their own template variables, accessible from
 * the {{ craft }} global variable (e.g. {{ craft.formstack }}).
 *
 * https://craftcms.com/docs/plugins/variables
 *
 * @author    MilesHerndon
 * @package   Formstack
 * @since     1.0.0
 */
class FormstackVariable
{
    // Public Methods
    // =========================================================================

    /**
     * Whatever you want to output to a Twig template can go into a Variable method.
     * You can have as many variable functions as you want.  From any Twig template,
     * call it like this:
     *
     *     {{ craft.formstack.exampleVariable }}
     *
     * Or, if your variable requires parameters from Twig:
     *
     *     {{ craft.formstack.exampleVariable(twigValue) }}
     *
     */

    /**
     * Function to get all forms
     *
     * @return array
     */
    public function getForms()
    {
        return Formstack::getInstance()->FormstackService->getForms();
    }

    /**
     * Function to get all forms
     *
     * @param $id: Formstack form id
     * @param $additionalData: array of fields
     * @return array
     */
    public function getFormById($id, $additionalData = [])
    {
        return Formstack::getInstance()->FormstackService->getFormById($id, $additionalData);
    }
}
