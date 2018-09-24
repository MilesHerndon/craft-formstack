<?php
namespace milesherndon\formstack\models;

use craft\base\Model;

class Settings extends Model
{
    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $formstackOAuth = '';

    /**
     * @var bool
     */
    public $formstackDefaultForm = '';

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['formstackOAuth', 'string'],
            ['formstackDefaultForm', 'string'],
        ];
    }

}
