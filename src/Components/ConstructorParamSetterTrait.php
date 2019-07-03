<?php
/**
 * Created by PhpStorm.
 * User: Jumshud_Mecidli
 * Date: 12/4/2018
 * Time: 3:40 PM
 */

namespace App\Components;


trait ConstructorParamSetterTrait
{
    /**
     * ConstructorParamSetterTrait constructor.
     * @param array|null $params
     */
    public function __construct($params = null)
    {
        if (is_array($params)) {
            foreach ($params as $key => $value) {
                if (property_exists($this, $key)) {
                    $this->{$key} = $value;
                }
            }
        }
    }
}