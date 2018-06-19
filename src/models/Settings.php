<?php

namespace humandirect\sharedcount\models;

use craft\base\Model;

/**
 * Class Settings
 *
 * @author    Balazs Csaba <csaba.balazs@humandirect.eu>
 * @copyright 2018 Human Direct
 */
class Settings extends Model
{
    /**
     * @var string
     */
    public $apiKey = '';

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            ['apiKey', 'string'],
            ['apiKey', 'default', 'value' => null],
        ];
    }
}
