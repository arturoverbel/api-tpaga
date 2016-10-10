<html>

<head>
	<meta charset="UTF-8">
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
</head> 

<body>
<?php
	session_start();
?>

<h1>Create Credit Card</h1>

<form>

	Number Credit Card:<br>
  	<input type="text" name="primaryAccountNumber" value="4111111111111111"><br>

  	Expiration Month:<br>
  	<input type="text" name="expirationMonth" value="08"><br>

  	Expiration Year:<br>
  	<input type="text" name="expirationYear" value="2020"><br>

  	Name Credit Card:<br>
  	<input type="text" name="cardHolderName" value="John Smit"><br>

  	Customer:<br>
  	<input type="text" name="customer" value="<?php echo $_SESSION["user"]; ?>"><br>


  	<hr>
  	<input type="button" value="Submit" id="send">

</form>
<script type="text/javascript" src="common.js"></script>
<script>

	var tokenPP = token_public + ":" + password;

	$crypt0 = Base64.encode(tokenPP);


	$('#send').click(function(){

		var card = {
			  "primaryAccountNumber": $("input[name='primaryAccountNumber']").val(),
			  "expirationMonth": $("input[name='expirationMonth']").val(),
			  "expirationYear": $("input[name='expirationYear']").val(),
			  "cardHolderName": $("input[name='cardHolderName']").val(),
		}

		var url = "https://sandbox.tpaga.co/api/tokenize/credit_card";

		var request = $.ajax({
		  url: url,
		  method: "POST",
		  data: JSON.stringify(card),
		  crossDomain: true,
		  beforeSend: function(xhr) {
		    	xhr.setRequestHeader('Authorization', 'Basic ' + $crypt0);
		  },
		  contentType: "application/json;charset=UTF-8",
		  dataType: "application/json;charset=UTF-8"
		});
		 
		request.done(function( msg ) {
		  console.log( msg );
		});
		 
		request.fail(function( jqXHR, textStatus ) {
		  console.log( "Request failed: " + textStatus );
		});

		request.always(function(a) {
			associate( jQuery.parseJSON( a.responseText ) );
	 	});


	});







	function associate( card ){

		var customer = $("input[name='customer']").val();
		var url = "https://sandbox.tpaga.co/api/customer/" + customer + "/credit_card_token";

		var tokenPP = token_private + ":" + password;
		$crypt0 = Base64.encode(tokenPP);

		var request = $.ajax({
		  url: url,
		  method: "POST",
		  data: JSON.stringify({
			  "token": card.token
		  }),
		  crossDomain: true,
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
			data = jQuery.parseJSON( a.responseText );

			$.get( "save.php?field=creditCard&data=" + card.token, function( values ) {

			    $.get( "save.php?field=tokenAsociate&data=" + data.id, function( values ) {
					
				  	alert( "Saved." );
				  	window.location.href = "index.php";

				});
			});

	 	});


	}
















	function charge(card){

		var tokenPP = token_private + ":" + password;
		$crypt0 = Base64.encode(tokenPP);

		var data = {
			  "amount": 1000,
			  "taxAmount": 0,
			  "childMerchantId": "string",
			  "currency": "COP",
			  "creditCard": card.token,
			  "installments": 1,
			  "orderId": "string",
			  "iacAmount": 0,
			  "tipAmount": 0,
			  "description": "string",
			  "thirdPartyId": "string",
			  "paid": true,
			  "customer": "if4p6r631jq2uchns7p0u8js3um50our",
			  "paymentTransaction": "string",
			  "errorCode": "string",
			  "errorMessage": "string",
			  "reteRentaAmount": "string",
			  "reteIcaAmount": "string",
			  "reteIvaAmount": "string",
			  "tpagaFeeAmount": "string",
			  "transactionInfo": {
			    "authorizationCode": "string",
			    "status": "authorized"
			  }
		}

		var url = "https://sandbox.tpaga.co/api/charge/credit_card";

		var request = $.ajax({
		  url: url,
		  method: "POST",
		  data: JSON.stringify(data),
		  crossDomain: true,
		  beforeSend: function(xhr) {
		    	xhr.setRequestHeader('Authorization', 'Basic ' + $crypt0);
		  },
		  contentType: "application/json;charset=UTF-8",
		  dataType: "application/json;charset=UTF-8"
		});
		 
		request.done(function( msg ) {
		  console.log( msg );
		});
		 
		request.fail(function( jqXHR, textStatus ) {
		  console.log( "Request failed: " + textStatus );
		});

		request.always(function(a) {
			console.log(a);
	 	});


	}


</script>


</body>
</html>