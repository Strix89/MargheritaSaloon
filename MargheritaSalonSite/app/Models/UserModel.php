<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model{
    protected $table = 'UTENTE';
    protected $primaryKey = 'Telefono';

    protected $useAutoIncrement = false;

    protected $returnType = 'array';

    protected $allowedFields = ['Telefono', 'Nome', 'Cognome', 'PSW', 'Email', 'Username', 'Tipologia', 'Logged', 'Token'];

    public function getAllLogged(){
        return $this->where("Logged", true)->countAllResults();
    }

    public function setLogged($phone){
        $this->where("Telefono", $phone)->set(["Logged" => true])->update();
    }

    public function setLogout($phone){
        $this->where("Telefono", $phone)->set(["Logged" => false])->update();
    }

    public function getFreePersonale($data, $ora){
        $query = 'SELECT public."UTENTE"."Username", public."UTENTE"."Telefono"
                    FROM public."UTENTE" 
                    WHERE public."UTENTE"."Tipologia" = TRUE AND public."UTENTE"."Telefono" 
                    NOT IN (SELECT public."PRENOTAZIONE"."Telefono_P" 
                    FROM public."PRENOTAZIONE" WHERE public."PRENOTAZIONE"."Data_P" = ? AND public."PRENOTAZIONE"."Ora_P" = ?)';
        $results = $this->db->query($query, [$data, $ora])->getResultArray();
        return $results;
    }

    public function getFreePersonalePren($data, $ora){
        $query = 'SELECT "UT"."Username", "UT"."Telefono", "PN"."Data_P", "PN"."Ora_P", SUM("T"."Durata") AS "DurataTotale"
                    FROM public."UTENTE" "UT"
                    JOIN public."PRENOTAZIONE" "PN" ON "UT"."Telefono" = "PN"."Telefono_P" AND "PN"."Data_P" = ? 
                    AND "PN"."Ora_P" = ?
                    JOIN public."PRENOTAZIONE_TRATTAMENTO" "PT" ON "PN"."Telefono_C" = "PT"."Telefono_C"
                     AND "PN"."Data_P" = "PT"."Data_P" AND "PN"."Ora_P" = "PT"."Ora_P"
                    JOIN public."TRATTAMENTO" "T" ON "PT"."ID_T" = "T"."ID"
                    WHERE "UT"."Tipologia" = TRUE
                    GROUP BY "UT"."Username", "UT"."Telefono", "PN"."Data_P", "PN"."Ora_P"
                    ORDER BY "UT"."Nome"';
        $results = $this->db->query($query, [$data, $ora])->getResultArray();
        return $results;
    }

    public function getNomeCognomeByTelefono($telefono) {
        $query = $this->select('Nome, Cognome')->where('Telefono', $telefono)->get();
        $result = $query->getRowArray();
        return $result ? array('Nome' => $result['Nome'], 'Cognome' => $result['Cognome']) : null;
    }

    public function getEmailByTelefono($telefono) {
        $query = $this->select('Email')->where('Telefono', $telefono)->get();
        $result = $query->getRow();
        return $result ? $result->Email : null;
    }
}

?>