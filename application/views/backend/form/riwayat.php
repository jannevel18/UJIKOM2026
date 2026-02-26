<section class="content-header">
    <div class="container-fluid">
        <div class="card card-dark">
            <div class="card-header">
                <h3 class="card-title">Riwayat Peminjaman Buku</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tableRiwayat" class="table table-bordered table-striped" style="width:100%">
                        <thead class="bg-light">
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
                                        <br><span class="badge bg-danger">Terlambat <?php echo $hari_terlambat; ?> hari</span>
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
                                    
                                    if($status == 'dikembalikan'): ?>
                                        <span class="badge bg-success" style="width:100px">Dikembalikan</span>
                                    <?php elseif($status == 'terlambat' || ($status == 'dipinjam' && $tgl_sekarang > $rs->tgl_kembali)): ?>
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
                                   <button class="btn btn-sm btn-info" onclick="lihatBuku('<?php echo $rs->id; ?>')">Lihat Buku</button>
                                </td>
                            </tr>
                            <?php 
                                endforeach;
                            else:
                            ?>
                            <tr>
                                <td colspan="7" class="text-center text-danger">
                                    Tidak ada data riwayat
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<div id="modalCustomBuku" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 999999;">
    <div style="position: relative; width: 90%; max-width: 900px; margin: 50px auto;">
        <div style="background: white; border-radius: 5px; box-shadow: 0 5px 20px rgba(0,0,0,0.3);">
            <div style="background: #17a2b8; padding: 15px 20px; border-radius: 5px 5px 0 0; display: flex; justify-content: space-between; align-items: center;">
                <h4 style="margin: 0; color: white; font-size: 18px;">
                    <i class="fa fa-book"></i> Detail Buku yang Dipinjam
                </h4>
                <button onclick="tutupModalBuku()" style="background: none; border: none; color: white; font-size: 24px; cursor: pointer;">&times;</button>
            </div>
            <div style="padding: 20px;">
                <div style="overflow-x: auto;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead style="background: #f8f9fa;">
                            <tr>
                                <th style="padding: 10px; border: 1px solid #dee2e6; text-align: center; width: 5%;">No</th>
                                <th style="padding: 10px; border: 1px solid #dee2e6; text-align: left;">Detail Buku</th>
                                <th style="padding: 10px; border: 1px solid #dee2e6; text-align: center; width: 10%;">Qty</th>
                            </tr>
                        </thead>
                        <tbody id="listBukuCustom">
                            <tr>
                                <td colspan="3" style="padding: 20px; text-align: center;">
                                    <i class="fa fa-spinner fa-spin"></i> Loading...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div style="padding: 15px 20px; border-top: 1px solid #dee2e6; text-align: right;">
                <button onclick="tutupModalBuku()" style="background: #6c757d; color: white; border: none; padding: 8px 20px; border-radius: 3px; cursor: pointer;">
                    <i class="fa fa-times"></i> Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function bukaModalBuku() {
    document.getElementById('modalCustomBuku').style.display = 'block';
    document.body.style.overflow = 'auto';
}

function tutupModalBuku() {
    document.getElementById('modalCustomBuku').style.display = 'none';
}

function lihatBuku(id) {
    document.getElementById('listBukuCustom').innerHTML = '<tr><td colspan="3" style="padding: 20px; text-align: center;"><i class="fa fa-spinner fa-spin"></i> Loading...</td></tr>';
    bukaModalBuku();
    $.ajax({
        url: '<?php echo site_url("backend/riwayat/viewBuku/"); ?>' + id,
        type: 'GET',
        success: function(data) {
            document.getElementById('listBukuCustom').innerHTML = data;
        },
        error: function() {
            document.getElementById('listBukuCustom').innerHTML = '<tr><td colspan="3" style="padding: 20px; text-align: center; color: red;">Gagal load data</td></tr>';
        }
    });
}
</script>

<script>
$(document).ready(function() {
    $('#tableRiwayat').DataTable({
        "pageLength": 10,
        "ordering": false,
        "responsive": true,
        "language": {
            "search": "Cari:",
            "lengthMenu": "Tampilkan _MENU_ data",
            "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
            "paginate": {
                "first": "Pertama",
                "last": "Terakhir",
                "next": "Selanjutnya",
                "previous": "Sebelumnya"
            }
        }
    });
});
</script>