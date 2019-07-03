<?php

namespace App\Adapters;

use App\Components\SocialUser;
use App\Entity\Main\User;

class GoogleAdapter extends Social
{
    /**
     * Get Google user data by access token
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function me(): SocialUser
    {
        $res = $this->client->request('GET',$this->getMeUrl(), ['http_errors' => false]);
        $this->data = json_decode($res->getBody(), true);
        if (array_key_exists('error', $this->data)) {
            throw new \InvalidArgumentException('access token is invalid or expired', 500);
        }

        return $this->getSocialUser();
    }

    /**
     * Get user info url
     *
     * @return string me url
     */
    private function getMeUrl(): string
    {
        return $this->getUrl() . 'userinfo?access_token='. $this->getToken();
    }

    /**
     * Get user info url
     *
     * @return SocialUser
     */
    private function getSocialUser(): SocialUser
    {
        $data = [
            'id' => $this->data['sub'],
            'email' => $this->data['email'],
            'first_name' => explode(' ', $this->data['name'])[0],
            'last_name' => $this->data['family_name'],
            'picture' => $this->data['picture'],
            'type' => User::GOOGLE_LOGIN,
        ];

        if (!empty($this->data['gender'])) {
            $data['gender'] = $this->data['gender'];
        }

        return new SocialUser($data);
    }
}