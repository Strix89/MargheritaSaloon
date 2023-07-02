<?php namespace App\Models;

use CodeIgniter\Model;
    
class ProductModel extends Model{
    protected $table = "Prodotti";
    protected $primaryKey = "ID";
    protected $allowedFields = ["ID", "Nome", "Prezzo", "Descrizione", "Telefono"];

    public function getProducts() {
        $db = \Config\Database::connect();
        $query = $db->query('SELECT p."ID", p."Nome", p."Descrizione", p."Prezzo", ARRAY_AGG(i."Nome") as "NomiImmagini" 
                                FROM public."PRODOTTO" p 
                                LEFT JOIN public."IMMAGINE_P" i ON p."ID" = i."ID_P" 
                                GROUP BY p."ID", p."Nome", p."Descrizione", p."Prezzo"');
        
        $result = $query->getResultArray();
        return $result;
    }

    public function addProdotto($nome, $prezzo, $descrizione, $phone, $num) {
        $db = \Config\Database::connect();

        $map_name = ["front", "back", "side"];
        $data = [
            'Nome' => $nome,
            'Prezzo' => $prezzo,
            'Descrizione' => $descrizione,
            'Telefono' => $phone
        ];

        $query = $db->table('PRODOTTO')->insert($data);
        if($query == false){
            return false;
        }
        $id_prodotto = $db->insertID();
        for($i = 0; $i < $num; $i++){
            $dataImages = [
                "ID_P" => $id_prodotto,
                "Nome" => $map_name[$i]
            ];
            $query = $db->table('IMMAGINE_P')->insert($dataImages);
        }

        return $query ? true : false;
    }

    public function getLastID(){
        $db = \Config\Database::connect();

        $query = $db->table('PRODOTTO');
        $query->select('ID');
        $query->orderBy('ID', 'DESC');
        $query->limit(1);
        $results = $query->get()->getResultArray();
        return $results[0]['ID'];
    }

    public function rmProduct($id){
        $db = \Config\Database::connect();

        $query = $db->table('PRODOTTO');
        $query->where('ID', $id);
        $query->delete();
        return $query ? true : false;
    }

    public function getImagesByProductId($id){
        $db = \Config\Database::connect();

        $query = $db->table('IMMAGINE_P');
        $query->select('Nome');
        $query->where('ID_P', $id);
        $results = $query->get()->getResultArray();
        return $results;
    }
}

?>