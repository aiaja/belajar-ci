<?= $this->extend('layout') ?>
<?= $this->section('content') ?>
    <h3>History Pembelian</h3>
    <hr>
    
    <!-- Flash messages -->
    <?php if (session()->getFlashData('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashData('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashData('failed')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashData('failed') ?>
        </div>
    <?php endif; ?>

    <!-- Table with purchase details -->
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">ID Pembelian</th>
                    <th scope="col">Username</th>
                    <th scope="col">Waktu Pembelian</th>
                    <th scope="col">Total Bayar</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">Status</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($transactions)): ?>
                    <?php foreach ($transactions as $index => $transaction): ?>
                        
                        <tr>
                            <th scope="row"><?= $index + 1 ?></th>
                            <td><?= $transaction['id'] ?></td>
                            <td><?= $transaction['username'] ?></td>
                            <td><?= $transaction['created_at'] ?></td>
                            <td><?= number_to_currency($transaction['total_harga'], 'IDR') ?></td>
                            <td><?= $transaction['alamat'] ?></td>
                            <td>
                                <?php if ($transaction['status'] == 1): ?>
                                    <span class="badge bg-success">Sudah Selesai</span>
                                <?php else: ?>
                                    <span class="badge bg-warning">Belum Selesai</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?= base_url('pembelian/update-status/' . $transaction['id']) ?>" class="btn btn-warning">
                                    Ubah Status
                                </a>
                            </td>
                            <td>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#detailModal-<?= $transaction['id'] ?>">
                                Detail
                            </button>
                            </td>
                        </tr>
                                    
                        <!-- Detail Modal Begin -->
                    <div class="modal fade" id="detailModal-<?= $transaction['id'] ?>" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Detail Data</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <?php 
                                    if(!empty($product)){
                                        foreach ($product[$item['id']] as $index2 => $item2) : ?>
                                            <?php
                                            if (session()->get('diskon')) {
                                                $diskon = session()->get('diskon');
                                                $item2['subtotal_harga'] = $item2['harga'] - $diskon['nominal'];
                                            }
                                            ?>
                                            <?php echo $index2 + 1 . ")" ?>
	                                        <?php if ($item2['foto'] != '' and file_exists("img/" . $item2['foto'] . "")) : ?>
	                                            <img src="<?php echo base_url() . "img/" . $item2['foto'] ?>" width="100px">
                                                <?php endif; ?>
                                                <strong><?= $item2['nama'] ?></strong>
                                                <?= number_to_currency($item2['harga'], 'IDR') ?>
                                                <?= number_to_currency($item2['subtotal_harga'], 'IDR') ?>
                                                <br>
	                                        <?= "(" . $item2['jumlah'] . " pcs)" ?><br> 
	                                        <hr>
	                                    <?php 
	                                    endforeach; 
                                    }
                                    ?>
                                    
                                    Ongkir <?= number_to_currency($transaction['ongkir'], 'IDR') ?>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Detail Modal End -->
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
<?= $this->endSection() ?>
