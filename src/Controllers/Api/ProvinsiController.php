<?php 

namespace App\Controllers\Api;

use App\Models\ProvinsiModel;
use App\Models\NegaraModel;

class ProvinsiController extends BaseController
{
    public function getAllProvinsi($request, $response)
    {
        $provinsi = new ProvinsiModel($this->db);
        $get = $provinsi->joinProvinsi();
        $countProvinsi = count($get);
        $query = $request->getQueryParams();
        if ($get) {
            $page = !$request->getQueryParam('page') ? 1 : $request->getQueryParam('page');
            $getProvinsi = $provinsi->joinProvinsi()->setPaginate($page, 5);

            if ($getProvinsi) {
                $data = $this->responseDetail(200, false,  'Data tersedia', [
                        'data'          =>  $getProvinsi['data'],
                        'pagination'    =>  $getProvinsi['pagination'],
                    ]);
            } else {
                $data = $this->responseDetail(404, true, 'Data tidak ditemukan');
            }
        } else {
            $data = $this->responseDetail(204, false, 'Tidak ada konten');
        }

        return $data;
    }

    public function createProvinsi($request, $response, $args)
    {
        $provinsi = new ProvinsiModel($this->db);
        $negara = new NegaraModel($this->db);
        $input  = $request->getParsedBody();

        $findProvinsi = $provinsi->find('nama', $input['nama']);
        $this->validator->rule('required', ['nama', 'id_negara']);

        if ($this->validator->validate()) {
            if ($findProvinsi) {
                $data = $this->responseDetail(400, true, 'Nama provinsi sudah ada', [
                    'data' => $findProvinsi['data']
                ]);
            } else {
                $addProvinsi = $provinsi->createProvinsi($input);
                $find = $provinsi->find('id', $addProvinsi);
                $data = $this->responseDetail(200, false, 'Berhasil menambahkan provinsi', [
                        'data' => $find
                ]);
            }
        } else {
             $data = $this->responseDetail(400, true, $this->validator->errors());
        }
        
         return $data;
    }

    public function updateProvinsi($request, $response, $args)
    {
        $provinsi = new ProvinsiModel($this->db);
        $input  = $request->getParsedBody();
        $findProvinsi = $provinsi->find('nama', $input['nama']);
        $find = $provinsi->find('id', $args['id']);
        $this->validator->rule('required', ['nama', 'id_negara']);

        if ($this->validator->validate()) {
            if ($find) {
                $update = $provinsi->updateProvinsi($input, $args['id']);
                $afterUpdate = $provinsi->find('id', $args['id']);
                $data = $this->responseDetail(200, false, 'Berhasil update provinsi', [
                        'data' => $afterUpdate
                ]);
                if ($findProvinsi) {
                   $data = $this->responseDetail(400, true, 'Nama provinsi sudah ada', [
                        'data' => $findProvinsi['data']
                    ]);
                }
            } else {
               $data = $this->responseDetail(400, true, 'Provinsi tidak ditemukan', [
                    'data' => $findProvinsi['data']
                ]);
            }
        } else {
             $data = $this->responseDetail(400, true, $this->validator->errors());
        }
        
         return $data; 
    }

    public function findProvinsi($request, $response, $args)
    {
        $provinsi = new ProvinsiModel($this->db);
        $findProvinsi = $provinsi->find('id', $args['id']);

        if ($findProvinsi) {
            $data = $this->responseDetail(200, false, 'Berhasil menampilkan provinsi berdasarkan id', [
                'data' => $findProvinsi
            ]);
        } else {
            $data = $this->responseDetail(404, true, 'Provinsi tidak ditemukan');
        }

        return $data;        
    }

    public function deleteProvinsi($request, $response, $args)
    {
        $provinsi = new ProvinsiModel($this->db);
        $findProvinsi = $provinsi->find('id', $args['id']);

        if ($findProvinsi) {
            $delete = $provinsi->hardDelete($args['id']);
            $data = $this->responseDetail(200, false, 'Provinsi berhasil dihapus', [
                'data' => $findProvinsi
            ]);
        } else {
            $data = $this->responseDetail(404, true, 'Provinsi tidak ditemukan');
        }

        return $data;
    }
}
