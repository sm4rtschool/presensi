<!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url(); ?>asset/plugins/jQuery/jQuery-2.1.4.min.js" type="text/javascript"></script>
	
    <!-- jQuery UI 1.11.4 -->
    <script type="text/javascript">
	
	/*bagian header*/
	$( document ).ready(function() {
		init_kegiatan();
		cascade_output();
	});
	
	function init_kegiatan(){
	    var kd_giat = $('#ckdgiat :selected').val();
		$.ajax({
		type: 'post',
		url: '<?php echo site_url();?>rkakl/getKegiatanByKdGiat/'+kd_giat,
		success: function(data) {
			 $('#nmkegiatan').text(data);
		}
		}); 
	}	
	
	function init_output(){
	    var kd_output = $('#ckdoutput :selected').val();
		$.ajax({
		type: 'post',
		url: '<?php echo site_url();?>rkakl/getOutputByKdOutput/'+kd_output,
		success: function(data) {
			 $('#nmoutput').text(data);
		}
		}); 
	}
	
	function cascade_output(){
	  var kd_giat = $('#ckdgiat :selected').val();
	  $.ajax({
			type: "POST",
			url: "<?php echo site_url();?>/rkakl/getOutputByKdGiat/"+kd_giat,
			contentType: "application/json",              
			dataType: "json",
			success: function (out) {
			$("#ckdoutput").empty();
			$.each(out, function () {
				$("#ckdoutput").append($("<option></option>").val(this['kdoutput']).html(this['kdoutput']));
			});
	        init_output();
			daftar_pok();
		 }
	  });
	  	  
	}
	
	function daftar_pok(){
	
	    var kd_output = $('#ckdoutput :selected').val();
		$.ajax({
		type: 'post',
		url: '<?php echo site_url();?>rkakl/getPOK/'+kd_output,
		success: function(data) {
			 $('#daftarpok').html(data);
		}
		}); 
		
	}
	
	
	$( "#ckdgiat").change(function() {
	  cascade_output();
	  init_kegiatan();
	  
	});

	$( "#ckdoutput").change(function() {
	  init_output();
	  daftar_pok();
	  });
	
	/*end bagian header*/
    </script>