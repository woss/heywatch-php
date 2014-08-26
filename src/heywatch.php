<?php
use Guzzle\Http\Client;

class heywatch {

    const HEYWATCH_URL = "https://heywatch.com";
    const USER_AGENT = "HeyWatch PHP/1.0";

    public $client;

    public function __construct($user, $password) {
        $this->client = new Client(self::HEYWATCH_URL, array(
            'request.options' => array(
                'headers' => array('Accept' => 'application/json'),
                'auth'    => array($user, $password, 'Basic')
            )
        ));

        $this->client->setUserAgent(self::USER_AGENT);
    }

    public function account() {
        return $this->request("/account");
    }

    public function all($resource) {
        return $this->request("/".$resource);
    }

    public function info($resource, $id) {
        return $this->request("/".$resource."/".$id);
    }

    public function create($resource, $params=array()) {
        return $this->request("/".$resource, "post", $params);
    }

    public function update($resource, $params=array()) {
        return $this->request("/".$resource, "put", $params);
    }

    public function delete($resource, $id) {
        return $this->request("/".$resource."/".$id, "delete");
    }

    private function request($path, $method="get", $params=array()) {
        $request = $this->client->$method($path, array(), $params);
        $response = $request->send();

        if(strlen(trim($response->getBody())) == 0) {
            return True;
        }

        if(strpos($response->getHeader("Content-Type"), "json") != False) {
            return $response->json();
        } else {
            return $response->getBody();
        }
    }
}
?>