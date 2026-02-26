    <script src="<?=base_url()?>assets/vendors/js/vendors.min.js"></script>
    <!-- vendors.min.js {always must need to be top} -->
    <script src="<?=base_url()?>assets/vendors/js/daterangepicker.min.js"></script>
    <script src="<?=base_url()?>assets/vendors/js/apexcharts.min.js"></script>
    <script src="<?=base_url()?>assets/vendors/js/circle-progress.min.js"></script>
    <!--! END: Vendors JS !-->
    <!--! BEGIN: Apps Init  !-->
    <script src="<?=base_url()?>assets/js/common-init.min.js"></script>
    <script src="<?=base_url()?>assets/js/dashboard-init.min.js"></script>
    <!--! END: Apps Init !-->
    <!--! BEGIN: Theme Customizer  !-->
    <script src="<?=base_url()?>assets/js/theme-customizer-init.min.js"></script>
    <!--! END: Theme Customizer !-->
        <!-- =============== JS LIBRARIES =============== -->
    
    <!-- Bootstrap JS -->
    <script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
    
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.bootstrap5.min.js"></script>
    
    <!-- SweetAlert2 untuk notifikasi -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- =============== CUSTOM JS =============== -->
    <script>
    // Pastikan jQuery sudah terload
    if (typeof jQuery == 'undefined') {
        document.write('<script src="https://code.jquery.com/jquery-3.6.0.min.js"><\/script>');
    }
    </script>
    
    <!-- =============== CONTENT JS AKAN DIMASUKKAN DI SINI =============== -->
</div><!-- /.wrapper -->
</body>
</html>