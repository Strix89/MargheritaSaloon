<?php namespace App\Models;

use CodeIgniter\Model;
    
class HomeModel extends Model{
        public function getRandomProductImages(){
            $query = $this->db->table("PRODOTTO")
            ->orderBy("RANDOM()")
            ->limit(6)
            ->get();

            $result = array_map(function($item){
                return $item->ID;
            }, $query->getResult());

            return $result;
        }

        public function getRandomComments(){
            $query = $this->db->table("RECENSIONE")
            ->join("UTENTE", 'UTENTE.Telefono = RECENSIONE.Telefono', 'inner')
            ->select('RECENSIONE.Data, UTENTE.Nome, UTENTE.Cognome, RECENSIONE.Testo')
            ->orderBy("RANDOM()")
            ->limit(3)
            ->get();
            return $query->getResult();
        }

        public function getRandomWorks(){
            $query = $this->db->table("LAVORO")
            ->orderBy("RANDOM()")
            ->limit(3)
            ->get();

            $result = array_map(function($item){
                return $item->ID;
            }, $query->getResult());

            return $result;
        }
}

?>