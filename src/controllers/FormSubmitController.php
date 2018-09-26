<?php
/**
 * Formstack plugin for Craft CMS 3.x
 *
 * Plugin to integrate Formstack forms.
 *
 * @link      https://milesherndon.com
 * @copyright Copyright (c) 2018 MilesHerndon
 */

namespace milesherndon\formstack\controllers;

use milesherndon\formstack\Formstack;

use Craft;
use craft\web\Controller;
use craft\web\Request;

/**
 * FormSubmit Controller
 *
 * Generally speaking, controllers are the middlemen between the front end of
 * the CP/website and your plugin’s services. They contain action methods which
 * handle individual tasks.
 *
 * A common pattern used throughout Craft involves a controller action gathering
 * post data, saving it on a model, passing the model off to a service, and then
 * responding to the request appropriately depending on the service method’s response.
 *
 * Action methods begin with the prefix “action”, followed by a description of what
 * the method does (for example, actionSaveIngredient()).
 *
 * https://craftcms.com/docs/plugins/controllers
 *
 * @author    MilesHerndon
 * @package   Formstack
 * @since     1.0.0
 */
class FormSubmitController extends Controller
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
     * Handle a request going to our plugin's index action URL,
     * e.g.: actions/formstack/form-submit
     *
     * @return mixed
     */
    public function actionIndex()
    {
        try {
            $this->requirePostRequest();

            $formData = Craft::$app->getRequest()->post();

            // Get Settings
            $settings = Formstack::getInstance()->getSettings();

            // Parse field data
            foreach ( $formData as $key => $value) {
                if ($key !== 'action' && $key !== 'redirect' && $key !== '_submit' && $key !== 'CRAFT_CSRF_TOKEN' ) {
                    if (strpos($key, '-') != 0) {
                        $fieldName = substr($key, 0, strpos($key, '-'));
                        $fieldSubname = substr($key, strpos($key, '-')+1);
                        $fields[] = $fieldName . '[' . $fieldSubname . ']=' . $value;
                    } else {
                        $fields[] = $key . '=' . $value;
                    }
                }
            }
            $postFields = implode ('&', $fields);

            // Create request URL
            $submissionUrl = 'https://www.formstack.com/api/v2/form/' . $formData['form'] . '/submission.json?oauth_token=' . $settings->formstackOAuth;

            $curl = curl_init($submissionUrl);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $postFields);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLINFO_HEADER_OUT, true);

            $result = curl_exec($curl);
            $resultJson = json_decode($result);

            curl_close($curl);

            // Check if not ajax request
            if (!Formstack::$plugin->request->getIsAjax()) {
                $message = isset($postFields['success']) ? $postFields['success'] : '';
                $url = $formData['redirect'] . '?message=' . urlencode($message) . '&submitted=true';
                $this->redirect($url);
            }

            return $resultJson;

        } catch (\Exception $e ) {
            return $e;
        }
    }
}
