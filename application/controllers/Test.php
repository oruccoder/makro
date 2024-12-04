<?php

require_once APPPATH . 'third_party/vendor/autoload.php';
require_once APPPATH . 'third_party/qrcode/vendor/autoload.php';


use Guzzle\Sendpulse\RestApi\ApiClient;
use Guzzle\Sendpulse\RestApi\Storage\FileStorage;

define('API_USER_ID', 'a41eb5e7275e6b201ed4d9e5fa1a0012');
define('API_SECRET', '2b192cd0276590f3a3d836b6e75263c9');
define('PATH_TO_ATTACH_FILE', __FILE__);

class Test extends CI_Controller
{
    public function __construct()
    {
        parent:: __construct();
    }

    function index()
    {

        $SPApiClient = new ApiClient(API_USER_ID, API_SECRET, new FileStorage());



        $task = array(
            'title' => 'Hello!',
            'body' => 'This is my first push message',
            'website_id' => 66944,
            'ttl' => 20,
            'stretch_time' => 10,
            'link'=>'http://muhasebe.italicsoft.com'
        );
        var_dump($SPApiClient->createPushTask($task));



    }




}