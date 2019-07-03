<?php
/**
 * Created by PhpStorm.
 * User: Jumshud_Mecidli
 * Date: 12/4/2018
 * Time: 3:33 PM
 */

namespace App\Components;

/**
 *
*/
class SocialUser
{
    use ConstructorParamSetterTrait;

    private $id;
    private $first_name;
    private $last_name;
    private $email;
    private $picture;
    private $gender;
    private $type;

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function getType(): ?string
    {
        return $this->type;
    }
}