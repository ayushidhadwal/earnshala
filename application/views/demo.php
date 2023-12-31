<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>

	<div class="booking-fields">
		<form action="<?= base_url('home/pay') ?>" method="post">
			<table>
				<tr>
					<td>Customer Name</td>
					<td><input type="text" name="CUSTOMER_NAME" value="Puhupwas bind"></td>
				</tr>

				<tr>
					<td>Customer Email</td>
					<td><input type="text" name="CUSTOMER_EMAIL" value="puhupwasbind301@gmail.com"></td>
				</tr>

				<tr>
					<td>Customer Mobile</td>
					<td><input type="text" name="CUSTOMER_MOBILE" value="8510062893"></td>
				</tr>

				<tr>
					<td>Customer AMOUNT</td>
					<td><input type="text" name="PAY_ANY" value="8"></td>
				</tr>

				<tr>
					<td colspan="2"><input type="submit" name="submit" value="Pay Now"></td>
				</tr>

			</table>
		</form>
		
	</div>
	
</body>
</html>