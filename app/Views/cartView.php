<?php if (empty($data)){ ?>
	<div class="text-center">
		<h4>No Items Added to Cart</h4>
	</div>
<?php }else{ ?>

	<div class="table-responsive">
		<table class="table table-bordered">
			<thead>
				<tr>
					<td class="text-center">Item Name</td>
					<td class="text-center">Quantity</td>
					<td class="text-center">Action</td>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($data as $value): ?>
					<tr>
						<td class="text-center">
							<?php echo $value['name'];?>
						</td>

						<td class="text-center">
							<?php echo $value['quantity'];?>
						</td>

						<td class="text-center">
							<button class="btn btn-sm btn-primary" onclick="addToCartServer('<?php echo $value['id'];?>', 'add', 'cart')"><i class="fas fa-plus-circle"></i></button> | 
							<button class="btn btn-sm btn-danger" onclick="addToCartServer('<?php echo $value['id'];?>', 'minus', 'cart')"><i class="fas fa-minus-circle"></i></button>
						</td>
					</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
<?php } ?>