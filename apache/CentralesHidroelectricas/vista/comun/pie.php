<!-- FOOTER -->

<footer class="bg-ppal m-0">
    <div class="container-fluid">   
        <div class="text-center text-light d-flex justify-content-end align-items-center p-1">
            <span>Proyecto DAW / Silvia González Serrano</span>
        </div>
    </div>
</footer>  

<!-- SCRIPTS -->
<script src="http://localhost/CentralesHidroelectricas/recursos/js/jquery.js"></script>
<script src="http://localhost/CentralesHidroelectricas/recursos/bootstrap/js/bootstrap.bundle.js"></script>
<script src="http://localhost/CentralesHidroelectricas/recursos/bootstrap/js/bootstrap-table.js"></script>
<script src="http://localhost/CentralesHidroelectricas/recursos/js/validate.js"></script>   
<script src="http://localhost/CentralesHidroelectricas/recursos/js/script.js"></script>

<script>
    $('#exampleModal').on('shown.bs.modal', function () {      
        $.getScript('http://localhost/CentralesHidroelectricas/recursos/js/validate.js');
        $.getScript('http://localhost/CentralesHidroelectricas/recursos/js/script.js');

    });
</script>

  <script>
                $( document ).ready(function() {
    $('#modalMinStock').modal('toggle')
});



                </script>
</body>
</html>
