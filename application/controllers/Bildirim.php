<?php
class Bildirim extends CI_Controller {

    private $pusher;

    public function __construct()
    {
        parent::__construct();

        $this->pusher = new Pusher\Pusher(
            '2c098247cf83993ae135', // Pusher Key
            '8299b5908ae0ee9d42ce', // Pusher Secret
            '1898110', // Pusher App ID
            [
                'cluster' => 'ap2', // Pusher Cluster
                'useTLS' => true
            ]
        );
    }

    // Veri değiştiğinde Pusher ile bildirim gönder
    public function send_notification()
    {
        $approvalCount = 50;
        $userId = 21;

        $data = [
            'message' => "Yeni onay sayısı: $approvalCount",
            'approval_count' => $approvalCount,
        ];

        // Kullanıcı bazlı kanala bildirim gönder
        if($this->pusher->trigger("user-$userId", 'approval-updated', $data)){
            echo json_encode(['status' => 'success']);
        }


    }


}

