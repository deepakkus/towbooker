<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Google\Auth\OAuth2;
use Google\Auth\Credentials\ServiceAccountCredentials;
use Kreait\Firebase\Factory;
class FCMService
{
    protected $credentialsPath;
    protected $provider_credentialsPath;
    public function __construct()
    {
        $this->credentialsPath = env('FIREBASE_CREDENTIALS');
        $this->provider_credentialsPath = env('PROVIDER_FIREBASE_CREDENTIALS');
    }

    protected function getAccessToken()
    {
        $scopes = ['https://www.googleapis.com/auth/firebase.messaging'];
        $credentials = new ServiceAccountCredentials($scopes, $this->credentialsPath);
        $token = $credentials->fetchAuthToken();
        return $token['access_token'];
    }
    protected function getProviderAccessToken()
    {
        $scopes = ['https://www.googleapis.com/auth/firebase.messaging'];
        $credentials = new ServiceAccountCredentials($scopes, $this->provider_credentialsPath);
        $token = $credentials->fetchAuthToken();
        return $token['access_token'];
    }
    public function sendNotification($token, $title, $body, $data = [], $sender_type='')
    {
        if($sender_type == 'provider')
        {
            $accessToken = $this->getProviderAccessToken();
            $projectId = json_decode(file_get_contents($this->provider_credentialsPath), true)['project_id'];
        }
        else
        {
            $accessToken = $this->getAccessToken();
            $projectId = json_decode(file_get_contents($this->credentialsPath), true)['project_id'];
        }
        
        
        $url = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";

        $data['title'] = $title;
        $data['body'] = $body;
        $payload = [
            'message' => [
                'token' => $token,
                /*'notification' => [
                    'title' => $title,
                    'body' => $body,
                ],*/
                'data' => $data
            ]
        ];

        $response = Http::withToken($accessToken)
            ->withHeaders([
                'Content-Type' => 'application/json',
            ])
            ->post($url, $payload);
 
        return $response->json();
 
    }
}
