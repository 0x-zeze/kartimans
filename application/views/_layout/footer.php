</div>
<!-- Footer -->
<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>© <?= date('Y'); ?> Kartimans Barbershop</span>
        </div>
    </div>
</footer>
<!-- Footer -->
</div>
</div>

<!-- Scroll to top -->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="<?= base_url('assets/'); ?>js/ruang-admin.min.js"></script>
<script src="<?= base_url('assets/AdminLTE/') ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/AdminLTE/') ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url('assets/AdminLTE/') ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?= base_url('assets/AdminLTE/') ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script>
    $(function() {
        if (!$.fn.DataTable) {
            return;
        }

        $('table#example1, table#dataTable').each(function() {
            if ($.fn.DataTable.isDataTable(this)) {
                return;
            }

            var lastHead = ($(this).find('thead th:last').text() || '').trim().toLowerCase();
            $(this).DataTable({
                responsive: true,
                autoWidth: false,
                columnDefs: lastHead === 'action' ? [{ orderable: false, targets: -1 }] : [],
                language: {
                    search: 'Cari:',
                    lengthMenu: 'Tampil _MENU_ data',
                    info: 'Menampilkan _START_-_END_ dari _TOTAL_ data',
                    infoEmpty: 'Tidak ada data',
                    infoFiltered: '(difilter dari _MAX_ data)',
                    zeroRecords: 'Data tidak ditemukan',
                    paginate: {
                        previous: 'Sebelumnya',
                        next: 'Berikutnya'
                    }
                }
            });
        });
    });

    $(function() {
        var $alerts = $('#container-wrapper > .alert, .alert[data-autohide], .alert-dismissible:not(.card-body .alert)');
        if ($alerts.length) {
            $alerts.each(function() {
                var $el = $(this);
                var delay = parseInt($el.data('autohide'), 10) || 3000;
                window.setTimeout(function() {
                    $el.fadeTo(500, 0).slideUp(500, function() {
                        $el.remove();
                    });
                }, delay);
            });
        }
    });
</script>
</body>

</html>
