<?php 

namespace App\Models\Users;

use App\Models\BaseModel;

class KeseharianModel extends BaseModel
{
    protected $table = 'keseharian';
    protected $column = ['id', 'user_id', 'pekerjaan', 'merokok', 'status_pekerjaan', 'penghasilan_per_bulan', 'status', 'jumlah_anak', 'status_tinggal', 'memiliki_cicilan', 'bersedia_pindah_tinggal', 'created_at', 'updated_at'];

    public function create(array $data, $id)
    {
        $data = [
            'user_id'                   => $id,
            'pekerjaan'                 => $data['pekerjaan'],
            'merokok'                   => $data['merokok'],
            'status_pekerjaan'          => $data['status_pekerjaan'],
            'penghasilan_per_bulan'     => $data['penghasilan_per_bulan'],
            'status'                    => $data['status'],
            'jumlah_anak'               => $data['jumlah_anak'],
            'status_tinggal'            => $data['status_tinggal'],
            'memiliki_cicilan'          => $data['memiliki_cicilan'],
            'bersedia_pindah_tinggal'   => $data['bersedia_pindah_tinggal']
        ];

        $this->createData($data);
        return $this->db->lastInsertId();
    }

    public function updateKeseharian(array $data, $id)
    {
        $data = [
            'user_id'       =>  $data['user_id'],
            'pekerjaan'     =>  $data['pekerjaan'],
            'status_pekerjaan'  =>  $data['status_pekerjaan'],
            'penghasilan_per_bulan' =>  $data['penghasilan_per_bulan'],
            'status'        =>  $data['status'],
            'jumlah_anak'   =>  $data['jumlah_anak'],
            'merokok'       => $data['merokok'],
            'status_tinggal'    =>  $data['status_tinggal'],
            'memiliki_cicilan'  =>  $data['memiliki_cicilan'],
            'bersedia_pindah_tinggal'   =>  $data['bersedia_pindah_tinggal'],
        ];

        $this->update($data, 'user_id', $data['user_id']);

        return $this->db->lastInsertId();
    }

}
