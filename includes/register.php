<?php
// assign defaults

$email="email";
$izena="nombre";
$abizena="apellidos";
$hiria="ciudad";
$lurraldea="provincia";
$herrialdea="pais";
$postakodea="codigo postal";
$telefono="telefono";
$pasahitza="contraseña";
$pasahitza_errepikatu="repetir contraseña";


$data = array('email' 		=> 'email',
			  'firstname' 	=> 'nombre',
			  'lastname' 	=> 'apellidos',
			  'postcode' 	=> 'codigo postal',
			  'city' 		=> 'ciudad',
			  'stateProv' 	=> 'provincia',
			  'country'		=> 'pais',
			  'telephone' 	=> 'telefono',
			  'password' 	=> 'contraseña',
			  'password2' 	=> 'repetir contraseña',
			  'imagen'      => ''
);
$error = array('email' 	  => '',
			  'firstname' => '',
			  'lastname'  => '',
			  'city'	  => '',
			  'stateProv' => '',
			  'country'	  => '',
			  'postcode'  => '',
			  'telephone' => '',
			  'password'  => '',
);
if (isset($_POST['data'])) {
	$data = $_POST['data'];

    $path = "perfiles/".basename($_FILES['imagen']['name']);
    move_uploaded_file($_FILES['imagen']['tmp_name'], $path);
    $data['imagen'] = basename($_FILES['imagen']['name']);

	// $pass=md5($data['password']);
	$pass = password_hash($data['password'], PASSWORD_DEFAULT);

	//
	$email = strip_tags($_POST['data']["email"]); 
    if (filter_var($email, FILTER_SANITIZE_EMAIL)){
        echo "El nombre $email es valido";
    } else {
        echo "El nombre $email No es valido";
    }

	$izena = strip_tags($_POST['data']["izena"]); 
    if (preg_match('/^[a-zA-Z]+$/',$izena)){
        echo "El nombre $izena es valido";
    } else {
        echo "El nombre $izena No es valido";
    }

	$abizena = strip_tags($_POST['data']["abizena"]); 
    if (preg_match('/^[a-zA-Z]+$/', $abizena)){
        echo "El nombre $abizena es valido";
    } else {
        echo "El nombre $abizena No es valido";
    }

	$hiria = strip_tags($_POST['data']["hiria"]); 
    if (preg_match('/^[a-zA-Z]+$/', $hiria)){
        echo "El nombre $hiria es valido";
    } else {
        echo "El nombre $hiria No es valido";
    }

	$lurraldea = strip_tags($_POST['data']["lurraldea"]); 
    if (preg_match('/^[a-zA-Z]+$/', $lurraldea)){
        echo "El nombre $lurraldea es valido";
    } else {
        echo "El nombre $lurraldea No es valido";
    }

	$herrialdea = strip_tags($_POST['data']["herrialdea"]); 
    if (preg_match('/^[a-zA-Z]+$/', $herrialdea)){
        echo "El nombre $herrialdea es valido";
    } else {
        echo "El nombre $herrialdea No es valido";
    }

	$postakodea = strip_tags($_POST['data']["postakodea"]); 
    if (filter_var($postakodea, FILTER_VALIDATE_INT)){
        echo "El nombre $postakodea es valido";
    } else {
        echo "El nombre $postakodea No es valido";
    }

	$telefono = strip_tags($_POST['data']["telefono"]); 
    if (filter_var($telefono, FILTER_VALIDATE_INT)){
        echo "El nombre $telefono es valido";
    } else {
        echo "El nombre $telefono No es valido";
    }

	$pasahitza = strip_tags($_POST['data']["contraseña"]);

	$pasahitza_errepikatu = strip_tags($_POST['data']["repetir contraseña"]);


	$stmt = $conx->prepare("INSERT INTO users(username, password, izena, abizena, hiria, lurraldea, herrialdea, postakodea, telefonoa, irudia) VALUES (?,?,?,?,?,?,?,?,?,?)");
	$stmt->bind_param("sssssssiis", $data['email'],  $pass, $data['firstname'], $data['lastname'], $data['city'], $data['stateProv'], $data['country'], $data['postcode'], $data['telephone'], $data['imagen']);
	$stmt->execute();
	$stmt->close();

    if ($conx->errno) {
		die('Error: ' . $conx->error);
	} else {
		header("Location: index.php");
	}
}
?>
	<div class="content">
	<br/>
	<div class="register">

		<h2>Erregistroa egin</h2>
		<br/>

		<b>Introduce la información.</b>
		<br/>
		<form action="<?php echo $_SERVER['PHP_SELF']."?action=register"; ?>" method="POST" enctype="multipart/form-data">
			<p>
				<label>Email/username: </label>
				<input type="text" name="data[email]" value="<?php echo $data['email']; ?>" />
				<?php if ($error['email']) echo '<p>', $error['email']; ?>
			<p>
				
			<p>
				<label>Izena: </label>
				<input type="text" name="data[firstname]" value="<?php echo $data['firstname']; ?>" />
				<?php if ($error['firstname']) echo '<p>', $error['firstname']; ?>
			<p>
			<p>
				<label>Abizena: </label>
				<input type="text" name="data[lastname]" value="<?php echo $data['lastname']; ?>" />
				<?php if ($error['lastname']) echo '<p>', $error['lastname']; ?>
			<p>
			<p>
				<label>Hiria: </label>
				<input type="text" name="data[city]" value="<?php echo $data['city']; ?>" />
				<?php if ($error['city']) echo '<p>', $error['city']; ?>
			<p>
			<p>
				<label>Lurraldea: </label>
				<input type="text" name="data[stateProv]" value="<?php echo $data['stateProv']; ?>" />
				<?php if ($error['stateProv']) echo '<p>', $error['stateProv']; ?>
			<p>
			<!-- // *** validation: implement a database lookup -->
			<p>
				<label>Herrialdea: </label>
				<input type="text" name="data[country]" value="<?php echo $data['country']; ?>" />
				<?php if ($error['country']) echo '<p>', $error['country']; ?>
			<p>
			<p>
				<label>Postakodea: </label>
				<input type="text" name="data[postcode]" value="<?php echo $data['postcode']; ?>" />
				<?php if ($error['postcode']) echo '<p>', $error['postcode']; ?>
			<p>
			<p>
				<label>Telefonoa: </label>
				<input type="text" name="data[telephone]" value="<?php echo $data['telephone']; ?>" />
				<?php if ($error['telephone']) echo '<p>', $error['telephone']; ?>
			<p>
			<p>
				<label>Pasahitza: </label>
				<input type="text" name="data[password]" value="<?php echo $data['password']; ?>" />
				<?php if ($error['password']) echo '<p>', $error['password']; ?>
			<p>
            <p>
                <label>Pasahitza errepikatu: </label>
                <input type="text" name="data[password2]" value="<?php echo $data['password2']; ?>" />
            <p>
            <p>
                <label>Irudia aukeratu:</label>
                <input name="imagen" type="file" />
            <p>
			<p>
				<input type="reset" name="data[clear]" value="Clear" class="button"/>
				<input type="submit" name="data[submit]" value="Submit" class="button marL10"/>
			<p>
		</form>
	</div>
</div>
