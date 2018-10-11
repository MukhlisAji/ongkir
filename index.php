<!DOCTYPE html>
<html>
	<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Request</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.css" rel="stylesheet">

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

    <link rel="stylesheet" type="text/css" href="css/main.css">

    <!-- Custom styles for this template -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

	<script type="text/javascript">
  $('select').select2();
</script>

	</head>
	
	<body>

		<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="index.php?page=home">Home</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      </div>
    </nav>

    <div class="container">
    	  <br><br><br><br><br>
  <h2>cek ongkir</h2><br>


<div class="form-group form-control">
      

    <div class="form-group form-inline">
    <label class="control-label col-sm-2" for="Nama">Kota asal: </label>
    <div class="col-md-6">
    <select name='asal' id='asal' class="myselect form-control">
    	<option>Pilih Kota Asal</option>
    	<?php
    	$respon = curl("http://api.rajaongkir.com/starter/city");
    		$data = json_decode($respon, true);
		for ($i=0; $i < count($data['rajaongkir']['results']); $i++) { 
		    echo "<option value='".$data['rajaongkir']['results'][$i]['city_id']."'>".$data['rajaongkir']['results'][$i]['city_name']."</option>";
		}
    	?>
    </select>
	</div>
	</div>

    <div class="form-group form-inline">
    <label class="control-label col-sm-2" for="Nama">Tujuan: </label>
    <div class="col-md-6">
    <select name='provinsi' id='provinsi' class="form-control myselect" style=>
    	<option>Pilih Tujuan</option>
    	<?php
    	$respon = curl("http://api.rajaongkir.com/starter/city");
    		$data = json_decode($respon, true);
			for ($i=0; $i < count($data['rajaongkir']['results']); $i++) {
				echo "<option value='".$data['rajaongkir']['results'][$i]['province_id']."'>".$data['rajaongkir']['results'][$i]['province']."</option>";
			}
    	?>
    </select>
	</div>
	</div>



 
    <div class="form-group form-inline">
	 <label class="control-label col-sm-2" for="Nama">Kabupaten Tujuan: </label>
		<div class="col-md-6">
		<select id="kabupaten" name="kabupaten" class="form-control myselect"></select>
	</div>
	</div>

	<div class="form-group form-inline">
	 <label class="control-label col-sm-2" for="Nama">Kurir: </label>
	 	<div class="col-md-6">
            <select id="kurir" name="kurir" class="form-control select2-search__field">
	            <option value="jne">JNE</option>
				<option value="tiki">TIKI</option>
				<option value="pos">POS INDONESIA</option> 
			</select>
    	</div>
    </div>


	<div class="form-group form-inline">
		 <label class="control-label col-sm-2" for="Nama">Berat(gram): </label>
		 	<div class="col-md-6">
		 		<input id="berat" type="text" name="berat" value="1000" class="form-control">
		</div>
	</div>

     
   <div class="form-group form-inline">
	<label class="control-label col-sm-2"></label>
		<div class="col-md-2">
			<input id="cek" type="submit" value="Cek" class="btn btn-success" />
		</div>
	</div>

		<div class="form-group form-inline">

			<div class="col-md-9">

			<table class="table100">
				<thead>
					<tr class="table100-head">
						<th class="column2">jenis pengiriman</th>
						<th class="column2">Area pengiriman</th>
						<th class="column3">Harga(IDR)</th>
						<th class="column4">ETD</th>
					</tr>
				</thead>
				<tbody class="table100-body" id="ongkir" name="ongkir">

 
				</tbody>
			</table>
			</div>
		</div>
		
		
		</div>


	</body>
	
</html>

<script type="text/javascript">

	$(document).ready(function(){
		$('#provinsi').change(function(){

			var prov = $('#provinsi').val();

      		$.ajax({
            	type : 'GET',
           		url : 'http://localhost/ongkir/cek_kabupaten.php',
            	data :  'prov_id=' + prov,
					success: function (data) {

					$("#kabupaten").html(data);
				}
          	});
		});

		$("#cek").click(function(){
			var asal = $('#asal').val();
			var kab = $('#kabupaten').val();
			var kurir = $('#kurir').val();
			var berat = $('#berat').val();

      		$.ajax({
            	type : 'POST',
           		url : 'http://localhost/ongkir/cek_ongkir.php',
            	data :  {'kab_id' : kab, 'kurir' : kurir, 'asal' : asal, 'berat' : berat},
					success: function (data) {

					$("#ongkir").html(data);
				}
          	});
		});
	});
</script>


<?php

	function curl($url){
		$curl = curl_init();

	  curl_setopt_array($curl, array(
	  CURLOPT_URL => $url,
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "GET",
	  CURLOPT_HTTPHEADER => array(
	    "key: 3402ea21a0b7a18d15d5b5aa644cf5ce"
	  ),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
	  echo "cURL Error #:" . $err;
	} else {
	  $response;
	}
	return $response;
	}

?>