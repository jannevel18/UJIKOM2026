<section class="content-header">
    <div class="container-fluid">
        <div class="card card-dark">
            <div class="card-header">
                <h3 class="card-title">Data Pengembalian Buku</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tablePengembalian" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th style="width:5%">No</th>
                                <th style="width:15%">No Peminjaman</th>
                                <th style="width:20%">Anggota</th>
                                <th style="width:20%">Tanggal</th>
                                <th style="width:15%">Denda</th>
                                <th style="width:10%">Status</th>
                                <th style="width:15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if(isset($resultPeminjaman) && !empty($resultPeminjaman)):
                                $no = 1;
                                foreach($resultPeminjaman as $rs):

                                    $denda_per_hari = 2000;
                                    $tgl_sekarang = date('Y-m-d');
                                    $jatuhTempo = new DateTime($rs->tgl_kembali);
                                    $dikembalikan = new DateTime($tgl_sekarang);
                                    
                                    if ($dikembalikan <= $jatuhTempo) {
                                        $total_denda = 0;
                                        $hari_terlambat = 0;
                                    } else {
                                        $selisih = $jatuhTempo->diff($dikembalikan)->days;
                                        $total_denda = $selisih * $denda_per_hari;
                                        $hari_terlambat = $selisih;
                                    }
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $no++; ?></td>
                                <td>
                                    <strong><?php echo $rs->no_peminjaman; ?></strong>
                                </td>
                                <td>
                                    <?php echo $rs->nis; ?> - <?php echo $rs->nama; ?><br>
                                    <small>Kelas: <?php echo $rs->kelas; ?></small>
                                </td>
                                <td>
                                    Pinjam: <?php echo date('d/m/Y', strtotime($rs->tgl_pinjam)); ?><br>
                                    <small>Kembali: <?php echo date('d/m/Y', strtotime($rs->tgl_kembali)); ?></small>
                                    <?php if($hari_terlambat > 0): ?>
                                        <br><span class="badge badge-danger">Terlambat <?php echo $hari_terlambat; ?> hari</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-right">
                                    <?php if($total_denda > 0): ?>
                                        <span class="text-danger">Rp <?php echo number_format($total_denda, 0, ',', '.'); ?></span>
                                    <?php else: ?>
                                        <span class="text-success">Rp 0</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php 
                                    $status = strtolower(trim($rs->status ?? ''));
                                    $tgl_sekarang = date('Y-m-d');
                                    $tgl_kembali = $rs->tgl_kembali;
                                    if($status == 'dikembalikan'): ?>
                                        <span class="badge bg-success" style="width:100px">Dikembalikan</span>
                                    <?php elseif($status == 'terlambat' || ($status == 'dipinjam' && $tgl_sekarang > $tgl_kembali)): ?>
                                        <span class="badge bg-danger" style="width:100px">Terlambat</span>
                                    <?php elseif($status == 'dipinjam'): ?>
                                        <span class="badge bg-warning" style="width:100px">Dipinjam</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">
                                            <?php echo ucfirst($status ?: 'Unknown'); ?>
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if($status != 'dikembalikan'): ?>
                                        <button class="btn btn-sm btn-success btn-kembalikan" 
                                                data-id="<?php echo $rs->id; ?>"
                                                data-denda="<?php echo $total_denda; ?>">Kembalikan
                                        </button>
                                    <?php else: ?>
                                        <button class="btn btn-sm btn-secondary" disabled style="width:100px">Selesai</button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php 
                                endforeach;
                            else:
                            ?>
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
$(document).ready(function() {
    $('#tablePengembalian').DataTable({
        "pageLength": 10,
        "ordering": false
    });

    $(document).on('click', '.btn-kembalikan', function() {
        const id = $(this).data('id');
        const denda = $(this).data('denda');
        const tgl = '<?php echo date('Y-m-d'); ?>';
        
        if(!confirm('Yakin ingin mengembalikan?')) return;
        
        const $btn = $(this).html('<i class="fa fa-spinner fa-spin"></i>');
        
        $.ajax({
            url: '<?php echo site_url("backend/pengembalian/save"); ?>',
            type: 'POST',
            data: { peminjaman_id: id, tgl_pengembalian: tgl, denda: denda },
            dataType: 'json',
            success: function(res) {
                alert(res.status ? 'Berhasil' : 'Gagal');
                if(res.status) location.reload();
                else $btn.html('<i class="fa fa-undo"></i> Kembalikan');
            }
        });
    });
});
</script>