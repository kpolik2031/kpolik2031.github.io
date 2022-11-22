<?php $css = ['auth.css', 'admin.css']; ?>
<?php include ($_SERVER['DOCUMENT_ROOT'].'/app/public/layouts/head.php'); ?>

<?php
	$data = $_POST;

	if (isset($_POST['send_login'])) {
		$login = $data['login'];
		$password = $data['password'];

		if ($login != $admin['login'] || $password != $admin['password']) {
			exit(show_message('Некорректный логин или пароль.', '/admin/'));
		}

		$_SESSION['admin'] = true;
		exit(show_message('Вы успешно вошли.', '/admin/'));
	}
?>

<div class="container">
	<?php if (!$_SESSION['admin']) { ?>
		<h1 class="main"> Вход в админ-панель </h1>

		<form method="POST">
			<h3>Вход</h3>

			<input type="text" name="login" placeholder="Логин" required>
			<input type="password" name="password" placeholder="Пароль" required>
			<button type="submit" name="send_login">Войти</button>
		</form>
	<?php } else { ?>

		<?php $countClients = selectOne('SELECT COUNT(*) AS count FROM clients'); ?>
		<?php $countOrders = selectOne('SELECT COUNT(*) AS count FROM orders'); ?>

		<h1 class="main"> Панель состояния </h1>

		<section>
			<?php $nav = ['panel' => true]; ?>
			<?php include $_SERVER['DOCUMENT_ROOT'].'/admin/nav.php'; ?>

			<div class="content">
				<div class="statistic">
					<div class="all_buy">
						<h2> <?php echo $countOrders['count']; ?> </h2>
						<span>Всего заявок</span>
					</div>
				</div>

				<div class="orders">
					<h4> Последние Заявки </h4>

					<?php
						$amount = 0;
						$orders = selectAll('SELECT * FROM orders ORDER BY id DESC');

						if (@count($orders) <= 0) {
					?>
						<h5 class="mt-10 mt-center"> Список последних заказов пуст </h5>
					<?php
						} else { 
					?>
						<table>
							<thead>
								<tr>
									<th>Номер заявки</th>
									<th>Наименование класса пробелемы</th>
									<th>Статус заявки</th>
									<th>Покупатель</th>
									<th>Номер телевона</th>
									<th>Дата заявки</th>
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
											$titleProducts .= ($product['name'] == null ? "-" : $product['name']).', ';
										}

										$clientUser = selectOne('SELECT * FROM clients WHERE id = "'. $v['client_id'].'"');
									?>
									<tr>
										<td><?php echo $v['id']; ?></td>
										<td><?php echo substr($titleProducts, 0, -2); ?></td>
										
										<td><?php echo $v['state']; ?></td>
										<td><?php echo $clientUser['name']; ?></td>
										<td><?php echo $clientUser['phone']; ?></td>
										<td><?php echo $v['date']; ?></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					<?php } ?>
				</div>

			</div>
		</section>
	<?php } ?>
</div>

<?php include ($_SERVER['DOCUMENT_ROOT'].'/app/public/layouts/foot.php'); ?>