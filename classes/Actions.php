<?php

class Actions {

    private $apiKey;

    public function __construct() {
        $this->apiKey = "1336848-1501964944-a79mxdgq2rw6sv85";
    }

    public function retrieveForms($token, $formID = false) {

        $token = strip_tags(trim($token));

        $url = "https://api.123contactform.com/v2/forms?apiKey=".$this->apiKey."&JWT=".$token;
        $data = $this->getCurl($url);

        return $data;
    }

    public function retrieveSubmissions($token, $formID) {

        $token = strip_tags(trim($token));
        $formID = strip_tags(trim($formID));

        $url = "https://api.123contactform.com/v2/forms/".$formID."/submissions?apiKey=".$this->apiKey."&JWT=".$token;
        $data = $this->getCurl($url);

        return $data;
    }

    public function authenticateUser($email, $password) {

        // $passwordHash = md5($password);
        // filter_var($email, FILTER_VALIDATE_EMAIL)
        $password = strip_tags(trim($password));

        $curl_post_string = "apiKey=".$this->apiKey."&email=".$email."&password=".$password;

        $url = "https://api.123contactform.com/v2/token";
        $data = $this->authUser($url, $curl_post_string, $email, $password);

        return $data;
    }

    private function authUser($url, $curl_post_string, $email, $password) {

        $ch = curl_init($url);
        
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curl_post_string);
        
        curl_exec($ch);
        curl_close($ch);

        exit();
    }

    private function getCurl($url) {

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        curl_exec($ch);

        curl_close($ch);
    }

    // public function writeToFile($action) {
    //     $fileName = $action ? 'successful_logins.txt' : 'unsuccessful_logins.txt';
    //     $file = $fileName;
    //     $current = file_get_contents($file);
    //     $current .= "John Doe";
    //     file_put_contents($file, $current);
    // }

}