<?php $css = ['cabinet.css', 'cart-confirm.css']; $menu = ['lc' => true]; ?>
<?php include ($_SERVER['DOCUMENT_ROOT'].'/app/public/layouts/head.php'); ?>
<?php $user = $_SESSION['user']; ?>
<?php if (!isset($user['id'])) { exit(redirect('/?page=login')); } ?>

<?php
	$select = selectAll('SELECT * FROM cart WHERE client_id = "'.$_SESSION['user']['id'].'"');

	if (@count($select) <= 0) {
		exit(redirect('/?page=cabinet'));
	}

	$data = $_POST;

	if (isset($data['register_order'])) {
		if (empty($data['fio'])) {
			exit(show_message('Заполните поле ФИО', '/?page=buyconfirm'));
		}

		if (empty($data['adress'])) {
			exit(show_message('Заполните поле с адресом', '/?page=buyconfirm'));
		}

		if (empty($data['payment'])) {
			exit(show_message('Заполните поле с способом оплаты', '/?page=buyconfirm'));
		}

		if (empty($data['transport'])) {
			exit(show_message('Заполните поле с способом доставки', '/?page=buyconfirm'));
		}

		$select = selectAll('SELECT * FROM cart WHERE client_id = "'.$_SESSION['user']['id'].'"');
		$products = '';

		foreach ($select as $key => $value) {
			$products .= $value['product_id'].',';
		}

		sql_request('DELETE FROM cart WHERE client_id = "'.$user['id'].'"');
		sql_request('INSERT INTO orders SET adress = "'.$data['adress'].'", pay = "'.$data['payment'].'", delivery = "'.$data['transport'].'", products_id = "'.substr($products, 0, -1).'", client_id = "'.$user['id'].'", date = "'.date("d.m.Y").'", state = "Новый"');

		exit(show_message('Заказ был оформлен отслеживайте статус в личном кабинете', '/?page=cabinet'));
	}
?>

<div class="container">
	<h3 class="main"> Оформление заказа </h3>

	<div class="profile-main">

		<div class="buy-data">
			<h4>Заполните данные</h4>

			<form method="POST">
				<input type="text" name="fio" value="<?php echo $user['name']; ?>" placeholder="ФИО">
				<input type="text" name="adress" placeholder="Адрес">
				
				<select name="payment">
					<option selected disabled>Способ оплаты</option>
					<option value="При получении">При получении</option>
					<option value="На сайте">На сайте</option>
				</select>

				<select name="transport">
					<option selected disabled>Способ доставки</option>
					<option value="Почта">Почта</option>
					<option value="Курьер">Курьер</option>
					<option value="Самовывоз">Самовывоз</option>
					<option value="Транспортная компания">Транспортная компания</option>
				</select>

				<button type="submit" name="register_order">Оформить заказ</button>
			</form>
		</div>

		<div class="cart">
			<h4>Выбранные товары</h4>

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
			<?php } ?>
		</div>
	</div>

</div>
<?php include ($_SERVER['DOCUMENT_ROOT'].'/app/public/layouts/foot.php'); ?>