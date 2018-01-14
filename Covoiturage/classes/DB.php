<?php

class DB
{
    // configuration pour connecter l'herbergeur
    private $hostname = 'localhost',
            $username = 'root',
            $password = '',
            $database = 'covoiturage_v2';

    // variable connect
    public $cn = NULL;

    // connecter fonction
    public function connect() {
        $this->cn = mysqli_connect( $this->hostname, $this->username, $this->password, $this->database);
    }

    // deconnecter fonction
    public function close() {
        if ($this->cn)
            mysqli_close($this->cn);
    }

    public function query($sql = NULL) {
        if ($this->cn)
            mysqli_query($this->cn, $sql);
    }

    public function num_rows($sql = NULL) {
        if ($this->cn) {
            $query = mysqli_query($this->cn, $sql);
            $rows = mysqli_num_rows($query);
            return $rows;
        }
    }

    //  chercher les données
    public function fetch_assoc($sql = NULL, $type) {
        if ($this->cn) {
            $query = mysqli_query($this->cn, $sql);
            // retourner une liste de record
            if ($type == 0) {
                $data = array();
                while ($row = mysqli_fetch_assoc($query)) {
                    $data[] = $row;
                }
                return $data;
            }
            // retourner 1 record ou premier record d'une liste
            else if ($type == 1) {
                $data_row = mysqli_fetch_assoc($query);
                return $data_row;
            }
        }
    }

    public function insert_id() {
        if ($this->cn)
            return mysqli_insert_id($this->cn);
    }

    // fonction charset pour base de donnée
    public function set_char($uni)
    {
        if ($this->cn)
        {
            mysqli_set_charset($this->cn, $uni);
        }
    }
}