<?php namespace App\Models;

use CodeIgniter\Model;

class TreatmentModel extends Model{
    protected $table = 'TRATTAMENTO';
    protected $primaryKey = 'ID';
    protected $allowedFields = ['ID', 'Titolo', 'Durata', 'Prezzo', 'Surplus', 'Descrizione', 'Telefono'];

    public function getTreatments() {
        $db = \Config\Database::connect();

        $query = $db->table('TRATTAMENTO');
        $query->select('TRATTAMENTO.*, UTENTE.Username');
        $query->join('UTENTE', 'UTENTE.Telefono = TRATTAMENTO.Telefono');
        $results = $query->get()->getResultArray();
        return $results;
    }

    public function inserisci_trattamento($titolo, $durata, $prezzo, $surplus, $descrizione, $phone) {
        $db = \Config\Database::connect();

        $data = [
            'Titolo' => $titolo,
            'Durata' => $durata,
            'Prezzo' => $prezzo,
            'Surplus' => $surplus,
            'Descrizione' => $descrizione,
            'Teledono' => $phone
        ];

        $query = $db->table('TRATTAMENTO')->insert($data);

        return $query ? true : false;
    }

    public function removeItem($id) {
        $db = \Config\Database::connect();

        $query = $db->table('TRATTAMENTO')->delete(['ID' => $id]);

        return $query ? true : false;
    }
}

?>