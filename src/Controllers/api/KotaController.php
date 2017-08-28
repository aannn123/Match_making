<?php 

namespace App\Controllers\api;

use App\Models\KotaModel;

class KotaController extends BaseController
{
    public function getAllKota($request, $response)
    {
        $kota = new KotaModel($this->db);
        $get = $kota->getAllKota();
        $countKota = count($get);
        $query = $request->getQueryParams();
        if ($get) {
            $page = !$request->getQueryParam('page') ? 1 : $request->getQueryParam('page');
            $getKota = $kota->getAllKota()->setPaginate($page, 5);

            if ($getKota) {
                $data = $this->responseDetail(200, false,  'Data tersedia', [
                        'data'          =>  $getKota['data'],
                        'pagination'    =>  $getKota['pagination'],
                    ]);
            } else {
                $data = $this->responseDetail(404, true, 'Data tidak ditemukan');
            }
        } else {
            $data = $this->responseDetail(204, false, 'Tidak ada konten');
        }

        return $data;
    }

    public function createKota($request, $response)
    {
        $kota = new KotaModel($this->db);
        $input  = $request->getParsedBody();

        $findKota = $kota->find('nama', $input['nama']);
        $this->validator->rule('required', ['nama', 'id_provinsi']);

        if ($this->validator->validate()) {
            if ($findKota) {
                $data = $this->responseDetail(400, true, 'Nama kota sudah ada', [
                    'data' => $findKota['data']
                ]);
            } else {
                $addKota = $kota->createKota($input);
                $find = $kota->find('id', $addKota);
                $data = $this->responseDetail(200, false, 'Berhasil menambahkan kota', [
                        'data' => $find
                ]);
            }
        } else {
             $data = $this->responseDetail(400, true, $this->validator->errors());
        }
        
         return $data;
    }

    public function updateKota($request, $response, $args)
    {
        $kota = new kotaModel($this->db);
        $input  = $request->getParsedBody();
        $findkota = $kota->find('nama', $input['nama']);
        $find = $kota->find('id', $args['id']);
        $this->validator->rule('required', ['nama', 'id_provinsi']);

        if ($this->validator->validate()) {
            if ($find) {
                $update = $kota->updatekota($input, $args['id']);
                $afterUpdate = $kota->find('id', $args['id']);
                $data = $this->responseDetail(200, false, 'Berhasil update kota', [
                        'data' => $afterUpdate
                ]);
                if ($findkota) {
                   $data = $this->responseDetail(400, true, 'Nama kota sudah ada', [
                        'data' => $findkota['data']
                    ]);
                }
            } else {
               $data = $this->responseDetail(400, true, 'kota tidak ditemukan', [
                    'data' => $findkota['data']
                ]);
            }
        } else {
             $data = $this->responseDetail(400, true, $this->validator->errors());
        }
        
         return $data;     
    }

    public function findKota($request, $response, $args)
    {
        $kota = new KotaModel($this->db);
        $findKota = $kota->find('id', $args['id']);

        if ($findKota) {
            $data = $this->responseDetail(200, false, 'Berhasil menampilkan kota berdasarkan id', [
                'data' => $findKota
            ]);
        } else {
            $data = $this->responseDetail(404, true, 'Kota tidak ditemukan');
        }

        return $data; 
    }

    public function deleteKota($request, $response, $args)
    {
        $kota = new KotaModel($this->db);
        $findKota = $kota->find('id', $args['id']);

        if ($findKota) {
            $delete = $kota->hardDelete($args['id']);
            $data = $this->responseDetail(200, false, 'Kota berhasil dihapus', [
                'data' => $findKota
            ]);
        } else {
            $data = $this->responseDetail(404, true, 'Kota tidak ditemukan');
        }

        return $data;
    }
}