<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Welcome to Petoo</title>
	<meta name="description" content="The small framework with powerful features">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" type="image/png" href="/favicon.ico"/>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
	<script src="https://kit.fontawesome.com/68a436787d.js" crossorigin="anonymous"></script>
</head>
<body>
	<div class="container-fluid">
		<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
		  <div class="container-fluid">
		    <a class="navbar-brand" href="<?php echo base_url();?>">Petoo</a>
		    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		      <span class="navbar-toggler-icon"></span>
		    </button>
		    <div class="collapse navbar-collapse" id="navbarSupportedContent">
		      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
		       
		      </ul>
		      <ul class="d-flex navbar-nav">
		      	<li class="nav-item"><a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="showCart()">Cart</a></li>
		      	<li class="nav-item">
		      		<?php
		      			if ($username !== '')
		      			{?>
		      				<li class="nav-item dropdown">
          						<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            						<?php echo $username;?>
          						</a>
          						<ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            						<li><a class="dropdown-item" href="#" id="logout">Logout</a></li>
          						</ul>
        					</li>
		      			<?php }
		      			else
		      			{
		      				echo '<a href="#" class="nav-link" data-bs-toggle="modal" data-bs-target="#loginModal">Login/Register</a>';
		      			}
		      		?>
		      	</li>
		      </ul>
		    </div>
		  </div>
		</nav>
		
		<div class="py-4">
				<div class="card">
					<div class="card-header text-center">
						<h2>Menu List</h2>
					</div>
					<div class="card-body text-center">
						<?php if (!empty($data['card'])): ?>
							<?php foreach ($data['card'] as  $value): ?>
								<div class="row py-3">
									<?php foreach ($value as $value2): ?>
										<div class="col-sm-2 col-md-2">
											<div class="card" style="width: 18rem;">
							  					<div class="card-body">
							    					<h5 class="card-title"><?php echo $value2['item_name'];?></h5>
							    					<h6 class="card-subtitle mb-2 text-muted"><?php echo ($value2['is_veg']) ? 'Veg Dish' : 'Non-Veg Dish';?></h6>
							    					<p class="card-text"><?php echo $value2['description'];?></p>
							    					<div class="text-center">
							    						<button class="btn btn-sm btn-primary" onclick="addToCart('<?php echo $value2['item_id'];?>')" id="s<?php echo $value2['item_id'];?>" <?php echo ($value2['disabled']) ? 'disabled':'';?>><?php echo ($value2['disabled']) ? 'Added to Cart': 'Add to Cart';?></button>
							    					</div>
							  					</div>
											</div>
										</div>
									<?php endforeach ?>
								</div>
							<?php endforeach ?>
						<?php endif ?>

					</div>
				</div>
			
		</div>
	</div>

	<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Your Cart Items</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="cartBox">
        	
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="checkoutButton">Checkout</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loginModalLabel">Login Form</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
        	<div class="col-sm-12 col-md-12">
        		<button class="btn btn-sm btn-primary" id="loginButton">Login</button>
        		<button class="btn btn-sm btn-primary" id="signupButton">Signup</button>
        	</div>
        </div>

        <div class="row py-3" id="loginDiv">
        	<form id="loginForm">
        		<div class="form-group row">
        			<label class="col-sm-4 col-md-4">Username:</label>
        			<div class="col-sm-8 col-md-8">
        				<input type="text" name="username" placeholder="Username" class="form-control">
        			</div>
        		</div>
        		<div class="form-group row py-3">
        			<label class="col-sm-4 col-md-4">Username:</label>
        			<div class="col-sm-8 col-md-8">
        				<input type="password" name="password" placeholder="Password" class="form-control">
        			</div>
        		</div>
        		<div class="form-group row py-3">
        			<div class="col-sm-4 col-md-4">
        				
        			</div>

        			<div class="col-sm-4 col-md-4">
        				<button class="btn btn-sm btn-block btn-primary" id="loginB">Login</button>
        			</div>

        			<div class="col-sm-4 col-md-4">
        				
        			</div>
        		</div>
        	</form>
        </div>

        <div class="row py-3" id="regDiv" style="display: none;">
        	<form id="reginstrationForm">
        		<div class="form-group row">
        			<label class="col-sm-4 col-md-4">Full Name:</label>
        			<div class="col-sm-8 col-md-8">
        				<input type="text" name="name" placeholder="Full Name" class="form-control">
        			</div>
        		</div>
        		<div class="form-group row py-3">
        			<label class="col-sm-4 col-md-4">Username:</label>
        			<div class="col-sm-8 col-md-8">
        				<input type="text" name="username" placeholder="Username" class="form-control">
        			</div>
        		</div>
        		<div class="form-group row py-3">
        			<label class="col-sm-4 col-md-4">Password:</label>
        			<div class="col-sm-8 col-md-8">
        				<input type="password" name="password" placeholder="Password" class="form-control">
        			</div>
        		</div>
        		<div class="form-group row py-3">
        			<div class="col-sm-4 col-md-4">
        				
        			</div>

        			<div class="col-sm-4 col-md-4">
        				<button class="btn btn-sm btn-block btn-primary" id="register">Register</button>
        			</div>

        			<div class="col-sm-4 col-md-4">
        				
        			</div>
        		</div>
        	</form>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script type="text/javascript">
	let items = <?php echo json_encode($data['json']);?>;
	// let cart = [];
	let isLoggedIn = '<?php echo $isLoggesin?>';
	let dummyId = '';
	$(document).ready(function()
	{
		$('#foodChoice').select2();

		$('#loginButton').click(function()
		{
			$('#regDiv').hide();
			$('#loginDiv').show();
		});

		$('#signupButton').click(function()
		{
			$('#regDiv').show();
			$('#loginDiv').hide();
		});

		$('#logout').click((e) =>
		{
			e.preventDefault();

			let url = '<?php echo base_url();?>/home/logout';
			let data = {};

			var result = ajaxPost(url, data);
			if (result.status == 'success')
			{
				window.location.reload();
			}
		})
		$('#reginstrationForm').submit(function(e)
		{
			e.preventDefault();

			let data = $('#reginstrationForm').serializeArray();
			let url = '<?php echo base_url();?>/home/register';

			$('#register').html('Please wait....');
			setTimeout(() => 
			{
				let result = ajaxPost(url, data);

				if (result.status == 'success')
				{
					isLoggedIn = 'yes';
					addToCartServer(dummyId);
					window.location.reload();
				}
				else
				{
					alert(result.msg);
				}
				$('#register').html('Register');
			}, 300);

		})

		$('#loginForm').submit(function(e)
		{
			e.preventDefault();

			let data = $('#loginForm').serializeArray();
			let url = '<?php echo base_url();?>/home/login';

			$('#loginB').html('Authenticating....');
			setTimeout(() => 
			{
				let result = ajaxPost(url, data);

				if (result.status == 'success')
				{
					isLoggedIn = 'yes';
					if (dummyId != '')
					{
						addToCartServer(dummyId);
						window.location.reload();
					}
					else
					{
						window.location.reload();
					}
				}
				else
				{
					alert(result.msg);
				}
				$('#loginB').html('Login');
			}, 300);
		})

		$('#checkoutButton').click((e) =>
		{
			e.preventDefault();

			$('#checkoutButton').html('Checking Out....');
			setTimeout(() => 
			{
				let url = '<?php echo base_url();?>/home/checkout';
				let data = {};
				var result = ajaxPost(url, data);
				if (result.status == 'success')
				{
					showCart();
				}

				alert(result.msg);
				$('#checkoutButton').html('Checkout');
				window.location.reload();
			}, 200)
		})
	})

	function addToCart(id)
	{
		if (isLoggedIn == 'yes')
		{
			// cart.push(id);
			$('#s'+id).prop('disabled', true);
			$('#s'+id).html('Adding to cart....');
			
			addToCartServer(id);
			
		}
		else
		{
			dummyId = id;
			$('#loginModal').modal('show');
		}
	}

	function showCart()
	{
		let url = '<?php echo base_url();?>/home/cartItems';
		let data = {};

		var result = ajaxPost(url, data);

		if (result.status == 'success')
		{
			$('#cartBox').html(result.html);
			if (result.isData == 'no')
			{
				$('#checkoutButton').prop('disabled', true);
			}
			else
			{
				$('#checkoutButton').prop('disabled', false);
			}
		}
		else
		{
			alert(result.msg);
		}
	}

	let addToCartServer = (id, type = 'add', from="dashbaord") => 
	{
		let url = '<?php echo base_url();?>/home/addToCart';

		let data = {id:id, type:type,from:from};
		var result = ajaxPost(url, data);
		if (result.status == 'success')
		{
			if (result.remove == 'yes')
			{
				$('#s'+result.id).prop('disabled', false);
			}

			showCart();
		}
		alert(result.msg);
		$('#s' + id).html('Add to Cart');
	}

	function ajaxPost(url, data)
	{
		let result;
		$.ajax(
		{
			url:url,
			type:'post',
			data:data,
			dataType:'json',
			async:false,
			success: (response) => 
			{
				result = response;
			},
			error: (response) =>
			{
				result = response;
			}
		})

		return result;
	}
</script>
</body>
</html>
