<?php

namespace MagentoModule
{
    class Main
    {

        private $db = null;

        public function __construct()
        {
            $this->db = new \PDO('sqlite:C:\\xampp\\htdocs\\magento-module\\database.db');

            /*
            CRIAR TABELAS
            * /
            $sql = "
            DROP TABLE IF EXISTS movies;";
            $sth = $this->db->prepare($sql);
            $sth->execute();

            $sql = "
            CREATE TABLE movies
            (
                id INTEGER PRIMARY KEY,
                titulo TEXT NOT NULL,
                foto TEXT NOT NULL
            );";
            $sth = $this->db->prepare($sql);
            $sth->execute();

            $sql = "
            DROP TABLE IF EXISTS movies_favs;";
            $sth = $this->db->prepare($sql);
            $sth->execute();
            
            $sql = "
            CREATE TABLE movies_favs
            (
                id INTEGER PRIMARY KEY,
                movie INTEGER NOT NULL,
                usuario INTEGER NOT NULL
            );";
            $sth = $this->db->prepare($sql);
            $sth->execute();
            // */
        }

        protected function Query($sql,$bindValues = array())
        {
            $sth = $this->db->prepare($sql, array(\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY));
            foreach($bindValues as $bind_k=>$bind_v)
                $sth->bindValue($bind_k,$bind_v,\PDO::PARAM_STR);
            $sth->execute();
            return $sth->fetchAll();
        }
        protected function Curl($url, $data = array())
        {
            $settings = array_merge(array(
                'method'=>'GET'
            ),$data);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            return $response;
        }
    }
}

?>