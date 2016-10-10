<html>
	<head>
	<meta charset="UTF-8">
	</head>
	<body>

		<h1>TPaga</h1>
		<ul>
			<li><h2><a href="registerUser.html">Crear Usuario</a></h2></li>
			<li><h2><a href="createCreditCard.php">Crear Tarjeta de Crédito y Asosiar</a></h2></li>
			<li><h2><a href="charge.php">Pagar con Tarjeta</a></h2></li>
		</ul>
<hr>
		<?php
			session_start();

			echo "User: ";
			echo "<b>" . $_SESSION["user"] . "</b>";
			echo "<br>";
			echo "Credit  Card Token: ";
			echo "<b>" . $_SESSION["creditCard"] . "</b>";
			echo "<br>";
			echo "Token Asociate: ";
			echo "<b>" . $_SESSION["tokenAsociate"] . "</b>";
			echo "<br>";
			echo "Charge: ";
			echo "<b>" . $_SESSION["charge"] . "</b>";

		?>


	</body>

</html>