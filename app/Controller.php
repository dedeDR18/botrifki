<?php

use Unirest\Request; //panggil depedensi unirest

class Controller{
    private $access_token  = "eyJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjo5MTcwNSwidGltZXN0YW1wIjoiMjAxOS0xMi0xOCAxODozMDo0NiArMDcwMCJ9.xmpOp1FF-n-eoW-guSsF5GtleQbQa4DwcrFCizygstM"; //akses token dapat diambil dari sini https://qisme.qiscus.com/app/kiwari-prod
    private $apiurl    = "https://api.chataja.co.id/api/v1/chat/conversations/"; //dokumentasi penggunaan api ada disini http://qisme-docs.herokuapp.com/api-docs/
    private $headers = array(
        'Content-Type' => 'application/json',
        'Content-Type' => 'multipart/form-data'
    ); //set headers untuk request
    private $apiResponse; //response atribut

    function __construct(){
    }

    //ambil nilai response yang sudah di tampung ke atribut
    private function getapiResponse(){
        return $this->apiResponse;
    }

    //ambil konten response dari webhook ke callback url
    private function getResponseContent(){
        return json_decode(file_get_contents("php://input"), true);
    }

    //tampung konten dari webhook ke atribut
    private function getResponse(){
        $this->apiResponse = $this->getResponseContent();

        //log untuk memastikan konten response dari webhook barhasil diambil
        file_put_contents('log-comment.txt', json_encode($this->getapiResponse(), JSON_PRETTY_PRINT));
    }

    //contoh penggunaan api post-comment untuk jenis button
    private function replyCommandButton($display_name,$room_id){
        $comment ="Halo, ".$display_name." jika kamu berhalangan hadir, kamu bisa ngamplop online loh...";
        $payload = array(
            "text" => $comment,
            "buttons" => array(
                array(
                    "label" => "LinkAja!",
                    "type" => "link",
                    "payload" => array(
                        "url" => "https://drive.google.com/file/d/1jPzFyLmywSZW-ouGIk4z6je4niPbcuuF/view?usp=sharing",
                        "method" => "get",
                    )
                ),
                array(
                    "label" => "Ovo",
                    "type" => "link",
                    "payload" => array(
                        "url" => "https://drive.google.com/file/d/1xym3qrCRVIrys67o44LN1zffYC39hJj1/view?usp=sharing",
                        "method" => "get"
                    )
                ),
                array(
                    "label" => "Gopay",
                    "type" => "link",
                    "payload" => array(
                        "url" => "https://drive.google.com/file/d/1f5AhrSIplbSrGrE2YMfq3pl23bdJrO1M/view?usp=sharing",
                        "method" => "get",
                    )
                ),
            )
        );
        $replay = array(
            'access_token'=>$this->access_token,
            'topic_id'=>$room_id,
            'type'=>'buttons',
            'payload'=> json_encode($payload)
        );
        $buttons  = Request::post($this->apiurl."post_comment", $this->headers, $replay);
        $buttons->raw_body;
    }

    //contoh penggunaan api post-comment untuk jenis text
    private function replyCommandTextHari($display_name,$message_type,$room_id){
        $comment = 
        "Pernikahan kami akan dilaksanakan pada hari Minggu, 22 Desember 2019";

        $replay = array(
            'access_token'=>$this->access_token,
            'topic_id'=>$room_id,
            'type'=>'text',
            'comment'=> $comment
        );
        $post_comment  = Request::post($this->apiurl."post_comment", $this->headers, $replay);
        $post_comment->raw_body;
    }

    private function replyCommandTextAgenda($display_name,$message_type,$room_id){
        $comment = 
        "https://drive.google.com/file/d/1g5f7JHyWH19INnbYIuHxNC3ru0ljJ8X9/view?usp=sharing";

        $replay = array(
            'access_token'=>$this->access_token,
            'topic_id'=>$room_id,
            'type'=>'text',
            'comment'=> $comment
        );
        $post_comment  = Request::post($this->apiurl."post_comment", $this->headers, $replay);
        $post_comment->raw_body;
    }

    private function replyCommandText($display_name,$message_type,$room_id){
        $comment = 
        "kamu bisa akses bot pernikahan kami dengan menuliskan perintah /halalinaja";

        $replay = array(
            'access_token'=>$this->access_token,
            'topic_id'=>$room_id,
            'type'=>'text',
            'comment'=> $comment
        );
        $post_comment  = Request::post($this->apiurl."post_comment", $this->headers, $replay);
        $post_comment->raw_body;
    }

    private function replyCommandTextVendor($display_name,$message_type,$room_id){
        $comment = "MAKEUP  : NEY MAKE UP\n
DEKORASI : EMTU WEDDING\n
DOKUMENTASI : MAGENTA \n
UPACARA ADAT : SEKAR PUSAKA\n
MASTER OF CEREMONY : SARIVA\n
WEDDING ORGANIZER : EMTU WEDDING\n
ENTERTAINMENT : DMT MUSIC\n
CATERING : IKA CATERING";

        $replay = array(
            'access_token'=>$this->access_token,
            'topic_id'=>$room_id,
            'type'=>'text',
            'comment'=> $comment
        );
        $post_comment  = Request::post($this->apiurl."post_comment", $this->headers, $replay);
        $post_comment->raw_body;
    }

    //contoh penggunaan api post-comment untuk jenis location
    private function replyCommandLocation($room_id){
        $payload = array(
            "name" => "Lapangan",
            "address" => "Tanjung Siang, Subang",
            "latitude" => "-6.7389639",
            "longitude" => "107.7996594",
            "map_url" => "https://www.google.com/maps/@-6.7389639,107.7996594,3a,75y,274.7h,77.74t"
        );
        $replay = array(
            'access_token'=>$this->access_token,
            'topic_id'=>$room_id,
            'type'=>'location',
            'payload'=> json_encode($payload)
        );
        $location  = Request::post($this->apiurl."post_comment", $this->headers, $replay);
        $location->raw_body;
    }

    //contoh penggunaan api post-comment untuk jenis carousel
    private function replyCommandCarousel($room_id){
        $payload = array(
            "cards" => array(
                array(
                    "image" => "https://i.ibb.co/4pm7JL2/750-9191.jpg",
                    "title" => "Yuni & Rifki wedding",
                    "description" => "Terimakasih sudah ikut berpartisipasi dalam acara pernikahan kami :)",
                    "default_action" => array(
                        "type" => "link",
                        "payload" => array(
                            "url" => "https://ibb.co/pd0xnTQ",
                            "method" => "GET",
                        )
                    ),
                    "buttons" => array(
                        array(
                            "label" => "Hari Pernikahan",
                            "type" => "postback",
                            "postback_text" => "/haripernikahan",
                            "payload" => array(
                                "url" => "#",
                                "method" => "GET",
                                "payload" => null
                            )
                        ),
                        array(
                            "label" => "Lokasi Pernikahan",
                            "type" => "postback",
                            "postback_text" => "/lokasipernikahan",
                            "payload" => array(
                                "url" => "#",
                                "method" => "GET",
                                "payload" => null
                            )
                        ),
                        array(
                            "label" => "Agenda Pernikahan",
                            "type" => "postback",
                            "postback_text" => "/agendapernikahan",
                            "payload" => array(
                                "url" => "#",
                                "method" => "GET",
                                "payload" => null
                            )
                        ),
                        array(
                            "label" => "Vendor Pernikahan",
                            "type" => "postback",
                            "postback_text" => "/vendorpernikahan",
                            "payload" => array(
                                "url" => "#",
                                "method" => "GET",
                                "payload" => null
                            )
                        ),
                        array(
                            "label" => "Kamu tidak bisa hadir?",
                            "type" => "postback",
                            "postback_text" => "/amploponline",
                            "payload" => array(
                                "url" => "#",
                                "method" => "GET",
                                "payload" => null
                            )
                        )
                    )
                )
            )
        );
        $replay = array(
            'access_token'=>$this->access_token,
            'topic_id'=>$room_id,
            'type'=>'carousel',
            'payload'=> json_encode($payload)
        );
        $carousel  = Request::post($this->apiurl."post_comment", $this->headers, $replay);
        $carousel->raw_body;
    }

    //contoh penggunaan api post-comment untuk jenis card
    private function replyCommandCard($room_id){
        $payload = array(
            "text" => "Special deal buat sista nih..",
            "image" => "https://ibb.co/qWtBC4C",
            "title" => "Gambar 1",
            "description" => "Card Double Button",
            "url" => "http://url.com/baju?id=123%26track_from_chat_room=123",
            "buttons" => array(
                array(
                    "label" => "Button 1",
                    "type" => "postback",
                    "postback_text" => "Load More...",
                    "payload" => array(
                        "url" => "#",
                        "method" => "GET",
                        "payload" => null
                    )
                ),
                array(
                    "label" => "Button 2",
                    "type" => "postback",
                    "postback_text" => "Load More...",
                    "payload" => array(
                        "url" => "#",
                        "method" => "GET",
                        "payload" => null
                    )
                )
            )
        );
        $replay = array(
            'access_token'=>$this->access_token,
            'topic_id'=>$room_id,
            'type'=>'card',
            'payload'=> json_encode($payload)
        );
        $card  = Request::post($this->apiurl."post_comment", $this->headers, $replay);
        $card->raw_body;
    }

    //method untuk running bot
    function run(){
        //ambil response
        $this->getResponse();

        //tampung nilai response ke model
        $data = new Model(
            $this->getapiResponse()['chat_room']['qiscus_room_id'],
            $this->getapiResponse()['message']['text'],
            $this->getapiResponse()['message']['type'],
            $this->getapiResponse()['from']['fullname']
        );

        //cek pesan dari chat tidak kosong & cari chat yang mengandung '/' untuk menjalankan command bot
        $find_slash = strpos($data->getMessage(), '/');
        if($data->getMessage() != null && $find_slash !== false){
            //ambil nilai text setelah karakter '/'
            $command = explode("/",$data->getMessage());
            if(isset($command[1])){
                switch($command[1]){
                    case 'lokasipernikahan':
                        $this->replyCommandLocation($data->getRoomId());
                        break;
                    case 'halalinaja':
                        $this->replyCommandCarousel($data->getRoomId());
                        break;
                    case 'agendapernikahan':
                        $this->replyCommandTextAgenda($data->getSender(),$data->getMessageType(),$data->getRoomId());
                        break;
                    case 'amploponline':
                        $this->replyCommandButton($data->getSender(),$data->getRoomId());
                        break;
                    case 'card':
                        $this->replyCommandCard($data->getRoomId());
                        break;
                    case 'haripernikahan':
                        $this->replyCommandTextHari($data->getSender(),$data->getMessageType(),$data->getRoomId());
                        break;
                    case 'vendorpernikahan':
                        $this->replyCommandTextVendor($data->getSender(),$data->getMessageType(),$data->getRoomId());
                        break;  
                    default:
                        $this->replyCommandText($data->getSender(),$data->getMessageType(),$data->getRoomId());
                        break;            
                }
            }else{
                $this->replyCommandText($data->getSender(),$data->getMessageType(),$data->getRoomId());
            }
        }
    }
}