<?php $css = ['cabinet.css']; $menu = ['lc' => true]; ?>
<?php include ($_SERVER['DOCUMENT_ROOT'].'/app/public/layouts/head.php'); ?>
<?php $user = $_SESSION['user']; ?>
<?php if (!isset($user['id'])) { exit(redirect('/?page=login')); } ?>
<?php 
	if (isset($_GET['order_id'])) {

		$order = selectOne('SELECT * FROM orders WHERE id = "'.$_GET['order_id'].'" AND client_id = "'.$user['id'].'"');

		if ($order == null) {
			exit(show_message('Заказ не найден', '/?page=cabinet'));
		}

		if ($order['state'] == 'Доставлен') {
			exit(show_message('Заказ не может быть удалён, так как уже доставлен вам.', '/?page=cabinet'));
		}

		sql_request('DELETE FROM orders WHERE id = "'.$_GET['order_id'].'"');
		exit(show_message('Заказ удалён', '/?page=cabinet'));
	} 
?>

<div class="container">
	<h3 class="main"> Личный кабинет </h3>

	<div class="profile-main">
		<div class="main-info">
			<span class="name"><?php echo $user['name']; ?></span>
			
			<p class="email">
				<b>Ваша почта:</b> 
				<span><?php echo $user['email']; ?></span>
			</p>

			<p class="email">
				<b>Номер:</b> 
				<span><?php echo $user['phone']; ?></span>
			</p>

			<a href="/?page=logout">Выйти</a>
		</div>

		<div class="cart">
			<h4>Корзина</h4>

			<?php
				$amount = 0;
				$query = selectAll('SELECT * FROM cart WHERE client_id = "'.$user['id'].'"');

				if (@count($query) <= 0) {
			?>
				<h5 class="mt-10 mt-center"> Корзина пуста </h5>
			<?php
				} else { 
			?>
				<div class="products">
					<?php foreach ($query as $key => $value) { ?>
						<?php $product = selectOne("SELECT * FROM products WHERE id = '".$value['product_id']."'"); ?>
						<?php $amount += $product['price']; ?>

						<div class="product">
							<img src="<?php echo $product['image']; ?>">
							<span>Название: <?php echo $product['name']; ?></span>
							<span>Цена: <?php echo $product['price']; ?> ₽</span>
						</div>
					<?php } ?>
				</div>

				<span class="all_price">Сумма заказа: <b><?php echo $amount; ?> ₽</b></span>

				<a href="/?page=buyconfirm">Перейти к оформлению</a>
			<?php } ?>
		</div>
	</div>

	<div class="orders">
		<h4>Заказы</h4>

		<?php
			$amount = 0;
			$orders = selectAll('SELECT * FROM orders WHERE client_id = "'.$user['id'].'"');

			if (@count($orders) <= 0) {
		?>
			<h5 class="mt-10 mt-center"> Список заказов пуст </h5>
		<?php
			} else { 
		?>
			<table>
				<thead>
					<tr>
						<th>Номер заказа</th>
						<th>Наименования товаров</th>
						<th>Сумма</th>
						<th>Статус заказа</th>
						<th>Дата заказа</th>
						<th>Действие</th>
					</tr>
				</thead>

				<tbody>
					<?php foreach ($orders as $v) { ?>
						<?php  
							$amount = 0;
							$titleProducts = '';

							foreach (explode(',', $v['products_id']) as $c) {
								$product = selectOne('SELECT * FROM products WHERE id = '.$c.'');
								$amount += $product['price'];
								$titleProducts .= $product['name'].', ';
							}
						?>
						<tr>
							<td><?php echo $v['id']; ?></td>
							<td><?php echo substr($titleProducts, 0, -2); ?></td>
							<td><?php echo $amount; ?> ₽</td>
							<td><?php echo $v['state']; ?></td>
							<td><?php echo $v['date']; ?></td>
							<td><a class="delete" href="/?page=cabinet&order_id=<?php echo $v['id']; ?>">Удалить</a></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		<?php } ?>
	</div>

</div>
<?php include ($_SERVER['DOCUMENT_ROOT'].'/app/public/layouts/foot.php'); ?>