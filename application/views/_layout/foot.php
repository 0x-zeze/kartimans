
<script>
    $(function() {
        if ($.fn.select2) {
            $('.select2').select2();
        }

        if ($.fn.datetimepicker && $('#reservationdate').length) {
            $('#reservationdate').datetimepicker({
                format: 'YYYY-MM-DD'
            });
        }
    });
</script>
<script>
    $('#create_user').click(function() {
        if ($('#show_input_user').first().is(':hidden')) {
            $('#show_input_user').show('slow');
        } else {
            $('#show_input_user').slideUp();
        }
    });
</script>
<script>
    window.setTimeout(function() {
        $('.alert').fadeTo(500, 0).slideUp(500, function() {
            $(this).remove();
        });
    }, 3000);
</script>
<script>
    $('#produk').on('change', function() {
        $('.qty').html($(this).find(':selected').attr('data-qty'));
        $('.qty').val($(this).find(':selected').attr('data-qty'));

        $('.id').html($(this).find(':selected').attr('data-id'));
        $('.id').val($(this).find(':selected').attr('data-id'));

        $('.stok').html($(this).find(':selected').attr('data-stok'));
        $('.stok').val($(this).find(':selected').attr('data-stok'));
    });
</script>
<script>
    $('#produk_admin').on('change', function() {
        $('.harga').html($(this).find(':selected').attr('data-harga'));
        $('.harga').val($(this).find(':selected').attr('data-harga'));

        $('.price').html($(this).find(':selected').attr('data-price'));
        $('.price').val($(this).find(':selected').attr('data-price'));

        $('.name').html($(this).find(':selected').attr('data-name'));
        $('.name').val($(this).find(':selected').attr('data-name'));

        $('.sisa').html($(this).find(':selected').attr('data-sisa'));
        $('.sisa').val($(this).find(':selected').attr('data-sisa'));
    });
</script>

