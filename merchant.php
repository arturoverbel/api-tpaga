<html>

<head>
	<meta charset="UTF-8">
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
</head> 

<body>
<?php
	session_start();
?>
<h1>Merchant</h1>

<form>

	Consumer:<br>
  	<input type="text" name="consumer" value="<?php echo $_SESSION["user"]; ?>"><br>

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


	var url = "https://sandbox.tpaga.co/api/parentMerchant/children";

	var tokenPP = token_private + ":" + password;
	$crypt0 = Base64.encode(tokenPP);

	$('#send').click(function(){

		var data = {
			  "mcc": "32",
			  "name": "Merchant",
			  "commerceLegalId": "222",
			  "transactionFee": 0,
			  "commission": 0.033,
			  "dispersionData": {
			    "type": "BA",
			    "shortName": "Un short name",
			    "bankName": "BANCOLOMBIA",
			    "bankAccountType": "AHORROS",
			    "accountOwnerLegalIdNumber": 900836593,
			    "accountOwnerLegalIdType": "CC",
			    "bankAccountNumber": 462558410
			  },
			  "contactInformation": {
			    "email": "arturo.verbel@hotmaiol.com",
			    "address": "Ave Siempre viva 123",
			    "postalCode": 110010,
			    "city": "Bogotá",
			    "state": "DC",
			    "countyCode": "CO",
			    "phone": "3163386191"
			  }
			}

		var request = $.ajax({
		  url: url,
		  method: "POST",
		  data: JSON.stringify(data),
		  crossDomain: true,
		  beforeSend: function(xhr) {
		    	xhr.setRequestHeader('Authorization', 'Basic ' + $crypt0);
		  },
		  contentType: "application/json;charset=UTF-8",
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
				$.get( "save.php?field=merchant&data=" + data.id, function( data ) {
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