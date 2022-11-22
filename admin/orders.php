<?php $css = ['auth.css', 'products.css', 'admin.css', 'ordersedit.css']; ?>
<?php include ($_SERVER['DOCUMENT_ROOT'].'/app/public/layouts/head.php'); ?>

<div class="container">
	<?php if (!$_SESSION['admin']) { ?>
		<?php exit(redirect("/admin/")); ?>
	<?php } else { ?>

		<?php 
			if (isset($_GET['delete']) && !isset($_GET['confirm'])) {
				exit(
					confirm(
						'Вы действительно хотите удалить заказ с идентификатором ' . $_GET['delete'] . '?',
						'/admin/orders.php?delete='.$_GET['delete'].'&confirm'
					)
				);
			}

			if (isset($_GET['delete']) && isset($_GET['confirm'])) {

				$select = selectOne('SELECT * FROM orders WHERE id = "'.$_GET['delete'].'"');

				if ($select != null) {
					sql_request('DELETE FROM orders WHERE id = "'.$_GET['delete'].'"');

					exit(show_message('Заказ удалён', '/admin/orders.php'));
				} else {
					exit(show_message('Заказ не найден', '/admin/orders.php'));
				}
			}
		?>

		<h1 class="main"> Управление заказами </h1>

		<section>
			<?php $nav = ['orders' => true]; ?>
			<?php include $_SERVER['DOCUMENT_ROOT'].'/admin/nav.php'; ?>

			<?php if (!isset($_GET['edit']) && !isset($_GET['create'])) { ?>
				<div class="content">

					<div class="orders mt--10">
						<h4> Список заказов </h4>

						<?php
							$amount = 0;
							$orders = selectAll('SELECT * FROM orders ORDER BY id DESC');

							if (@count($orders) <= 0) {
						?>
							<h5 class="mt-10 mt-center"> Заказов не найдено </h5>
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
										<th>Способ получения</th>
										<th>Способ оплаты</th>
										<th>Адрес</th>
										<th>Покупатель</th>
										<th>Номер покупателя</th>
										<th>Дата заказа</th>
										<th>Управление</th>
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
											<td><?php echo $amount; ?> ₽</td>
											<td><?php echo $v['state']; ?></td>
											<td><?php echo $v['delivery']; ?></td>
											<td><?php echo $v['pay']; ?></td>
											<td><?php echo $v['adress']; ?></td>
											<td><?php echo $clientUser['name']; ?></td>
											<td><?php echo $clientUser['phone']; ?></td>
											<td><?php echo $v['date']; ?></td>
											<td>
												<div class="control">
													<a href="?edit=<?php echo $v['id']; ?>">Редактировать</a>
													<a href="?delete=<?php echo $v['id']; ?>">Удалить</a>
												</div>
											</td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						<?php } ?>
					</div>

				</div>
			<?php } ?>

			<?php if (isset($_GET['edit'])) { ?>

				<?php 
					if (isset($_POST['csave'])) {
						foreach ($_POST as $key => $string) {
							if ($key == "csave") {
								continue;
							}

							if (empty($string) || $string == "") {
								exit(show_message('Заполните поле '.$key, '/admin/orders.php?edit=' . $_GET['edit']));
							}
						}

						if (empty($_POST['state'])) {
							exit(show_message('Укажите статус заказа', '/admin/orders.php?edit=' . $_GET['edit']));
						}

						if (empty($_GET['edit'])) {
							exit(show_message('Получены некорректные данные от сервера.', '/admin/orders.php'));
						}

						$user = sql_request('SELECT * FROM orders WHERE id = '.$_GET['edit'])->fetch_assoc();

						if (!isset($user['id'])) {
							exit(show_message('Заказ не найден', '/admin/orders.php'));
						} else {
							sql_request('UPDATE orders SET adress="'.$_POST['adress'].'", state="'.$_POST['state'].'" WHERE id = "'.$_GET['edit'].'"');

							exit(show_message('Заказ сохранён', '/admin/orders.php?edit=' . $_GET['edit']));
						}

					}
				?>
				<?php $order = selectOne('SELECT * FROM orders WHERE id = "'.$_GET['edit'].'"'); ?>

				<form class="edit" method="POST" enctype="multipart/form-data">
					<h3> Редактирование заказа </h3>

					<input class="form-control" type="text" name="adress" placeholder="Адрес" required="" value="<?php echo $order['adress'];?>">

					<select name="state">
						<option selected disabled>Статус заказа</option>
						<option value="Новый">Новый</option>
						<option value="Доставлен">Доставлен</option>
					</select>

					<div class="control">
						<button type="submit" class="submit-send" name="csave"> Сохранить </button>
					</div>
				</form>
			<?php } ?>
		</section>
	<?php } ?>
</div>

<?php include ($_SERVER['DOCUMENT_ROOT'].'/app/public/layouts/foot.php'); ?>