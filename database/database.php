<?php
class Database
{
      private $host;
      private $db_name;
      private $username;
      private $password;
      public $conn;

      function __construct()
      {
            $this->host       = 'locahlhost';
            $this->username   = 'root';
            $this->password   = '';
            $this->db_name    = 'praktikum_presensi_penggajian';
      }

      public function getConnection()
      {
            $this->conn = null;
            try {
                  $this->conn = new PDO("myqsql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
                  $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

            } catch (PDOException $exception) {
                  echo "Connection error: " . $exception->getMessage();
            }
            return $this->conn;
      }
}
