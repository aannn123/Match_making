<?php 

namespace App\Controllers\Api;

use App\Models\NegaraModel;

class NegaraController extends BaseController
{
    public function getAllNegara($request, $response)
    {
        $negara = new NegaraModel($this->db);
        $get = $negara->getAllNegara();
        $countNegara = count($get);
        $query = $request->getQueryParams();
        if ($get) {
            $page = !$request->getQueryParam('page') ? 1 : $request->getQueryParam('page');
            $perPage = $request->getQueryParam('perpage');
            $getNegara = $negara->getAllNegara()->setPaginate($page, $perPage);

            if ($getNegara) {
                $data = $this->responseDetail(200, false,  'Data tersedia', [
                        'data'          =>  $getNegara['data'],
                        'pagination'    =>  $getNegara['pagination'],
                    ]);
            } else {
                $data = $this->responseDetail(404, true, 'Data tidak ditemukan');
            }
        } else {
            $data = $this->responseDetail(204, false, 'Tidak ada konten');
        }

        return $data;
    }

    public function createNegara($request, $response)
    {
        $negara = new NegaraModel($this->db);
        $input  = $request->getParsedBody();
        $findNegara = $negara->find('nama', $input['nama']);

        $this->validator->rule('required', 'nama');

        if ($this->validator->validate()) {
            if ($findNegara) {
                $data = $this->responseDetail(400, true, 'Nama negara sudah ada', [
                    'data' => $findNegara['data']
                ]);
            } else {
                $addNegara = $negara->createNegara($input);
                $find = $negara->find('id', $addNegara);
                $data = $this->responseDetail(200, false, 'Berhasil menambahkan negara', [
                        'data' => $find
                ]);
            }
        } else {
             $data = $this->responseDetail(400, true, $this->validator->errors());
        }
        
         return $data;
    }

    public function updateNegara($request, $response, $args)
    {
        $negara = new NegaraModel($this->db);
        $input  = $request->getParsedBody();
        $findNegara = $negara->find('nama', $input['nama']);
        $find = $negara->find('id', $args['id']);

        $this->validator->rule('required', 'nama');

        if ($this->validator->validate()) {
            if ($find) {
                $updateNegara = $negara->updateNegara($input, $args['id']);
                $find = $negara->find('id', $updateNegara);
                $data = $this->responseDetail(200, false, 'Berhasil update negara', [
                        'data' => $find
                ]);
                if ($findNegara) {
                   $data = $this->responseDetail(400, true, 'Nama Negara sudah ada', [
                        'data' => $findNegara['data']
                    ]);
                }
            } else {
               $data = $this->responseDetail(400, true, 'Negara tidak ditemukan', [
                    'data' => $findNegara['data']
                ]);
            }
        } else {
             $data = $this->responseDetail(400, true, $this->validator->errors());
        }
        
         return $data;
    }
    public function delete($request, $response, $args)
    {
        $negara = new NegaraModel($this->db);
        $findNegara = $negara->find('id', $args['id']);

        if ($findNegara) {
            $delete = $negara->hardDelete($args['id']);
            $data = $this->responseDetail(200, false, 'Negara berhasil dihapus', [
                'data' => $findNegara
            ]);
        } else {
            $data = $this->responseDetail(404, true, 'Negara tidak ditemukan');
        }

        return $data;
    }

    public function findNegara($request, $response, $args)
    {
        $negara = new NegaraModel($this->db);
        $findNegara = $negara->find('id', $args['id']);

        if ($findNegara) {
            $data = $this->responseDetail(200, false, 'Berhasil menampilkan negara', [
                'data' => $findNegara
            ]);
        } else {
            $data = $this->responseDetail(404, true, 'Negara tidak ditemukan');
        }

        return $data;
    }
}