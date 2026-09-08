<script>
(function(){
  document.querySelectorAll('.alert[data-autohide]').forEach(function(el){
    var ms = parseInt(el.getAttribute('data-autohide'), 10) || 3000;
    setTimeout(function(){
      try {
        if (window.bootstrap && bootstrap.Alert) {
          bootstrap.Alert.getOrCreateInstance(el).close();
        } else {
          el.classList.remove('show');
          el.addEventListener('transitionend', function(){ el.remove(); }, {once:true});
        }
      } catch(e){ el.remove(); }
    }, ms);
  });
})();
</script>
<script src="<?= base_url('assets/'); ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="<?= base_url('assets/'); ?>js/ruang-admin.min.js"></script>
</body>

</html>