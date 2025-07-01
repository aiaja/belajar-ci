<?php

namespace App\Controllers;

use App\Models\DiskonModel;

class DiskonController extends BaseController
{
    protected $diskon;

    function __construct()
    {
        $this->diskon = new DiskonModel();
    }

    public function index()
    {
        $diskon = $this->diskon->findAll();
        $data['diskon'] = $diskon;

        return view('v_diskon', $data);
    }

    public function create()
    {
        $dataForm = [
            'tanggal' => $this->request->getPost('tanggal'),
            'nominal' => $this->request->getPost('nominal'),
        ];

        $this->diskon->insert($dataForm);

        return redirect('diskon')->with('success', 'Data Berhasil Ditambah');
    }

    public function edit($id)
    {
        $dataDiskon = $this->diskon->find($id);

        $dataForm = [
            'tanggal' => $this->request->getPost('tanggal'),
            'nominal' => $this->request->getPost('nominal'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->diskon->update($id, $dataForm);

        return redirect('diskon')->with('success', 'Data Berhasil Diubah');
    }

    public function delete($id)
    {
        $dataDiskon = $this->diskon->find($id);

        $this->diskon->delete($id);

        return redirect('diskon')->with('success', 'Data Berhasil Dihapus');
    }
}
