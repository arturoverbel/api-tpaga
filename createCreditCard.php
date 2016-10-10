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

<script>

	var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9+/=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/rn/g,"n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}


	

	var token_private = "q4aemlu3206j3qjmvbhkikg2rdemf833";
	var token_public = "34alvi0ogiapf6d02n8mcqj8g28nbid0";
	var password = "TPag0$Arturo";

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