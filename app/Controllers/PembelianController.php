<?php

namespace App\Controllers;

use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;

class PembelianController extends BaseController
{
    protected $transaction;
    protected $transactionDetail;

    public function __construct()
    {
        helper('number'); // Load the number helper to use `number_to_currency`
        $this->transaction = new TransactionModel();
        $this->transactionDetail = new TransactionDetailModel(); // Initialize TransactionDetailModel
    }

    // Admin access only
    public function index()
    {
        // Check if the user is an admin
        if (session()->get('role') !== 'admin') {
            return redirect()->to(base_url('/'));
        }

        // Fetch all transactions
        $transactions = $this->transaction->findAll();

        // Get related products for each transaction
        foreach ($transactions as &$transaction) {
            // Fetch the related products using the transaction_id
            $transaction['products'] = $this->transactionDetail
                ->where('transaction_id', $transaction['id'])
                ->findAll();
        }

        // Pass transactions and their related products to the view
        return view('v_pembelian', ['transactions' => $transactions]);
    }

    // Update the status of a purchase
    public function updateStatus($id)
    {
        // Check if the user is an admin
        if (session()->get('role') !== 'admin') {
            return redirect()->to(base_url('/'));
        }

        // Fetch the transaction by ID
        $transaction = $this->transaction->find($id);

        if ($transaction) {
            // Toggle the status (0 = Belum Selesai, 1 = Sudah Selesai)
            $newStatus = ($transaction['status'] == 0) ? 1 : 0;

            // Update the status in the database
            $this->transaction->update($id, [
                'status' => $newStatus
            ]);

            // Flash message for success
            session()->setFlashdata('success', 'Status pembelian berhasil diubah!');
        } else {
            session()->setFlashdata('failed', 'Pembelian tidak ditemukan!');
        }

        return redirect()->to(base_url('pembelian'));
    }
}
