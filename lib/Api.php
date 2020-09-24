<?php

namespace WHMCS\Module\Registrar\Pandimodule;

class Api{

    public $results = array();
    protected $token;
    public function request($param, $method)
    {
        //inisialisasi param
        $post       = $param['data'];
        $name       = $param['name'];
        $this->token = $param['token'];
        $url        = $param['url'];

        $start = microtime(true);
        if($param['test']){
            logActivity('Api '.$name.' run!');
        }
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded',
            'Accept: application/json',
            'Authorization: Bearer '.$this->token,
        ));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);        
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 100);
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if($param['test']){
            logActivity($httpcode);
        }
        if (curl_errno($ch)) {
            throw new \Exception('Connection Error: ' . curl_errno($ch) . ' - ' . curl_error($ch));
        }
        curl_close($ch);
        //if null
        if ($this->results === null && json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('Bad response received from API');
        }
        $this->results = json_decode($response, true);
        logModuleCall(
            'Pandimodule',
            $name,
            $post,
            $response,
            $this->results
        );
        $end = microtime(true);
        $waktu = $end - $start;
        if($param['test']){
            logActivity('Time for '.$name. ' is '.$waktu);
        }
        return $this->results;
    }
}