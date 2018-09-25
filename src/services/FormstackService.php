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
class FormstackService extends Component
{
    // Public Methods
    // =========================================================================

    /**
     * This function can literally be anything you want, and you can have as many service
     * functions as you want
     *
     * From any other plugin file, call it like this:
     *
     *     Formstack::getInstance()->FormstackService->getFormstackData()
     *
     * @return array
     */
    public function getFormstackData()
    {
        $settings = Formstack::getInstance()->getSettings();
        $formOptions = [];
        $formstackWithToken = Formstack::getFormstackUrl() . $settings->formstackOAuth;

        $formstackForms = @file_get_contents($formstackWithToken);
        if (!empty($formstackForms)) {
            $objects = json_decode($formstackForms);

            foreach($objects->forms as $form){
                $formOptions[] = array(
                  'label' => $form->name,
                  'value' => $form->id
                );
            }
        }

        return $formOptions;
    }

    /**
    * Get forms from Formstack
    *
    * @return array Array of Formstack Forms
    */
    public function getForms()
    {
        $settings = Formstack::getInstance()->getSettings();
        $formstackWithToken = Formstack::getFormstackUrl() . $settings->formstackOAuth;

        try {
            $results = @file_get_contents($formstackWithToken);
            if ($results === false) {
                return "Your forms are not working at the moment.";
            } else {
                $object = json_decode($results);
                return $object->forms;
            }
        } catch(\Exception $e) {
            return $e;
        }

    }

    /**
    * Get specific form from Formstack
    *
    * @param $id: Formstack form id
    * @param $additionalData: array of fields
    * @return array Formstack Form
    */
    public function getFormById($id, $additionalData = [])
    {
        $settings = Formstack::getInstance()->getSettings();
        $formstackWithToken = 'https://www.formstack.com/api/v2/form/'.$id.'.json?oauth_token=' . $settings->formstackOAuth;

        try{
            $result = file_get_contents($formstackWithToken);
            $resultObject = json_decode($result);

            $form['fields'] = $resultObject->fields;

            if (!empty($additionalData)) {
                foreach ($additionalData as $item) {
                    $form[$item] = $resultObject->$item;
                }
            }

            return $form;
        } catch(\Exception $e) {
            return $e;
        }
    }
}
