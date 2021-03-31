<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ini_set('MAX_EXECUTION_TIME', -1);
error_reporting(E_ALL ^ E_WARNING);

class fitbox_controller extends CI_Controller {


    const LOGIN_URL = 'https://app.f3fitbox.com/auth/user/login';
    const API_BASE_URL = 'https://app.f3fitbox.com/fs1';

    const CONTENT_TYPE_JSON = 'Content-Type: application/json';
    const AUTH_BEARER = 'Authorization: Bearer ';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Example: {{BASE_URL}}/index.php/fitbox_controller/login
     */
    public function login()
    {
        //$email = $_POST['email'];
        //$password = $_POST['password'];

        $email = "716fGGi4PqI8aHMv19KJjcaaHRFPitwm";
        $password = "1234";

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => self::LOGIN_URL,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => 'email=' . $email . '&password=' . $password,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded',
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        header(self::JSON_HEADER);
        echo $response;
    }

    /**
     * Example: {{BASE_URL}}/index.php/fitbox_controller/get_classes?from=2020-10-24&to=2020-11-24&finished=false
     */
    public function get_classes()
    {
        $headers = apache_request_headers();
        $token = $headers['X-Auth-Token'];

        $from = $_GET['from'];
        $to = $_GET['to'];
        $finished = $_GET['finished'];
        $fields = "\\nid,\\ntim\\n";

        $query = '{"query":"{\\nclasses(\\nfrom: \\"' . $from . '\\"\\nto: \\"' . $to . '\\"\\nfinished: ' . $finished . '\\n){' . $fields . '}\\n}","variables":{}}';

        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => self::API_BASE_URL,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        //CURLOPT_POSTFIELDS => '{"query":"{\\nclasses(\\nfrom: \\"2020-10-24\\"\\nto: \\"2020-11-24\\"\\nfinished: false\\n){\\nid,\\ntim\\n}\\n}","variables":{}}',
        CURLOPT_POSTFIELDS => $query,
        CURLOPT_HTTPHEADER => array(
            self::AUTH_BEARER . $token,
            self::CONTENT_TYPE_JSON,
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        header(self::CONTENT_TYPE_JSON);
        echo $response;

    }

    /**
     * Example: {{BASE_URL}}/index.php/fitbox_controller/get_class?id=$id
     */
    public function get_class_by_id()
    {
        $headers = apache_request_headers();
        $token = $headers['X-Auth-Token'];

        $id = $_GET['id'];
        //$fields = "\\nid,\\ntim\\n bookings {\\nid\\nfitboxer {\\nid\\neml\\n}\\n}";

        $query = '{"query":"{\\nclass(id: ' . $id . '){\\nid,\\ntim,\\nbookings {\\n            id\\n            fitboxer {\\n                id\\n                eml\\n            }\\n        }\\n        }\\n}","variables":{}}';

        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => self::API_BASE_URL,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        //CURLOPT_POSTFIELDS => '{"query":"{\\nclasses(\\nfrom: \\"2020-10-24\\"\\nto: \\"2020-11-24\\"\\nfinished: false\\n){\\nid,\\ntim\\n}\\n}","variables":{}}',
        CURLOPT_POSTFIELDS => $query,
        CURLOPT_HTTPHEADER => array(
            self::AUTH_BEARER . $token,
            self::CONTENT_TYPE_JSON,
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        header(self::CONTENT_TYPE_JSON);
        echo $response;

    }


    /**
     curl --location --request GET '{{BASE_URL}}/index.php/fitbox_controller/get_fitboxer?profileId=1' \
     --header 'X-Auth-Token: JzjxkgJiZlovqyFC-gz3ZpI9wfOKslJq' \
     */
    public function get_fitboxer() {
        $headers = apache_request_headers();
        $token = $headers['X-Auth-Token'];

        $profileId = $_GET['profileId'];

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => self::API_BASE_URL,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{"query":"{\\n  fitboxer(profileId: \\"' . $profileId . '\\") {\\n    name\\n  }\\n}","variables":{}}',
        CURLOPT_HTTPHEADER => array(
            self::AUTH_BEARER . $token,
            self::CONTENT_TYPE_JSON,
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        header(self::CONTENT_TYPE_JSON);
        echo $response;

    }

    /**
     * Example :
     curl --location --request GET '{{base_url}}/index.php/fitbox_controller/get_booking?from=2021-01-01&to=2021-01-30&v7ProfileId=1' \
     --header 'X-Auth-Token: JzjxkgJiZlovqyFC-gz3ZpI9wfOKslJq' \
     */
    public function get_booking() {
        $headers = apache_request_headers();
        $token = $headers['X-Auth-Token'];

        $from = $_GET['from'];
        $to = $_GET['to'];
        $v7ProfileId = $_GET['v7ProfileId'];
        $fields = "\\nid,\\ntim\\n";

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => self::API_BASE_URL,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{"query":"{\\nbookings(\\nfrom: \\"' . $from . '\\"\\nto: \\"' . $to . '\\"\\nv7ProfileId : ' . $v7ProfileId . '\\n){' . $fields . '}\\n}","variables":{}}',
        CURLOPT_HTTPHEADER => array(
            self::AUTH_BEARER . $token,
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        header(self::CONTENT_TYPE_JSON);
        echo $response;

    }
    /**
     * Example: {{BASE_URL}}/index.php/fitbox_controller/set_booking?classId=1&v7ProfileId=1&bag=3
     */
    public function set_booking()
    {
        $headers = apache_request_headers();
        $token = $headers['X-Auth-Token'];

        $classId = $_GET['classId'];
        $v7ProfileId = $_GET['v7ProfileId'];
        $bag = $_GET['bag'];

        $query = '{"query":"mutation {\\nsetBooking(classId: ' . $classId . ', v7ProfileId: ' . $v7ProfileId . ', bag: ' . $bag . ')\\n}","variables":{}}';

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => self::API_BASE_URL,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $query,
        CURLOPT_HTTPHEADER => array(
            self::AUTH_BEARER . $token,
            self::CONTENT_TYPE_JSON,
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        header(self::CONTENT_TYPE_JSON);
        echo $response;

    }

    /**
     Example
     curl --location --request GET '{{base_url}}/index.php/fitbox_controller/delete_booking?classId=1&v7ProfileId=1' \
     --header 'X-Auth-Token: JzjxkgJiZlovqyFC-gz3ZpI9wfOKslJq'
     */
    public function delete_booking() {
        $headers = apache_request_headers();
        $token = $headers['X-Auth-Token'];

        $classId = $_GET['classId'];
        $v7ProfileId = $_GET['v7ProfileId'];

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => self::API_BASE_URL,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{"query":"mutation {\\ndeleteBooking(classId: ' . $classId . ', v7ProfileId: ' . $v7ProfileId . ')\\n}","variables":{}}',
        CURLOPT_HTTPHEADER => array(
            self::AUTH_BEARER . $token,
            self::CONTENT_TYPE_JSON,
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        header(self::CONTENT_TYPE_JSON);
        echo $response;

    }
}