<section class="content-header">
    <div class="container-fluid">
        <div class="card card-dark">
            <div class="card-header">
                <h3 class="card-title">Data Anggota Perpustakaan</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-4">
                        <form id="form-anggota">

                            <div class="mb-2"> 
                                <small class="text-muted">Nomor Induk Siswa</small>
                                <input type="text" class="form-control" id="nis" name="nis" placeholder="Nis" required>                             
                                <input type="hidden" id="id_anggota id_users" name="id_anggota id_users">    
                                <input type="hidden" id="user_id" name="user_id">
                            </div>

                            <div class="mb-2">
                                <small class="text-muted">Nama Siswa</small>
                                <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" required>
                            </div>
                            <div class="mb-2">
                                <small class="text-muted">Kelas</small>
                                <select class="form-control text-muted" onchange="this.classList.remove('text-muted')" id="kelas" name="kelas" placeholder="Kelas" required>
                                    <option value="" disabled selected>Pilih Kelas</option>
                                    <option value="X">X</option>
                                    <option value="XI">XI</option>
                                    <option value="XII">XII</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <small class="text-muted">Alamat Rumah</small>
                                <textarea class="form-control form-control-sm" id="alamat" name="alamat" placeholder="Alamat" required></textarea>
                            </div>
                            <hr>
                            <div class="mb-2">
                                <small class="text-muted">Username untuk akun</small>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                            </div>
                            <div class="mb-2">
                                <small class="text-muted">Password</small>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" autocomplete="new-password" required>
                                </div>
                        </form>
                        <div class="form-group d-flex justify-content-end">
                            <button class="btn btn-sm btn-dark" id="btn-simpan"> Simpan Data </button>
                            <button type="button" class="btn btn-sm btn-dark" id="btn-update" style="display:none; margin-right: 3px;">Update Data</button>
                            <button type="button" class="btn btn-sm btn-success" id="btn-refresh" style="display:none;">Batal</button>
                        </div>
                    </div>
                    
                    <div class="col-lg-8">
                        <div class="table-responsive">
                            <table id="DataTables" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;width:2%">No</th>
                                        <th style="text-align: center;">Nis</th>
                                        <th style="text-align: center;">Nama Siswa</th>
                                        <th style="text-align: center;">Kelas</th>
                                        <th style="text-align: center;">Alamat</th>
                                        <th style="text-align: center;">Status</th>
                                        <th style="text-align: center;width:15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach($result as $rs):
                                    ?>
                                    <tr>
                                        <td><?php echo $no++; ?></td>
                                        <td><?php echo $rs->nis; ?></td>
                                        <td><?php echo $rs->nama; ?></td>
                                        <td><?php echo $rs->kelas; ?></td>
                                        <td><?php echo $rs->alamat; ?></td>
                                        <td class="text-center">
                                            <div id="status_anggota<?php echo $rs->id; ?>">
                                                <?php if($rs->status == "aktif"): ?>
                                                    <button class="btn btn-sm btn-success" onclick="status('<?php echo $rs->id; ?>')">
                                                        <i class="fa fa-eye p-1"></i> Aktif
                                                    </button>
                                                <?php else: ?>
                                                    <button class="btn btn-sm btn-danger" onclick="status('<?php echo $rs->id; ?>')">
                                                        <i class="fa fa-eye-slash p-1"></i> Non Aktif
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-dark" onclick="edit('<?php echo $rs->id; ?>')" style="width: 30px">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-danger"onclick="hapus('<?php echo $rs->user_id; ?>')" style="width: 30px">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
$(document).ready(function(){
    $('#DataTables').DataTable({
        "paging": true,
        "ordering": false,
        "responsive": true
    });
    $("#btn-simpan").click(function(){
        var formData = new FormData($('#form-anggota')[0]);
        if($("#username").val() == "" || $("#password").val() == ""){
            alert("Username dan Password wajib diisi");
            return false;
        }
        
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('backend/anggota/save'); ?>",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "JSON",
            success: function(data) {
                if(data.status) {
                    location.reload();
                }
            }
        });
        return false;
    });
    
    $("#btn-update").click(function(){
        var formData = new FormData($('#form-anggota')[0]);
          $.ajax({
            type: "POST",
            url: "<?php echo site_url('backend/anggota/update'); ?>",
            data: formData,
            contentType: false,
            processData: false,
            dataType: "JSON",
            success: function(data) {
                if(data.status) {
                    location.reload();
                }
            }
        });
        return false;
    });
    
    $("#btn-refresh").click(function(){
        location.reload();
    });
});

function edit(id) {
    $.ajax({
        type: "GET",
        url: "<?php echo site_url('backend/anggota/edit'); ?>/" + id,
        dataType: "JSON",
        success: function(data) {
            $("#btn-simpan").hide();
            $("#btn-update").show();
            $("#btn-refresh").show();
            
            $("#id_siswa").val(data.id);
            $("#user_id").val(data.user_id);
            $("#nis").val(data.nis);
            $("#nama").val(data.nama);
            $("#kelas").val(data.kelas);
            $("#alamat").val(data.alamat);
            $("#username").val(data.username);
        }
    });
    return false;
}

function hapus(user_id) {
    if(confirm("Yakin ingin menghapus data ini?")) {
        $.ajax({
            type: "GET",
            url: "<?php echo site_url('backend/anggota/hapus'); ?>/" + user_id,
            dataType: "JSON",
            success: function(data) {
                location.reload();
            }
        });
    }
}

function status(id) {
    $.ajax({
        url: "<?php echo site_url('backend/anggota/status'); ?>/" + id,
        type: "GET",
        success: function(data) {
            $("#status_anggota" + id).html(data);
        }
    });
}
</script>
