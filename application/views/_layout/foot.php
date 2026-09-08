
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="<?= base_url('assets/AdminLTE/') ?>plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->

<script src="<?= base_url('assets/AdminLTE/') ?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/AdminLTE/') ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>

<!-- page script -->

<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()

    })
</script>
<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "autoWidth": false,
        });

        //Date range picker
        $('#reservationdate').datetimepicker({
            format: 'YYYY-MM-DD'
        });
    });
</script>
<script>
    $("#create_user").click(function() {
        if ($("#show_input_user").first().is(":hidden")) {
            $("#show_input_user").show("slow");
        } else {
            $("#show_input_user").slideUp();
        }
    });
</script>
<script>
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function() {
            $(this).remove();
        });
    }, 3000)
</script>
<script>
    console.log = function() {}
    $("#produk").on('change', function() {

        $(".qty").html($(this).find(':selected').attr('data-qty'));
        $(".qty").val($(this).find(':selected').attr('data-qty'));


        $(".id").html($(this).find(':selected').attr('data-id'));
        $(".id").val($(this).find(':selected').attr('data-id'));

        $(".stok").html($(this).find(':selected').attr('data-stok'));
        $(".stok").val($(this).find(':selected').attr('data-stok'));
    });
</script>
<script>
    console.log = function() {}
    $("#produk_admin").on('change', function() {

        $(".harga").html($(this).find(':selected').attr('data-harga'));
        $(".harga").val($(this).find(':selected').attr('data-harga'));

        $(".price").html($(this).find(':selected').attr('data-price'));
        $(".price").val($(this).find(':selected').attr('data-price'));


        $(".name").html($(this).find(':selected').attr('data-name'));
        $(".name").val($(this).find(':selected').attr('data-name'));

        $(".sisa").html($(this).find(':selected').attr('data-sisa'));
        $(".sisa").val($(this).find(':selected').attr('data-sisa'));


    });
</script>
</body>

</html>
