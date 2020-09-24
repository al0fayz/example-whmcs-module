<?php

namespace WHMCS\Module\Registrar\Pandimodule;
use WHMCS\Database\Capsule;

class koneksi{

    public function login($param){
        try{
            $login = [
                'email'     => $param['email'],
                'password'  => $param['password']
            ];
            $api_url = $param['url'];
            $url = $api_url .'/api/login';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, FALSE);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/x-www-form-urlencoded',
                'Accept: application/json'
            ));
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($login));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_TIMEOUT, 100);
            $response = curl_exec($ch);
            if (curl_errno($ch)) {
                throw new \Exception('Connection Error: ' . curl_errno($ch) . ' - ' . curl_error($ch));
            }
            curl_close($ch);
            //if null
            if ($this->results === null && json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Bad response received from API');
            }

            $data = json_decode($response, true);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if($httpcode == 401 || $httpcode == 500 || $httpcode == 302){
                throw new \Exception('Error in Api');
            }
            if (Capsule::schema()->hasTable('pandi_token_table')){

            }else{
                //create table
                $this->create();
            }
            $save = [
                'token'         => $data['access_token'],
                'token_type'    => $data['token_type'],
                'expires_at'    => $data['expires_at'],
            ];
            //call function for save token
            $this->save_token($save);

        }catch(\Exception $e){
            return array(
                'error' => $e->getMessage(),
            );
        }
        
    }
    public function logout(){

    }
    private function create(){
        // Create a new table for save token
        try {
            Capsule::schema()->create(
                'pandi_token_table',
                function ($table) {
                    /** @var \Illuminate\Database\Schema\Blueprint $table */
                    $table->increments('id');
                    $table->text('token');
                    $table->string('token_type');
                    $table->date('expires_at')->nullable();
                    $table->timestamps();
                }
            );
        } catch (\Exception $e) {
            echo "Unable to create table: {$e->getMessage()}";
        }                                                       
    }
    private function save_token($param){
        $data = Capsule::table('pandi_token_table')->first();

        if(empty($data)){
            try {
                Capsule::table('pandi_token_table')->insert(
                    [
                        'token'         => $param['token'],
                        'token_type'    => $param['token_type'],
                        'expires_at'    => $param['expires_at'],
                    ]
                );
            } catch (\Exception $e) {
                echo "Uh oh! Inserting didn't work!. {$e->getMessage()}";
            }
        }else{
            try {
                Capsule::table('pandi_token_table')
                    ->where('id', 1)
                    ->update(
                        [
                            'token'         => $param['token'],
                            'token_type'    => $param['token_type'],
                            'expires_at'    => $param['expires_at'],
                        ]
                    );
            
            } catch (\Exception $e) {
                echo "I couldn't update. {$e->getMessage()}";
            }
        }
        
    }
}