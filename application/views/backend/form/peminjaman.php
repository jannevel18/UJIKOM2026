<section class="content-header">
    <div class="container-fluid">
        <div class="card card-dark">
            <div class="card-header">
                <h3 class="card-title">Form Peminjaman Buku</h3>
                <div class="float-right">
                    <span class="badge badge-info" id="cart-count">0 buku</span>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-2">
                            <small class="text-muted">Peminjam</small>
                            <?php if($this->session->userdata('level') == 'siswa'): ?>
                                <input type="hidden" id="anggota_id" name="anggota_id" value="<?php echo $resultAnggota[0]->id ?? ''; ?>">
                                <input type="text" class="form-control" value="<?php echo $resultAnggota[0]->nama ?? ''; ?>" readonly disabled>
                                <small class="text-muted">Anda meminjam untuk diri sendiri</small>
                            <?php else: ?>
                                <select class="form-control" id="anggota_id" required>
                                    <option value="">Pilih Anggota</option>
                                    <?php foreach($resultAnggota as $a): ?>
                                    <option value="<?php echo $a->id; ?>">
                                        <?php echo $a->nis . ' - ' . $a->nama; ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            <?php endif; ?>
                        </div>
            
                        <div class="mb-2">
                            <small class="text-muted">Tanggal Pinjam</small>   
                            <input type="date" class="form-control" id="tgl_pinjam" 
                                   value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                        
                        <div class="mb-2">
                            <small class="text-muted">Tanggal Kembali</small>
                            <input type="date" class="form-control" id="tgl_kembali" 
                                   value="<?php echo date('Y-m-d', strtotime('+7 days')); ?>" required>
                        </div>
                        
                        <hr>  
                        
                        <div class="card card-light">
                                <div class="mb-3">
                                    <small class="text-muted">Buku yang dnpinjam</small>
                                    <select class="form-control" id="buku_id">
                                        <option value="">Pilih Buku</option>
                                        <?php foreach($resultBuku as $b): ?>
                                        <option value="<?php echo $b->id; ?>" 
                                                data-stok="<?php echo $b->stok; ?>"
                                                data-judul="<?php echo $b->judul; ?>">
                                            <?php echo $b->kode_buku . ' - ' . $b->judul; ?>
                                            (Stok: <?php echo $b->stok; ?>)
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <small class="text-muted">Jumlah</small>
                                    <input type="number" class="form-control" id="qty" value="1" min="1">
                                </div>
                                
                                <button class="btn btn-dark btn-block" id="btn-tambah-buku">
                                    <i class="fas fa-plus"></i> Tambah ke Daftar
                                </button>
                            </div>
                        
                    </div>
                    <div class="col-md-8">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="bg-light">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Buku</th>
                                        <th width="15%">Jumlah</th>
                                        <th width="10%">Stok</th>
                                        <th width="10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="cart-items">
                                    <tr><td colspan="5" class="text-center">Belum ada buku dipilih</td></tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="text-right mt-3">
                            <button class="btn btn-success btn-lg" id="btn-simpan">
                                <i class="fas fa-save"></i> Simpan Peminjaman
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
$(document).ready(function() {
    const baseUrl = '<?php echo site_url("backend/peminjaman/ajax"); ?>';

    loadCart();
    
    $('#btn-tambah-buku').click(function() {
        const bukuId = $('#buku_id').val();
        const qty = $('#qty').val();
        
        if (!bukuId) {
            alert('Pilih buku terlebih dahulu');
            return;
        }
        
        if (qty < 1) {
            alert('Jumlah minimal 1');
            return;
        }
        
        $.ajax({
            url: baseUrl + '/tambah_buku',
            type: 'POST',
            data: { 
                id_buku: bukuId,
                qty: qty 
            },
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    loadCart();
                    $('#buku_id').val('');
                    $('#qty').val('1');
                    updateCartCount(response.cart_count);
                } else {
                    alert(response.message);
                }
            }
        });
    });
    
    $(document).on('change', '.qty-input', function() {
        const bukuId = $(this).data('id');
        const qty = $(this).val();
        
        $.ajax({
            url: baseUrl + '/update_qty',
            type: 'POST',
            data: { 
                buku_id: bukuId,
                qty: qty 
            },
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    loadCart(); 
                } else {
                    alert(response.message);
                    loadCart(); 
                }
            }
        });
    });
    
    $(document).on('click', '.btn-hapus-buku', function() {
        if (!confirm('Hapus buku dari daftar?')) return;
        
        const bukuId = $(this).data('id');
        
        $.ajax({
            url: baseUrl + '/hapus_buku',
            type: 'POST',
            data: { buku_id: bukuId },
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    loadCart();
                    updateCartCount(response.cart_count);
                } else {
                    alert(response.message);
                }
            }
        });
    });
    
    $('#btn-simpan').click(function() {
        if (!$('#anggota_id').val()) {
            alert('Pilih anggota terlebih dahulu');
            return;
        }
        
        if (!$('#tgl_pinjam').val() || !$('#tgl_kembali').val()) {
            alert('Tanggal pinjam dan kembali harus diisi');
            return;
        }
        
        $.ajax({
            url: baseUrl + '/simpan',
            type: 'POST',
            data: {
                anggota_id: $('#anggota_id').val(),
                tgl_pinjam: $('#tgl_pinjam').val(),
                tgl_kembali: $('#tgl_kembali').val()
            },
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    alert(response.message);
                    location.reload(); 
                } else {
                    alert(response.message);
                }
            }
        });
    });
    
    function loadCart() {
        $.ajax({
            url: baseUrl + '/view_cart',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    $('#cart-items').html(response.html);
                    updateCartCount(response.cart_count);
                }
            }
        });
    }
    
    function updateCartCount(count) {
        $('#cart-count').text(count + ' buku');
        $('#btn-simpan').prop('disabled', count === 0);
    }
    
    $('#buku_id').change(function() {
        const selected = $(this).find('option:selected');
        const stok = selected.data('stok') || 0;
        
        $('#qty').attr('max', stok);
        
        if (stok < 1) {
            $('#btn-tambah-buku').prop('disabled', true)
                                 .text('Stok Habis');
        } else {
            $('#btn-tambah-buku').prop('disabled', false)
                                 .text('Tambah ke Daftar');
        }
    });
});
</script>