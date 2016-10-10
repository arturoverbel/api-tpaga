<html>

<head>
	<meta charset="UTF-8">
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
</head> 

<body>
<?php
	session_start();
?>
<h1>Charge</h1>

<form>

	Consumer:<br>
  	<input type="text" name="consumer" value="<?php echo $_SESSION["user"]; ?>"><br>

	Credit Card:<br>
  	<input type="text" name="creditCard" value="<?php echo $_SESSION["tokenAsociate"]; ?>"><br>

  	Currency:<br>
  	<input type="text" name="currency" value="COP"><br>

  	Amount:<br>
  	<input type="text" name="amount" value="100000"><br>

  	Tax Amount:<br>
  	<input type="text" name="taxAmount" value="0"><br>

  	<br><input type="button" value="Submit" id="send">
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

</form>
<script type="text/javascript" src="common.js"></script>
<script>


	var url = "https://sandbox.tpaga.co/api/charge/credit_card";

	var tokenPP = token_private + ":" + password;
	$crypt0 = Base64.encode(tokenPP);

	$('#send').click(function(){

		var tokenPP = token_private + ":" + password;
		$crypt0 = Base64.encode(tokenPP);

		var data = {
			  "customer": $("input[name='consumer']").val(),
			  "amount": $("input[name='amount']").val(),
			  "taxAmount": $("input[name='taxAmount']").val(),
			  "currency": $("input[name='currency']").val(),
			  "creditCard": $("input[name='creditCard']").val(),
			  "installments": 1,
			  "orderId": "123",
			  "iacAmount": 0,
			  "tipAmount": 0,
			  "description": "Este pago y tales",
			  "thirdPartyId": "Taxi Driver",
			  "paid": true,
			  "paymentTransaction": "string",
			  "errorCode": "Codigo Error - ",
			  "errorMessage": "Mensaje error",
			  "reteRentaAmount": "1000",
			  "reteIcaAmount": "1000",
			  "reteIvaAmount": "1000",
			  "tpagaFeeAmount": "5000",
			  "transactionInfo": {
			    "authorizationCode": "1",
			    "status": "authorized"
			  }
		}

		var url = "https://sandbox.tpaga.co/api/charge/credit_card";

		var request = $.ajax({
		  url: url,
		  method: "POST",
		  data: JSON.stringify(data),
		  beforeSend: function(xhr) {
		    	xhr.setRequestHeader('Authorization', 'Basic ' + $crypt0);
		  },
		  contentType: "application/json",
		  dataType: "application/json"
		});
		 
		request.done(function( msg ) {
		  console.log( msg );
		});
		 
		request.fail(function( jqXHR, textStatus ) {
		  console.log( "Request failed: " + textStatus );
		});

		request.always(function(a) {
			var data = jQuery.parseJSON( a.responseText );

			if( data.id ){
				$.get( "save.php?field=charge&data=" + data.id, function( data ) {
				  	alert( "Saved." );
				  	window.location.href = "index.php";
				});
			}else
				alert( "Error. Check browser log.");
	 	});

	});



</script>


</body>
</html>