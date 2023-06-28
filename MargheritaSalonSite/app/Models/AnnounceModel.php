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

public function get_Annunci($days){
        $db = \Config\Database::connect();
        $builder = $db->table('ANNUNCIO');
        $builder->select('ANNUNCIO.*, UTENTE.Username');
        $builder->join('UTENTE', 'UTENTE.Telefono = ANNUNCIO.Telefono');
        $builder->where('Data >=', date('Y-m-d', strtotime("-$days days")));
        $builder->where('UTENTE.Telefono IS NOT NULL');
        $builder->orderBy('Data', 'DESC');
        $builder->orderBy('Ora', 'DESC');
        $query = $builder->get();
        return $query->getResultArray();
    }
}

?>