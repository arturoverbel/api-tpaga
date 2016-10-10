<html>
	<head>
		<meta charset="UTF-8">
		<script type="text/javascript" src="common.js"></script>
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
			/*echo "<br>";
			echo "Merchant: ";
			echo "<b>" . $_SESSION["merchant"] . "</b>";*/
			echo "<br>";
			echo "Token Asociate: ";
			echo "<b>" . $_SESSION["tokenAsociate"] . "</b>";
			echo "<br>";
			echo "Charge: ";
			echo "<b>" . $_SESSION["charge"] . "</b>";

		?><br><br><br><br><br>
<hr>
	<a href="https://sandbox.tpaga.co/merchantDashboard/index" target="_blank">Dashboard</a><br>
	User: <b>arturo-verbel@hotmail.com</b><br>
	Password: <script>document.write(password);</script><br><br>

	Token Private: <script>document.write(token_private);</script><br>
	Token Public: <script>document.write(token_public);</script><br>
	</body>

</html>