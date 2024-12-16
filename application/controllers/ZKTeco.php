<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ZKTeco extends CI_Controller {

    private $pgsql_db;

    public function __construct() {
        parent::__construct();

        // PostgreSQL veritabanına bağlan
       // $conn = pg_connect("host=localhost port=5432 dbname=makrodb user=makro password=makro7373");
    }

    public function index() {
        $host = "5.191.111.238";
        $port = "5432";
        $dbname = "makrodb";
        $user = "makro";
        $password = "makro7373"; // makro kullanıcısı için tanımlanan şifreyi girin

        // PostgreSQL'e bağlan
        $conn = pg_connect("host= 10.10.0.20 port=5432 dbname=makrodb user=makro password=makro7373");

        //$conn = pg_connect("host=host.docker.internal port=5432 dbname=makrodb user=makro password=makro7373");
        if ($conn) {
            echo "PostgreSQL bağlantısı başarılı!\n";

            // Veritabanında sorgu çalıştır
            $result = pg_query($conn, "SELECT * FROM pg_database;");
            if ($result) {
                while ($row = pg_fetch_assoc($result)) {
                    print_r($row);
                }
            } else {
                echo "Sorgu hatası: " . pg_last_error();
            }

            // Bağlantıyı kapat
            pg_close($conn);
        } else {
            echo "PostgreSQL bağlantı hatası: " . pg_last_error();
        }

            }

    public function zk()
    {

        $this->load->library("zklibrary");
        $zk = new ZKLibrary('10.10.0.202', 80); // Cihazın SDK Portu genellikle 4370'dir.
        if ($zk->connect()) {
            echo "Bağlantı başarılı!";
            $attendance = $zk->getAttendance();
            print_r($attendance);
            $zk->disconnect();
        } else {
            echo "Bağlantı hatası!";
        }

    }
}
