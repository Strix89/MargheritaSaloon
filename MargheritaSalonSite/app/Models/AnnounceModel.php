<?php namespace App\Models;

use CodeIgniter\Model;

class AnnounceModel extends Model{
    public function insert_annuncio($data, $ora, $telefono, $testo) {
        $db = \Config\Database::connect();
        $builder = $db->table('ANNUNCIO');
    
        $dataArray = [
            'Data' => date('Y-m-d'),
            'Ora' => $ora,
            'Telefono' => $telefono,
            'Testo' => $testo
        ];
    
        $insertResult = $builder->insert($dataArray);
    
        return $insertResult;
    }
}

?>