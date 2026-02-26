<section class="content-header">
    <div class="container-fluid">
        <?php 
        $role = isset($role) ? $role : $this->session->userdata('level');
        $cardColor = ($role == 'admin') ? 'card-primary' : 'card-success';
        $title = ($role == 'admin') ? 'Data Buku Perpustakaan' : 'Katalog Buku Perpustakaan';
        ?>
        <div class="card <?php echo $cardColor; ?>">
            <div class="card-header">
                <h3 class="card-title">
                   <?php echo $title; ?>
                </h3>
            </div>
            <div class="card-body">
                
                <?php if($role == 'admin'): ?>
                <div class="row">
                    <div class="col-lg-4">
                        <form id="form-buku">
                            <input type="hidden" id="id_buku" name="id_buku">

                            <div class="mb-3">
                                <small class="text-muted">Kode Buku</small>
                                <input type="text" class="form-control" id="kode_buku_display" value="Loading..." readonly disabled>
                            </div>
                            
                            <div class="mb-3">
                                <small class="text-muted">Judul buku</small>
                                <input type="text" class="form-control" id="judul" name="judul" placeholder="Judul Buku" required>
                            </div>
                            
                            <div class="mb-3">
                                <small class="text-muted">Nama Pengarang</small>
                                <input type="text" class="form-control" id="pengarang" name="pengarang" placeholder="Nama Pengarang">
                            </div>
                            
                            <div class="mb-3">
                                <small class="text-muted">Nama Penerbit</small>
                                <input type="text" class="form-control" id="penerbit" name="penerbit" placeholder="Nama Penerbit">
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <small class="text-muted">Terbitan Tahun</small>
                                        <input type="number" class="form-control" id="tahun" name="tahun" placeholder="Tahun">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <small class="text-muted">Stok Buku yang Tersedia</small>
                                        <input type="number" class="form-control" id="stok" name="stok" placeholder="Stok" min="0" required>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <br>
                        <div class="form-group d-flex justify-content-end">
                            <button class="btn btn-sm btn-dark" id="btn-simpan"> Simpan Data </button>
                            <button class="btn btn-sm btn-warning" id="btn-update" style="display:none; margin-right: 3px;">Update</button>
                            <button class="btn btn-sm btn-success" id="btn-refresh" style="display:none;">Batal</button>    
                        </div>
                    </div>
                    
                    <div class="col-lg-8">
                <?php else: ?>
                    <div class="row">
                        <div class="col-12">
                <?php endif; ?>
                        <div class="table-responsive">
                            <table id="DataTables" class="table table-bordered table-striped" style="width:100%">
                                <thead class="bg-light">
                                    <tr>
                                        <th style="width:5%">No</th>
                                        <th style="width:10%">Kode</th>
                                        <th style="width:20%">Judul</th>
                                        <th style="width:15%">Pengarang</th>
                                        <th style="width:15%">Penerbit</th>
                                        <th style="width:8%">Tahun</th>
                                        <th style="width:8%">Stok</th>
                                        <?php if($role == 'admin'): ?>
                                        <th style="width:15%">Aksi</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if(isset($result) && !empty($result)):
                                        $no = 1;
                                        foreach($result as $rs):
                                    ?>
                                    <tr>
                                        <td class="text-center"><?php echo $no++; ?></td>
                                        <td><?php echo $rs->kode_buku; ?></td>
                                        <td><strong><?php echo $rs->judul; ?></strong></td>
                                        <td><?php echo $rs->pengarang; ?></td>
                                        <td><?php echo $rs->penerbit; ?></td>
                                        <td class="text-center"><?php echo $rs->tahun; ?></td>
                                        <td class="text-center">
                                            <?php if($rs->stok > 0): ?>
                                                <span class="badge bg-success"><?php echo $rs->stok; ?></span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Habis</span>
                                            <?php endif; ?>
                                        </td>
                                        <?php if($role == 'admin'): ?>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-dark" onclick="edit(<?php echo $rs->id; ?>)">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger" onclick="hapus(<?php echo $rs->id; ?>)">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                        <?php endif; ?>
                                    </tr>
                                    <?php 
                                        endforeach;
                                    else:
                                    ?>
                                    <tr>
                                        <td colspan="<?php echo ($role == 'admin') ? '8' : '7'; ?>" class="text-center">
                                            Tidak ada data buku
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <?php if($role == 'siswa'): ?>
                <div class="mt-4 p-3 bg-light rounded">
                    <h5><i class="fa fa-info-circle text-success"></i> Informasi Peminjaman:</h5>
                    <ul class="mb-0">
                        <li>Buku dengan stok <span class="badge bg-success">hijau</span> tersedia.</li>
                        <li>Buku dengan stok <span class="badge bg-danger">merah</span> habis.</li>
                        <li>Denda keterlambatan Rp 2.000/hari.</li>
                    </ul>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
$(document).ready(function() {
    $('#DataTables').DataTable({
        "paging": true,
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

    $.ajax({
        url: "<?php echo site_url('backend/buku/get_next_kode'); ?>",
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('#kode_buku_display').val(data.kode);
        },
        error: function() {
            $('#kode_buku_display').val('BK-000001');
        }
    });

    <?php if($role == 'admin'): ?>
    
    $("#btn-simpan").click(function() {
        var data = {
            'judul': $('#judul').val(),
            'pengarang': $('#pengarang').val(),
            'penerbit': $('#penerbit').val(),
            'tahun': $('#tahun').val(),
            'stok': $('#stok').val()
        };

        if(data.judul == '' || data.stok == '') {
            alert('Judul dan stok buku wajib diisi!');
            return;
        }

        $.ajax({
            type: "POST",
            url: "<?php echo site_url('backend/buku/save'); ?>",
            data: data,
            dataType: "JSON",
            success: function(res) {
                alert(res.message);
                if(res.status) location.reload();
            }
        });
    });

    $("#btn-update").click(function() {
        var data = {
            'id_buku': $('#id_buku').val(),
            'judul': $('#judul').val(),
            'pengarang': $('#pengarang').val(),
            'penerbit': $('#penerbit').val(),
            'tahun': $('#tahun').val(),
            'stok': $('#stok').val()
        };

        $.ajax({
            type: "POST",
            url: "<?php echo site_url('backend/buku/update'); ?>",
            data: data,
            dataType: "JSON",
            success: function(res) {
                alert(res.message);
                if(res.status) location.reload();
            }
        });
    });

    $("#btn-refresh").click(function() {
        $("#form-buku")[0].reset();
        $("#id_buku").val('');
        $("#btn-simpan").show();
        $("#btn-update").hide();
        $("#btn-refresh").hide();
        
        $.ajax({
            url: "<?php echo site_url('backend/buku/get_next_kode'); ?>",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $('#kode_buku_display').val(data.kode);
            }
        });
    });

    <?php endif; ?>
});

<?php if($role == 'admin'): ?>

function edit(id) {
    $.ajax({
        type: "POST",
        url: "<?php echo site_url('backend/buku/edit'); ?>",
        data: { id: id },
        dataType: "JSON",
        success: function(data) {
            $("#btn-simpan").hide();
            $("#btn-update").show();
            $("#btn-refresh").show();

            $("#id_buku").val(data.id);
            $("#kode_buku_display").val(data.kode_buku); 
            $("#judul").val(data.judul);
            $("#pengarang").val(data.pengarang);
            $("#penerbit").val(data.penerbit);
            $("#tahun").val(data.tahun);
            $("#stok").val(data.stok);
        }
    });
}

function hapus(id) {
    if(confirm('Yakin ingin menghapus buku ini?')) {
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('backend/buku/delete'); ?>",
            data: { id: id },
            dataType: "JSON",
            success: function(res) {
                alert(res.message);
                if(res.status) location.reload();
            }
        });
    }
}
<?php endif; ?>
</script>