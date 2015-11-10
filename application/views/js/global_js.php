<script type="text/javascript">

function get_kota(id,target,dropdown){
 		console.log('id privinsi' + $(id).val() );
 		$.ajax({
 			url:'<?php echo site_url("lokasi/get_tiger_kota"); ?>/'+$(id).val()+'/'+dropdown,
 			success: function(data){
 				$(target).html('').append(data);
 			}
 		});

 	}
 	

 	function get_kecamatan(id,target,dropdown){
 		console.log('id kabupaten' + $(id).val() );
 		$.ajax({
 			url:'<?php echo site_url("lokasi/get_tiger_kecamatan"); ?>/'+$(id).val()+'/'+dropdown,
 			success: function(data){
 				$(target).html('').append(data);
 			}
 		});
 	}


 	function get_desa(id,target,dropdown){
 		console.log('id kecamatan' + $(id).val() );
 		$.ajax({
 			url:'<?php echo site_url("lokasi/get_tiger_desa"); ?>/'+$(id).val()+'/'+dropdown,
 			success: function(data){
 				$(target).html('').append(data);
 			}
 		});
 	}
 	</script>