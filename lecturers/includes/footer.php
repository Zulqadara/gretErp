 <footer class="py-5 bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Gretsa University 2018</p>
      </div>
      <!-- /.container -->
    </footer>
</html>
    <!-- Bootstrap core JavaScript -->
    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script type="text/javascript" charset="utf8" src="../vendor/DataTables/datatables.js"></script>
		
	<script>
		function get_child_options(selected){
			var schoolid = jQuery('#school').val();
			if(typeof selected === 'undefined'){
				var selected = '';
				}
			jQuery.ajax({
				url: '/gretsaerp/lecturers/parsers/programs.php',
				type: 'POST',
				data: {schoolid:schoolid, selected:selected},
				success: function(data){
					jQuery('#program').html(data);
				},
				error: function(){alert("Something went wrong with the child options.")},
			});
		}
		jQuery('select[name="school"]').change(function(){
			get_child_options();
		});
	</script>
	
	<script>
		function get_child_options1(selected){
			var programid = jQuery('#program').val();
			if(typeof selected === 'undefined'){
				var selected = '';
				}
			jQuery.ajax({
				url: '/gretsaerp/lecturers/parsers/units.php',
				type: 'POST',
				data: {programid:programid, selected:selected},
				success: function(data){
					jQuery('#unit').html(data);
				},
				error: function(){alert("Something went wrong with the child options.")},
			});
		}
		jQuery('select[name="program"]').change(function(){
			get_child_options1();
		});
	</script>

