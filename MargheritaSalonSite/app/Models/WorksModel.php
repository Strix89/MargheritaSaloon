<?php namespace App\Models;

use CodeIgniter\Model;
    
class WorksModel extends Model{
    protected $table = "LAVORO";
    protected $primaryKey = "ID";
    protected $allowedFields = ["ID", "Titolo", "Data", "Descrizione", "Telefono"];

    public function getWorks() {
        $db = \Config\Database::connect();
        $query = $db->query('SELECT p."ID", p."Titolo", p."Descrizione", p."Data", ARRAY_AGG(i."Nome") as "NomiImmagini", u."Username" FROM public."LAVORO" p LEFT JOIN public."UTENTE" u ON p."Telefono" = u."Telefono" LEFT JOIN public."IMMAGINE_L" i ON p."ID" = i."ID_L" GROUP BY p."ID", p."Titolo", p."Descrizione", p."Data", u."Username"');
        
        $result = $query->getResultArray();
        return $result;
    }

    public function addWork($titolo, $data, $descrizione, $phone, $num) {
        $db = \Config\Database::connect();

        $map_name = ["1", "2", "3"];
        $data = [
            'Titolo' => $titolo,
            'Data' => $data,
            'Descrizione' => $descrizione,
            'Telefono' => $phone
        ];

        $query = $db->table('LAVORO')->insert($data);
        if($query == false){
            return false;
        }
        $id_work = $db->insertID();
        for($i = 0; $i < $num; $i++){
            $dataImages = [
                "ID_L" => $id_work,
                "Nome" => $map_name[$i]
            ];
            $query = $db->table('IMMAGINE_L')->insert($dataImages);
        }

        return $query ? true : false;
    }

    public function getLastID(){
        $db = \Config\Database::connect();

        $query = $db->table('LAVORO');
        $query->select('ID');
        $query->orderBy('ID', 'DESC');
        $query->limit(1);
        $results = $query->get()->getResultArray();
        return $results[0]['ID'];
    }

    public function rmWork($id){
        $db = \Config\Database::connect();

        $query = $db->table('LAVORO');
        $query->where('ID', $id);
        $query->delete();
        return $query ? true : false;
    }

    public function getImagesByWorkId($id){
        $db = \Config\Database::connect();

        $query = $db->table('IMMAGINE_L');
        $query->select('Nome');
        $query->where('ID_L', $id);
        $results = $query->get()->getResultArray();
        return $results;
    }
}

?>