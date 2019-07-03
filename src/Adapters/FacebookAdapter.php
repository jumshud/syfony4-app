<?php

namespace App\Adapters;

use App\Components\SocialUser;
use App\Entity\Main\User;

class FacebookAdapter extends Social
{
    /**
     * Get Fb profile data by access token
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function me(): SocialUser
    {
        $res = $this->client->request('GET',$this->getMeUrl(), ['http_errors' => false]);
        $this->data = json_decode($res->getBody(), true);
        if (array_key_exists('error', $this->data)) {
            throw new \InvalidArgumentException('access token is invalid or expired', 500);
        }
        $this->setPicture();
        $this->data['type'] = User::FB_LOGIN;

        return new SocialUser($this->data);
    }

    /**
     * Get personal data url
     *
     * @return string me url
     */
    private function getMeUrl(): string
    {
        return $this->getUrl() . 'me/?fields=id,first_name,last_name,email,gender&access_token='. $this->getToken();
    }

    private function setPicture()
    {
        $res = $this->client->request('GET',$this->getPictureUrl(), ['http_errors' => false]);
        $data = json_decode($res->getBody(), true);
        $this->data['picture'] = $data['data']['url'];
    }

    private function getPictureUrl(): string
    {
        if (is_numeric($this->data['id']) && $this->data['id'] > 0) {
            return $this->getUrl() . $this->data['id'] . '/picture?width=300&redirect=0';
        }
    }
}