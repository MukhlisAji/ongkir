<?php
	$asal = $_POST['asal'];
	$id_kabupaten = $_POST['kab_id'];
	$kurir = $_POST['kurir'];
	$berat = $_POST['berat'];


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_SSL_VERIFYHOST => 0,
  CURLOPT_SSL_VERIFYPEER => 0,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "origin=".$asal."&destination=".$id_kabupaten."&weight=".$berat."&courier=".$kurir,
  CURLOPT_HTTPHEADER => array(
    "content-type: application/x-www-form-urlencoded",
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

$data = json_decode($response, true);
$origin = $data['rajaongkir']['origin_details']['province'];
$destination = $data['rajaongkir']['destination_details']['province'];
if ($kurir == "pos") {
	for ($i=0; $i < count($data['rajaongkir']['results']); $i++) { 
    for ($j=0; $j < count($data['rajaongkir']['results'][$i]['costs']); $j++) {

     echo "<tr><td>".$data['rajaongkir']['results'][$i]['costs'][$j]['description']."</td>"; 
        for ($k=0; $k < count($data['rajaongkir']['results'][$i]['costs'][$j]['cost']); $k++) {
        	echo "<td>".$origin."->".$destination."</td>";

             echo "<td>".$data['rajaongkir']['results'][$i]['costs'][$j]['cost'][$k]['value']."</td>";
             echo "<td>".$data['rajaongkir']['results'][$i]['costs'][$j]['cost'][$k]['etd']."</td></tr>";
        }
    }

}
}else{
for ($i=0; $i < count($data['rajaongkir']['results']); $i++) { 
    for ($j=0; $j < count($data['rajaongkir']['results'][$i]['costs']); $j++) {

     echo "<tr><td>".$data['rajaongkir']['results'][$i]['costs'][$j]['description']."</td>"; 
        for ($k=0; $k < count($data['rajaongkir']['results'][$i]['costs'][$j]['cost']); $k++) {
        	echo "<td>".$origin."->".$destination."</td>";

             echo "<td>".$data['rajaongkir']['results'][$i]['costs'][$j]['cost'][$k]['value']."</td>";
             echo "<td>".$data['rajaongkir']['results'][$i]['costs'][$j]['cost'][$k]['etd']." hari</td></tr>";
        }
    }
}
   
    return $data;
}



