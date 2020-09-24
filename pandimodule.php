<?php

if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

use WHMCS\Domains\DomainLookup\ResultsList;
use WHMCS\Domains\DomainLookup\SearchResult;
use WHMCS\Module\Registrar\Pandimodule\Api;

function pandimodule_MetaData()
{
    return array(
        'DisplayName' => 'Registrar Pandi Module for WHMCS',
        'APIVersion' => '1.0',
    );
}

function pandimodule_getConfigArray()
{
    return array(
        // Friendly display name for the module
        'FriendlyName' => array(
            'Type' => 'System',
            'Value' => 'Pandi Module',
        ),
        // a text field type allows for single line text input
        'URL' => array(
            "FriendlyName" => "API URL",
            'Type' => 'text',
            'Size' => '25',
            'Default' => 'https://portal-dev.pandi.id',
            'Description' => 'Change if Api Url is different!',
        ),
        // 'Email' => array(
        //     'Type' => 'text',
        //     'Size' => '25',
        //     'Default' => '',
        //     'Description' => 'Insert Email Here!',
        // ),
        // 'Password' => array(
        //     'Type' => 'password',
        //     'Size' => '25',
        //     'Default' => '',
        //     'Description' => 'Enter secret value here',
        // ),
        'Token' => array(
            'Type' => 'text',
            'Size' => '25',
            'Default' => '',
            'Description' => 'Insert Token Here!',
        ),
        'Test' => array(
            "FriendlyName" => "Test Mode",
            'Type' => 'yesno',
            'Description' => 'Tick to enable',
        ),
    );
}

function pandimodule_RegisterDomain($params)
{
    if($params['Test']){
        logActivity('index RegisterDomain run!');
        logActivity(json_encode($params));
    }

    // user defined configuration values
    $token      = $params['Token'];
    $url        = $params['URL'];
    $test       = $params['Test'];
    // registration parameters
    $sld = $params['sld'];
    $tld = $params['tld'];
    $registrationPeriod = $params['regperiod'];
    //nameserver
    $nameserver     = array();
    $dt             = [
        $params['ns1'],
        $params['ns2'],
        $params['ns3'],
        $params['ns4'],
        $params['ns5'],
    ];
    foreach($dt as $key => $val){
        if(!empty($val)){
            $nameserver[] = $val;
        }
    }
    // registrant information
    $fullName = $params["fullname"]; // First name and last name combined
    $companyName = $params["companyname"];
    $email = $params["email"];
    $address1 = $params["address1"];
    $address2 = $params["address2"];
    $city = $params["city"];
    $state = $params["state"]; // eg. TX
    $postcode = $params["postcode"]; // Postcode/Zip code
    $countryCode = $params["countrycode"]; // eg. GB
    $phoneNumberFormatted = str_replace('-', '', $params["fullphonenumber"]); // Format: +CC.xxxxxxxxxxxx

    $contact = array(
        'name'          => $fullName,
        'organization'  => $companyName,
        'email'         => $email,
        'street'        => $address1 . $address2,
        'fax'           => '',
        'city'          => $city,
        'state'         => $state,
        'postal_code'   => $postcode,
        'country_id'    => $countryCode,
        'phone'         => $phoneNumberFormatted,
    );
    $api_contact = $url .'/api/v1/reseller/contacts';
    $domain         = $sld . '.' . $tld;

    // Build post data
    $postfields = array(
        'token'     => $token,
        'url'       => $api_contact,
        'data'      => $contact,
        'name'      => 'CreateContact',
        'test'      => $test,
    );

    try {
        $api = new Api();
        $api->request($postfields, 'POST');
        if($params['Test']){
            logActivity($api->results['code']);
        }
        if($api->results['code'] == 200){
            $registrant_id = $api->results['data']['id'];
            //data document is dumy please change to real data
            $documents  = [];
            $domain = [
                'name'          => $domain,
                'period'        => $registrationPeriod,
                'registrant_id' => $registrant_id,
                'admin_id'      => $registrant_id,
                'tech_id'       => $registrant_id,
                'billing_id'    => $registrant_id,
                'documents'     => $documents,
                'nameserver'    => $nameserver,
            ];
            $api_domain = $url .'/api/v1/reseller/domain';
            $post = [
                'token'     => $token,
                'url'       => $api_domain,
                'data'      => $domain,
                'name'      => 'RegisterDomain',
                'test'      => $test,
            ];
            try{
                $api = new Api();
                $api->request($post, 'POST');
                logModuleCall(
                    'Pandimodule',
                    'RegisterDomain Response',
                    $post,
                    $api,
                    $api
                );
                if($params['Test']){
                    logActivity($api->results['code']);
                }
                if($api->results['code'] == 200){
                    return array(
                        'success' => true,
                    );
                }else if($api->results['code'] == 403){
                    return array(
                        'error' => $api->results['error'],
                    );
                }else if($api->results['code'] == 500){
                    return array(
                        'error' => $api->results['errors'],
                    );
                }else{
                    if(isset($api->results['message'])){
                        return array(
                            'error' => $api->results['message'],
                        );
                    }else{
                        return array(
                            'error' => 'Bad Response from Api!',
                        );
                    }
                }
            }catch(\Exception $e){
                return array(
                    'error' => $e->getMessage(),
                );
            }

        }else{
            if(isset($api->results['message'])){
                return array(
                    'error' => $api->results['message'],
                );
            }else{
                return array(
                    'error' => 'Bad Response from Api!',
                );
            }
        }

    } catch (\Exception $e) {
        return array(
            'error' => $e->getMessage(),
        );
    }
}
function pandimodule_CheckAvailability($params)
{
    if($params['Test']){
        logActivity('index CheckAvaibility run!');
        logActivity(json_encode($params));
    }
    // user defined configuration values
    $url        = $params['URL'];
    $token      = $params['Token'];
    $test       = $params['Test'];
    // availability check parameters
    $searchTerm = $params['searchTerm'];
    $tldsToInclude = $params['tldsToInclude'];
    $api_url = $url .'/api/whois?name='.$searchTerm;
    // Build post data
    $postfields = array(
        'data'          => array(),
        'url'           => $api_url,
        'token'         => $token,
        'test'          => $test,
        'name'          => 'CheckAvailability',
    );

    try {
        $api    = new Api();
        $data   = $api->request($postfields, 'GET');
        $tampil = array();
        
        if(!empty($data)){
            foreach($data as $key => $val){
                $do = '.'.$val['zone'];
                if(in_array($do, $tldsToInclude, true)){
                    $tampil[] = $val;
                }
            }
        }
        $results = new ResultsList();
        if(!empty($tampil)){
            foreach ($tampil as $domain) {
                $ex     = explode('.', $domain['domain']);
                $sld    = $ex[0];
                // Instantiate a new domain search result object
                $searchResult = new SearchResult($sld, '.'.$domain['zone']);

                // Determine the appropriate status to return
                if ($domain['available'] == true) {
                    $status = SearchResult::STATUS_NOT_REGISTERED;
                } elseif($domain['available'] == false) {
                    $status = SearchResult::STATUS_REGISTERED;
                } else {
                    $status = SearchResult::STATUS_TLD_NOT_SUPPORTED;
                }
                $searchResult->setStatus($status);
                //set domain not premium
                $searchResult->setPremiumDomain(false);
                // Append to the search results list
                $results->append($searchResult);
            }
        }
        logModuleCall(
            'Pandimodule',
            'CheckAvailability Response',
            $data,
            $tampil
        );
        return $results;

     }catch (\Exception $e){
        return array(
            'error' => $e->getMessage(),
        );
     }
}
function pandimodule_GetDomainSuggestions($params){
    if($params['Test']){
        logActivity('index GetDomainSugestions run!');
        logActivity(json_encode($params));
    }
    // user defined configuration values
    $url        = $params['URL'];
    $token      = $params['Token'];
    $test       = $params['Test'];
    // availability check parameters
    $searchTerm = $params['searchTerm'];
    $tldsToInclude = $params['tldsToInclude'];
    $api_url = $url .'/api/whois?name='.$searchTerm;
    // Build post data
    $postfields = array(
        'data'          => array(),
        'url'           => $api_url,
        'token'         => $token,
        'test'          => $test,
        'name'          => 'GetDomainSuggestions',
    );

    try {
        $api    = new Api();
        $data   = $api->request($postfields, 'GET');
        $tampil = array();
        if(!empty($data)){
            foreach($data as $key => $val){
                $do = '.'.$val['zone'];
                if(in_array($do, $tldsToInclude, true)){
                    $tampil[] = $val;
                }
            }     
        }  
        $results = new ResultsList();
        if(!empty($tampil)){
            foreach ($tampil as $domain) {
                $ex     = explode('.', $domain['domain']);
                $sld    = $ex[0];
                // Instantiate a new domain search result object
                $searchResult = new SearchResult($sld, '.'.$domain['zone']);

                // Determine the appropriate status to return
                if ($domain['available'] == true) {
                    $status = SearchResult::STATUS_NOT_REGISTERED;
                } elseif ($domain['available'] == false) {
                    $status = SearchResult::STATUS_REGISTERED;
                } else {
                    $status = SearchResult::STATUS_TLD_NOT_SUPPORTED;
                }
                $searchResult->setStatus($status);
                //set domain not premium
                $searchResult->setPremiumDomain(false);
                // Append to the search results list
                $results->append($searchResult);
            }
        }
        logModuleCall(
            'Pandimodule',
            'GetDomainSuggestions Response',
            $data,
            $tampil
        );
        return $results;

    }catch (\Exception $e){
        return array(
            'error' => $e->getMessage(),
        );
    }
}

function pandimodule_GetNameservers($params)
{
    if($params['Test']){
        logActivity('index GetNameserver run!');
        logActivity(json_encode($params));
    }
    // user defined configuration values
    $token      = $params['Token'];
    $url        = $params['URL'];
    $test       = $params['Test'];
    // domain parameters
    $sld            = $params['sld'];
    $tld            = $params['tld'];
    $domain         = $sld . '.' . $tld;
    $api_url        = $url .'/api/v1/reseller/domain/'. $domain;

    // Build post data
    $postfields = array(
        'data'          => array(),
        'url'           => $api_url,
        'token'         => $token,
        'test'          => $test,
        'name'          => 'GetNameservers',
    );

    try {
        $api = new Api();
        $api->request($postfields, 'GET');

        logModuleCall(
            'Pandimodule',
            'GetNameservers Response',
            $postfields,
            $api,
            $api
        );
        if($params['Test']){
            logActivity($api->results['code']);
        }
        if($api->results['code'] == 500){
            return array(
                'error' => $api->results['errors'],
            );
        }else if($api->results['code'] == 200){
            $ns = $api->results['nameserver'];
            $data = array();
            if(!empty($ns)){
                $a = 1;
                foreach($ns as $v){
                    $data['ns'.$a] = $v;
                    $a++;
                    if($a == 6){
                        break;
                    }
                }
            }
            if($params['Test']){
                logActivity(json_encode($data));
            }
            return $data;
        }else{
            return array(
                'error' => 'Bad Response from Api!',
            );
        }

    } catch (\Exception $e) {
        return array(
            'error' => $e->getMessage(),
        );
    }
}
function pandimodule_SaveNameservers($params)
{
    if($params['Test']){
        logActivity('index SaveNameserver run! ');
        logActivity(json_encode($params));
    }
    // user defined configuration values
    $token      = $params['Token'];
    $url        = $params['URL'];
    $test       = $params['Test'];

    // domain parameters
    $sld        = $params['sld'];
    $tld        = $params['tld'];
    $domain     = $sld . '.' . $tld;
    $api_url    = $url .'/api/v1/reseller/domain/' .$domain;
    // submitted nameserver values
    $ns = [
        $params['ns1'],
        $params['ns2'],
        $params['ns3'],
        $params['ns4'],
        $params['ns5'],
    ];
    $nameserver = array();
    foreach($ns as $key => $val){
        if(!empty($val)){
            $nameserver[] = $val;
        }
    }
    // Build post data
    $postfields = array(
        'data'          => array(),
        'url'           => $api_url,
        'token'         => $token,
        'test'          => $test,
        'name'          => 'SaveNameservers',
    );

    try {
        $api = new Api();
        $api->request($postfields, 'GET');
        if($params['Test']){
            logActivity($api->results['code']);
        }
        if($api->results['code'] == 200){
            $domain = [
                'hostList'      => $nameserver,
                'registrant_id' => $api->results['data']['registrant_id'],
                'admin_id'      => $api->results['data']['admin_id'],
                'tech_id'       => $api->results['data']['tech_id'],
                'billing_id'    => $api->results['data']['billing_id'],
            ];
            $url_update = $url .'/api/v1/reseller/domain/'.$api->results['data']['id'];
            $post = [
                'data'          => $domain,
                'url'           => $url_update,
                'token'         => $token,
                'test'          => $test,
                'name'          => 'SaveNameservers',
            ];
            try{
                $api = new Api();
                $api->request($post, 'PUT');
                if($params['Test']){
                    logActivity($api->results['code']);
                }
                if($api->results['code'] == 200){
                    return array(
                        'success' => true,
                    );
                }else{
                    return array(
                        'error' => 'Bad Response from Api!',
                    );
                }
            }catch(\Exception $e){
                return array(
                    'error' => $e->getMessage(),
                );
            }
        }else{
            return array(
                'error' => 'Bad Response from Api!',
            );
        }

    } catch (\Exception $e) {
        return array(
            'error' => $e->getMessage(),
        );
    }
}
function pandimodule_GetContactDetails($params)
{
    if($params['Test']){
        logActivity('index GetContactDetails run! ');
        logActivity(json_encode($params));
    }
    // user defined configuration values
    $token      = $params['Token'];
    $url        = $params['URL'];
    $test       = $params['Test'];
    // domain parameters
    $sld = $params['sld'];
    $tld = $params['tld'];
    $domain     = $sld . '.' . $tld;
    $api_url    = $url .'/api/v1/reseller/domain/'. $domain;
    // Build post data
    $postfields = array(
        'data'          => array(),
        'url'           => $api_url,
        'token'         => $token,
        'test'          => $test,
        'name'          => 'GetContactDetails',
    );
    try {
        $data  = array();
        $api = new Api();
        $api->request($postfields, 'GET');
        if($api->results['code'] == 200){
            $registrant_id = $api->results['data']['registrant_id'];
            $url_contact = $url .'/api/v1/reseller/contacts/'.$registrant_id;
            try{
                //detail registrant contact
                $contact = array(
                    'data'          => array(),
                    'url'           => $url_contact,
                    'token'         => $token,
                    'test'          => $test,
                    'name'          => 'GetContactDetails',
                );
                $api = new Api();
                $api->request($contact, 'GET');
                if($api->results['code'] == 200){
                    $ct         = explode(" ", $api->results['data']['name']);
                    $firstName  = $ct[0];
                    $lastName   = '';
                    if(!empty($ct[1])){
                        $lastName = preg_replace("/^(\w+\s)/", "", $api->results['data']['name']);
                    }
                    $data['Registrant'] = array(
                        'First Name'    => $firstName,
                        'Last Name'     => $lastName,
                        'Company Name'  => $api->results['data']['organization'],
                        'Email Address' => $api->results['data']['email'],
                        'Address 1'     => $api->results['data']['street'],
                        'Address 2'     => '',
                        'City'          => $api->results['data']['city'],
                        'State'         => $api->results['data']['state'],
                        'Postcode'      => $api->results['data']['zip_code'],
                        'Country'       => $api->results['data']['country_id'],
                        'Phone Number'  => $api->results['data']['phone'],
                        'Fax Number'    => $api->results['data']['fax'],
                    );

                }else{
                    return array(
                        'error' => 'Bad Response from Api!',
                    );
                }
                return $data;
            }catch (\Exception $e){
                return array(
                    'error' => $e->getMessage(),
                );
            }
        }else{
            return array(
                'error' => 'Bad Response from Api!',
            );
        }
        
    } catch (\Exception $e) {
        return array(
            'error' => $e->getMessage(),
        );
    }

}
function pandimodule_SaveContactDetails($params)
{
    if($params['Test']){
        logActivity('index SavecontactDetails run! ');
        logActivity(json_encode($params));
    }
    // user defined configuration values
    $token      = $params['Token'];
    $url        = $params['URL'];
    $test       = $params['Test'];
    // registration parameters
    $sld = $params['sld'];
    $tld = $params['tld'];
    $domain     = $sld . '.' . $tld;
    $api_url    = $url .'/api/v1/reseller/domain/'. $domain;
    $cd = $params['contactdetails'];
    // registrant information
    $fullName       = $cd['Registrant']['First Name'] . " " .$cd['Registrant']['Last Name']; // First name and last name combined
    $companyName    = $cd['Registrant']['Company Name'];
    $email          = $cd['Registrant']['Email Address'];
    $address1       = $cd['Registrant']['Address 1'];
    $address2       = $cd['Registrant']['Address 2'];
    $city           = $cd['Registrant']['City'];
    $state          = $cd['Registrant']['State']; // eg. TX
    $postcode       = $cd['Registrant']['Postcode']; // Postcode/Zip code
    $countryCode    = $cd['Registrant']['Country']; // eg. GB
    $phoneNumberFormatted = str_replace('-', '', $cd['Registrant']['Phone Number']); // Format: +CC.xxxxxxxxxxxx
    $fax            = str_replace("-", "",$cd['Registrant']['Fax Number']);

    // Build post data
    $postfields = array(
        'data'          => array(),
        'url'           => $api_url,
        'token'         => $token,
        'test'          => $test,
        'name'          => 'SaveContactDetails',
    );
    try {
        $api = new Api();
        $api->request($postfields, 'GET');
        if($api->results['code'] == 200){
            $registrant_id = $api->results['data']['registrant_id'];
            $url_update = $url .'/api/v1/reseller/contacts/'.$registrant_id;
            $data = array(
                'name'          => $fullName,
                'organization'  => $companyName,
                'email'         => $email,
                'street'        => $address1 .' '. $address2,
                'fax'           => $fax,
                'city'          => $city,
                'state'         => $state,
                'postal_code'   => $postcode,
                'country_id'    => $countryCode,
                'phone'         => $phoneNumberFormatted,
            );
            $contact = array(
                'token'     => $token,
                'url'       => $url_update,
                'test'      => $test,
                'data'      => $data,
                'name'      => 'SaveContactDetails',
            );
            try{
                $api = new Api();
                $api->request($contact, 'PUT');
                if($params['Test']){
                    logActivity(json_encode($api));
                }
                if($api->results['code'] == 200){
                    return array(
                        'success' => true,
                    );
                }else{
                    return array(
                        'error' => 'Bad Response from Api!',
                    ); 
                }

            }catch(\Exception $e){
                return array(
                    'error' => $e->getMessage(),
                ); 
            }
        }else{
            return array(
                'error' => 'Bad Response from Api!',
            ); 
        }
    } catch (\Exception $e) {
        return array(
            'error' => $e->getMessage(),
        );
    }
}
function pandimodule_GetRegistrarLock($params)
{
    if($params['Test']){
        logActivity('index GetRegistrarLock run! ');
        logActivity(json_encode($params));
    }
    // user defined configuration values
    $token      = $params['Token'];
    $url        = $params['URL'];
    $test       = $params['Test'];
    // domain parameters
    $sld            = $params['sld'];
    $tld            = $params['tld'];
    $domain         = $sld . '.' . $tld;
    $api_url        = $url .'/api/v1/reseller/domain/'. $domain;

    // Build post data
    $postfields = array(
        'data'          => array(),
        'url'           => $api_url,
        'token'         => $token,
        'test'          => $test,
        'name'          => 'GetRegistrarLock',
    );

    try {
        $lock = 'unlocked';
        $api = new Api();
        $api->request($postfields, 'GET');

        if($params['Test']){
            logActivity($api->results['code']);
        }
        if($api->results['code'] == 500){
            return array(
                'error' => $api->results['errors'],
            );
        }else if($api->results['code'] == 200){
            if(!empty($api->results['status'])){
                foreach($api->results['status'] as $key => $v){
                    if($v == 'clientTransferProhibited' || $v == 'clientDeleteProhibited'){
                        $lock = 'locked';
                    }
                }
            }
            return $lock;
        }else{
            return array(
                'error' => 'Bad Response from Api!',
            );
        }

    } catch (\Exception $e) {
        return array(
            'error' => $e->getMessage(),
        );
    }
}
function pandimodule_SaveRegistrarLock($params)
{
    if($params['Test']){
        logActivity('index SaveRegistrarLock run! ');
        logActivity(json_encode($params));
    }
    $lockStatus = $params['lockenabled'];
    // user defined configuration values
    $token      = $params['Token'];
    $url        = $params['URL'];
    $test       = $params['Test'];
    // domain parameters
    $sld            = $params['sld'];
    $tld            = $params['tld'];
    $domain         = $sld . '.' . $tld;
    $api_url        = '';
    if($lockStatus == 'locked'){
        $api_url        = $url .'/api/v1/reseller/domain/'. $domain.'/lock';
    }else if($lockStatus == 'unlocked'){
        $api_url        = $url .'/api/v1/reseller/domain/'. $domain.'/unlock';
    }

    // Build post data
    $postfields = array(
        'data'          => array(),
        'url'           => $api_url,
        'token'         => $token,
        'test'          => $test,
        'name'          => 'SaveRegistrarLock',
    );

    try {
        $api = new Api();
        $api->request($postfields, 'PUT');

        if($params['Test']){
            logActivity($api->results['code']);
        }
        if($api->results['code'] == 500){
            return array(
                'error' => $api->results['errors'],
            );
        }else if($api->results['code'] == 200){
            return array(
                'success' => 'success',
            );
        }else{
            return array(
                'error' => 'Bad Response from Api!',
            );
        }

    } catch (\Exception $e) {
        return array(
            'error' => $e->getMessage(),
        );
    }
}
function pandimodule_GetEPPCode($params)
{
    if($params['Test']){
        logActivity('index GetEPPCode run! ');
        logActivity(json_encode($params));
    }
    // user defined configuration values
    $token      = $params['Token'];
    $url        = $params['URL'];
    $test       = $params['Test'];
    // domain parameters
    $sld            = $params['sld'];
    $tld            = $params['tld'];
    $domain         = $sld . '.' . $tld;
    $api_url        = $url .'/api/v1/reseller/domain/'. $domain;

    // Build post data
    $postfields = array(
        'data'          => array(),
        'url'           => $api_url,
        'token'         => $token,
        'test'          => $test,
        'name'          => 'GetEPPCode',
    );

    try {
        $api = new Api();
        $api->request($postfields, 'GET');

        if($params['Test']){
            logActivity($api->results['code']);
        }
        if($api->results['code'] == 500){
            return array(
                'error' => $api->results['errors'],
            );
        }else if($api->results['code'] == 200){
            if(!empty($api->results['eppCode'])){
                return array(
                    'eppcode' => $api->results['eppCode'],
                );
            }else{
                return array(
                    'error' => 'Domain is not Active, Please call a Reseller!',
                );
            }
            
        }else{
            return array(
                'error' => 'Bad Response from Api!',
            );
        }

    } catch (\Exception $e) {
        return array(
            'error' => $e->getMessage(),
        );
    }
}
function pandimodule_RequestDelete($params)
{
    if($params['Test']){
        logActivity('index RequestDelete run! ');
        logActivity(json_encode($params));
    }
    // user defined configuration values
    $token      = $params['Token'];
    $url        = $params['URL'];
    $test       = $params['Test'];
 
    $sld = $params['sld'];
    $tld = $params['tld'];
    $domain         = $sld . '.' . $tld;

    $api_url    = $url .'/api/v1/reseller/domain/' .$domain.'/delete';
    // Build post data
    $postfields = array(
        'token'     => $token,
        'url'       => $api_url,
        'test'      => $test,
        'data'      => array(),
        'name'      => 'RequestDelete',
    );

    try {
        $api = new Api();
        $api->request($postfields, 'DELETE');
        if($params['Test']){
            logActivity(json_encode($api));
        }
        if($api->results['code'] == 200){
            return array(
                'success' => 'success',
            );
        }else{
            if(isset($api->results['message'])){
                return array(
                    'error' => $api->results['message'],
                );
            }else{
                return array(
                    'error' => 'Bad Response from Api!',
                );
            }
        }

    } catch (\Exception $e) {
        return array(
            'error' => $e->getMessage(),
        );
    }
}
function pandimodule_RegisterNameserver($params)
{
    if($params['Test']){
        logActivity('index RegisterNameserver run! ');
        logActivity(json_encode($params));
    }
     // user defined configuration values
    $token      = $params['Token'];
    $url        = $params['URL'];
    $test       = $params['Test'];

    // domain parameters
    $sld = $params['sld'];
    $tld = $params['tld'];
    $api_url = $url .'/api/v1/reseller/host';
    // nameserver parameters
    $nameserver = $params['nameserver'];
    $ipv4 = '';
    $ipv6 = '';
    $ip   = $params['ipaddress'];
    if(filter_var($ip, FILTER_VALIDATE_IP,FILTER_FLAG_IPV4)){
        $ipv4 = $ip;
    }else if(filter_var($ip, FILTER_VALIDATE_IP,FILTER_FLAG_IPV6)){
        $ipv6 = $ip;
    }else{
        return array(
            'error' => 'IP address is not valid!',
        );
    }
    $host = [
        'name'      => $nameserver,
        'ipv4'      => $ipv4,
        'ipv6'      => $ipv6,
    ];
    // Build post data
    $postfields = array(
        'token'     => $token,
        'url'       => $api_url,
        'test'      => $test,
        'data'      => $host,
        'name'      => 'RegisterNameserver',
    );

    try {
        $api = new Api();
        $api->request($postfields, 'POST');
        if($params['Test']){
        logActivity($api->results['code']);
    }
    if($api->results['code'] == 200){
        return array(
            'success' => true,
        );
    }else{
        if(isset($api->results['message'])){
            return array(
                'error' => $api->results['message'],
            );
        }else{
            return array(
                'error' => 'Bad Response from Api!',
            );
        }
    }

    } catch (\Exception $e) {
        return array(
            'error' => $e->getMessage(),
        );
    }
}
function pandimodule_ModifyNameserver($params)
{
    if($params['Test']){
        logActivity('index Modifynameserver run!');
        logActivity(json_encode($params));
    }
    // user defined configuration values
    $token      = $params['Token'];
    $url        = $params['URL'];
    $test       = $params['Test'];

    $sld = $params['sld'];
    $tld = $params['tld'];

    // nameserver parameters
    $nameserver = $params['nameserver'];
    $api_url    = $url .'/api/v1/reseller/host/' .$nameserver.'/update';
    $ipv4 = '';
    $ipv6 = '';
    $ip   = $params['newipaddress'];
    if(filter_var($ip, FILTER_VALIDATE_IP,FILTER_FLAG_IPV4)){
        $ipv4 = $ip;
    }else if(filter_var($ip, FILTER_VALIDATE_IP,FILTER_FLAG_IPV6)){
        $ipv6 = $ip;
    }else{
        return array(
            'error' => 'IP address is not valid!',
        );
    }
    $host = [
        'name'      => $nameserver,
        'ipv4'      => $ipv4,
        'ipv6'      => $ipv6,
    ];
    // Build post data
    $postfields = array(
        'token'     => $token,
        'url'       => $api_url,
        'test'      => $test,
        'data'      => $host,
        'name'      => 'ModifyNameserver',
    );

    try {
        $api = new Api();
        $api->request($postfields, 'PUT');
        if($params['Test']){
            logActivity(json_encode($api));
        }
        if($api->results['code'] == 200){
            return array(
                'success' => 'success',
            );
        }else{
            if(isset($api->results['message'])){
                return array(
                    'error' => $api->results['message'],
                );
            }else{
                return array(
                    'error' => 'Bad Response from Api!',
                );
            }
        }

    } catch (\Exception $e) {
        return array(
            'error' => $e->getMessage(),
        );
    }
}
function pandimodule_DeleteNameserver($params)
{
    if($params['Test']){
        logActivity('index DeleteNameserver run!');
        logActivity(json_encode($params));
    }
     // user defined configuration values
     $token      = $params['Token'];
     $url        = $params['URL'];
     $test       = $params['Test'];
 
    $sld = $params['sld'];
    $tld = $params['tld'];

    // nameserver parameters
    $nameserver = $params['nameserver'];
    $api_url    = $url .'/api/v1/reseller/host/' .$nameserver.'/delete';
    // Build post data
    $postfields = array(
        'token'     => $token,
        'url'       => $api_url,
        'test'      => $test,
        'data'      => array(),
        'name'      => 'DeleteNameserver',
    );

    try {
        $api = new Api();
        $api->request($postfields, 'DELETE');
        if($params['Test']){
            logActivity(json_encode($api));
        }
        if($api->results['code'] == 200){
            return array(
                'success' => 'success',
            );
        }else{
            if(isset($api->results['message'])){
                return array(
                    'error' => $api->results['message'],
                );
            }else{
                return array(
                    'error' => 'Bad Response from Api!',
                );
            }
        }

    } catch (\Exception $e) {
        return array(
            'error' => $e->getMessage(),
        );
    }
}
function pandimodule_TransferDomain($params)
{
    if($params['Test']){
        logActivity('index TransferDomain run!');
        logActivity(json_encode($params));
    }
    // user defined configuration values
   $token      = $params['Token'];
   $url        = $params['URL'];
   $test       = $params['Test'];

   // registration parameters
   $sld = $params['sld'];
   $tld = $params['tld'];
   $domain      = $sld . '.' . $tld;
   $eppCode     = $params['eppcode'];
   $api_url     = $url .'/api/v1/reseller/domain/transfer';
   $data = [
        'name'      => $domain,
        'authcode'  => $eppCode,
   ];
   // Build post data
   $postfields = array(
       'token'     => $token,
       'url'       => $api_url,
       'test'      => $test,
       'data'      => $data,
       'name'      => 'TransferDomain',
   );
   try {
        $api = new Api();
        $api->request($postfields, 'POST');
        if($params['Test']){
            logActivity(json_encode($api->results['code']));
        }
        if($api->results['code'] == 200){
            return array(
                'success' => true,
            );
        }else{
            if(isset($api->results['message'])){
                return array(
                    'error' => $api->results['message'],
                );
            }else{
                return array(
                    'error' => 'Bad Response from Api!',
                );
            }
        }
   } catch (\Exception $e) {
       return array(
           'error' => $e->getMessage(),
       );
   }
}
function pandimodule_RenewDomain($params)
{
    if($params['Test']){
        logActivity('index RenewDomain run!');
        logActivity(json_encode($params));
    }
   // user defined configuration values
   $token      = $params['Token'];
   $url        = $params['URL'];
   $test       = $params['Test'];

   // registration parameters
   $sld = $params['sld'];
   $tld = $params['tld'];
   $domain         = $sld . '.' . $tld;
   $registrationPeriod = $params['regperiod'];
   $api_url    = $url .'/api/v1/reseller/domain/' .$domain.'/renew';
   $data = [
        'period'    => $registrationPeriod,
   ];
   // Build post data
   $postfields = array(
       'token'     => $token,
       'url'       => $api_url,
       'test'      => $test,
       'data'      => $data,
       'name'      => 'RenewDomain',
   );
   try {
        $api = new Api();
        $api->request($postfields, 'POST');
        if($params['Test']){
            logActivity(json_encode($api->results['code']));
        }
        if($api->results['code'] == 200){
            return array(
                'success' => true,
            );
        }else{
            if(isset($api->results['message'])){
                return array(
                    'error' => $api->results['message'],
                );
            }else{
                return array(
                    'error' => 'Bad Response from Api!',
                );
            }
        }
   } catch (\Exception $e) {
       return array(
           'error' => $e->getMessage(),
       );
   }
}
function pandimodule_Sync($params)
{
    if($params['Test']){
        logActivity('index Sync run!');
        logActivity(json_encode($params));
    }
    // user defined configuration values
    $token      = $params['Token'];
    $url        = $params['URL'];
    $test       = $params['Test'];
 
    $sld = $params['sld'];
    $tld = $params['tld'];
    $domain         = $sld . '.' . $tld;

    $api_url    = $url .'/api/v1/reseller/domain/' .$domain.'/sync';
    // Build post data
    $postfields = array(
        'token'     => $token,
        'url'       => $api_url,
        'test'      => $test,
        'data'      => array(),
        'name'      => 'Sync',
    );

    try {
        $api = new Api();
        $api->request($postfields, 'GET');
        if($params['Test']){
            logActivity(json_encode($api));
        }
        if($api->results['code'] == 200){
            return array(
                'expirydate'        => $api->results['data']['expirydate'],
                'active'            => (bool) $api->results['data']['active'],
                'expired'           => (bool) $api->results['data']['expired'],
                'transferredAway'   => (bool) $api->results['data']['transfer'],
            );
        }else{
            if(isset($api->results['message'])){
                return array(
                    'error' => $api->results['message'],
                );
            }else{
                return array(
                    'error' => 'Bad Response from Api!',
                );
            }
        }
    } catch (\Exception $e) {
        return array(
            'error' => $e->getMessage(),
        );
    }
}
function pandimodule_TransferSync($params)
{
    if($params['Test']){
        logActivity('index TransferSync run!');
        logActivity(json_encode($params));
    }
    // user defined configuration values
    $token      = $params['Token'];
    $url        = $params['URL'];
    $test       = $params['Test'];
 
    $sld = $params['sld'];
    $tld = $params['tld'];
    $domain         = $sld . '.' . $tld;

    $api_url    = $url .'/api/v1/reseller/domain/' .$domain.'/transferSync';
    // Build post data
    $postfields = array(
        'token'     => $token,
        'url'       => $api_url,
        'test'      => $test,
        'data'      => array(),
        'name'      => 'TransferSync',
    );

    try {
        $api = new Api();
        $api->request($postfields, 'GET');
        if($params['Test']){
            logActivity(json_encode($api));
        }
        if($api->results['code'] == 200){
            if($api->results['data'] == 1){
                //pending and approve
                return array();
            }else if($api->results['data'] == 2){
                //failed
                return array(
                    'failed' => true,
                    'reason' => 'Domain Reject!',
                );
            }else if($api->results['data'] == 3){
                //success
                return array(
                    'completed'     => true,
                    'expirydate'    => $api->results['data']['expirydate'],
                );
            }else{
                return array();
            }
        }else{
            if(isset($api->results['message'])){
                return array(
                    'error' => $api->results['message'],
                );
            }else{
                return array(
                    'error' => 'Bad Response from Api!',
                );
            }
        }
    } catch (\Exception $e) {
        return array(
            'error' => $e->getMessage(),
        );
    }
}
