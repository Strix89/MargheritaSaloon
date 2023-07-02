<?php namespace App\Models;

use CodeIgniter\Model;
use \Datetime;

class ReservationModel extends Model{
    public function getReservations($telefono = null, $days = null, $data = null, $mode = false) {
        $builder = $this->db->table('PRENOTAZIONE');
        $builder->select('PRENOTAZIONE.*, UTENTE_C.Username as Cliente_Username, UTENTE_P.Username as Personale_Username, array_agg(public."TRATTAMENTO"."Titolo") as "Titoli", array_agg(public."TRATTAMENTO"."Durata") as "Durate"');
        $builder->join('UTENTE as UTENTE_C', 'PRENOTAZIONE.Telefono_C = UTENTE_C.Telefono', 'left');
        $builder->join('UTENTE as UTENTE_P', 'PRENOTAZIONE.Telefono_P = UTENTE_P.Telefono', 'left');
        $builder->join('PRENOTAZIONE_TRATTAMENTO', 'PRENOTAZIONE.Telefono_C = PRENOTAZIONE_TRATTAMENTO.Telefono_C AND PRENOTAZIONE.Data_P = PRENOTAZIONE_TRATTAMENTO.Data_P AND PRENOTAZIONE.Ora_P = PRENOTAZIONE_TRATTAMENTO.Ora_P', 'left');
        $builder->join('TRATTAMENTO', 'PRENOTAZIONE_TRATTAMENTO.ID_T = TRATTAMENTO.ID', 'left');
    
        if ($telefono !== null && $mode === false) {
            $builder->where('PRENOTAZIONE.Telefono_P', $telefono);
        } else if ($telefono !== null && $mode === true) {
            $builder->where('PRENOTAZIONE.Telefono_C', $telefono);
        }
    
        if ($days !== null) {
            $now = date('Y-m-d');
            $future = date('Y-m-d', strtotime($now . ' + ' . $days . ' days'));
            $builder->where('PRENOTAZIONE.Data_P >=', $now);
            $builder->where('PRENOTAZIONE.Data_P <=', $future);
        }
    
        if ($data !== null) {
            $builder->where('PRENOTAZIONE.Data_P', $data);
        }
    
        $builder->groupBy('PRENOTAZIONE.Telefono_C, PRENOTAZIONE.Data_P, PRENOTAZIONE.Ora_P, UTENTE_C.Username, UTENTE_P.Username');
    
        $query = $builder->get();
    
        return $query->getResultArray();
    }

    public function insertPrenotazione($data){
        $prenotazione_data = array(
            'Telefono_C' => $data['Telefono_C'],
            'Data_P' => $data['Data_P'],
            'Ora_P' => $data['Ora_P'],
            'Telefono_P' => $data['Telefono_P']
        );

        $this->db->table('PRENOTAZIONE')->insert($prenotazione_data);

        foreach ($data['Trattamenti'] as $trattamento) {
            $trattamento_data = array(
                'Telefono_C' => $data['Telefono_C'],
                'Data_P' => $data['Data_P'],
                'Ora_P' => $data['Ora_P'],
                'ID_T' => $trattamento
            );
            $this->db->table('PRENOTAZIONE_TRATTAMENTO')->insert($trattamento_data);
        }
    }

    public function deletePrenotazione($telefono_c, $data_p, $ora_p) {
        $builder = $this->db->table('PRENOTAZIONE');
        $builder->where('Telefono_C', $telefono_c);
        $builder->where('Data_P', $data_p);
        $builder->where('Ora_P', $ora_p);
        $builder->delete();
    
        $builder = $this->db->table('PRENOTAZIONE_TRATTAMENTO');
        $builder->where('Telefono_C', $telefono_c);
        $builder->where('Data_P', $data_p);
        $builder->where('Ora_P', $ora_p);
        $builder->delete();
    }

    public function getResWithoutRev($telefono, $data_p, $ora_p) {
        $builder = $this->db->table('PRENOTAZIONE');
        $builder->select('PRENOTAZIONE.Telefono_C, PRENOTAZIONE.Data_P, PRENOTAZIONE.Ora_P');
        $builder->join('RECENSIONE', 'PRENOTAZIONE.Telefono_C = RECENSIONE.Telefono AND PRENOTAZIONE.Data_P = RECENSIONE.Data_P AND PRENOTAZIONE.Ora_P = RECENSIONE.Ora_P', 'left');
        $builder->where('RECENSIONE.Telefono', null); // prenotazione non associata ad una recensione
        $builder->where('PRENOTAZIONE.Telefono_C', $telefono);
        $builder->where('PRENOTAZIONE.Data_P <', $data_p);
        $builder->orWhere('PRENOTAZIONE.Data_P', $data_p)->where('PRENOTAZIONE.Ora_P <', $ora_p);
        $builder->groupBy('PRENOTAZIONE.Telefono_C, PRENOTAZIONE.Data_P, PRENOTAZIONE.Ora_P');
        $query = $builder->get();
        return $query->getResultArray();
    }
}

?>