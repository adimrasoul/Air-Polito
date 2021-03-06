<?php /* Template Name: AvatarPage */
get_header();
?>
<?php

$username = "arman";
$password = "okAbc1234";
$remote_url = 'https://www.airpolito.it/restaqi-read/';

// Create a stream
$opts = array(
  'http'=>array(
    'method'=>"GET",
    'header' => "Authorization: Basic " . base64_encode("$username:$password")
  ),
  'ssl' => array(
        'verify_peer' => false,
   )
);

$context = stream_context_create($opts);

// Open the file using the HTTP headers set above
$response = file_get_contents($remote_url, false, $context);
$responseJson = json_decode($response, true);
//APQI values
$lastAPQI = $responseJson['records'][0];
$aqiValue = $lastAPQI['aqiValue'];
$aqiStatus = $lastAPQI['aqiStatus'];
$aqiDateCollect = $lastAPQI['aqiDateCollect'];
$aqiSensorDataJson = json_decode(json_decode($lastAPQI['aqiSensorData'], true), true);

// Sensor's values
$pm10 = $aqiSensorDataJson['pm10'];
$pm25 = $aqiSensorDataJson['pm25'];
$no2 = $aqiSensorDataJson['no2'];
$o3 = $aqiSensorDataJson['o3'];
$temp = $aqiSensorDataJson['temp'];
$hum = $aqiSensorDataJson['hum'];

// select Avatar Status
if ($aqiStatus == "Ottima") {
   $avatarUrl = get_template_directory_uri() . '/aqi/resources/Ottima.gif';
} elseif ($aqiStatus == "Buona") {
    $avatarUrl = get_template_directory_uri() . '/aqi/resources/Buona.gif';
} elseif ($aqiStatus == "Accettabile") {
    $avatarUrl = get_template_directory_uri() . '/aqi/resources/Accettabile.gif';
} else {
    $avatarUrl = get_template_directory_uri() . '/aqi/resources/Cattiva.gif';
}
$bgUrl = get_template_directory_uri() . '/aqi/resources/hero-bg.png'
?>

//<style>
//<?php include get_template_directory_uri() . '/aqi/CSS/style.css';  ?>
//</style>

<link href="<?php echo get_template_directory_uri() . '/aqi/CSS/style.css' ?>" rel="stylesheet">
<link href="<?php echo get_template_directory_uri() . '/aqi/CSS/bootstrap.min.css' ?>" rel="stylesheet">


  <div class="container" style="background: url('<?php echo $bgUrl ?>') center bottom no-repeat;">
    <div class="page_content row bgbg">
      <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
        <section id="hero" class="wow fadeIn">
          <div class="hero-container">
            <h1>ZEBRA</h1>
            <img src="<?php echo $avatarUrl; ?>" alt="Hero Imgs" width="400">
            <a class="btn-get-started <?php echo $aqiStatus . '-color' ?>">In questo momento la qualità dell aria
              è <?php echo $aqiStatus?></a>
            <div class="hero">
              <h2><i class=""></i> Continiuamo ad impegnarci così</h2>
            </div>
          </div>
        </section>
      </div>

      <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12">
        <div class="">
            <h2 class="text-center custumTagH">Some more details</h2>
            <ul class="list-group">
              <li class=" text-body list-group-item list-group-item-info">AQI status: <?php echo $aqiStatus; ?></li>
              <li class="text-body list-group-item list-group-item-info">AQI value: <?php echo $aqiValue; ?></li>
              <li class="text-body list-group-item list-group-item-info">Temprature: <?php echo $temp; ?> &#8451;</li>
              <li class="text-body list-group-item list-group-item-info">Humidity: <?php echo $hum; ?>%</li>
              <li class="text-body list-group-item list-group-item-info">Date
                acquisition: <?php echo $aqiDateCollect; ?></li>
            </ul>

            <h3 class="text-center custumTagH">Sensor's value</h3>
            <ul class="list-group">
              <li class=" text-body list-group-item list-group-item-info">PM10: <?php echo $pm10; ?></li>
              <li class="text-body list-group-item list-group-item-info">PM2.5: <?php echo $pm25; ?></li>
              <li class="text-body list-group-item list-group-item-info">NO2: <?php echo $no2; ?></li>
              <li class="text-body list-group-item list-group-item-info">O3: <?php echo $o3; ?></li>
            </ul>
        </div>
      </div>
      <div class="clear"></div>
    </div>
  </div>

<?php get_footer();?>
