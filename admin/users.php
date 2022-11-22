<?php $css = ['auth.css', 'products.css', 'admin.css']; ?>
<?php include ($_SERVER['DOCUMENT_ROOT'].'/app/public/layouts/head.php'); ?>

<div class="container">
	<?php if (!$_SESSION['admin']) { ?>
		<?php exit(redirect("/admin/")); ?>
	<?php } else { ?>

		<?php 
			if (isset($_GET['delete']) && !isset($_GET['confirm'])) {
				exit(
					confirm(
						'Вы действительно хотите удалить пользователя с идентификатором ' . $_GET['delete'] . '?',
						'/admin/users.php?delete='.$_GET['delete'].'&confirm'
					)
				);
			}

			if (isset($_GET['delete']) && isset($_GET['confirm'])) {

				$select = selectOne('SELECT * FROM clients WHERE id = "'.$_GET['delete'].'"');

				if ($select != null) {
					sql_request('DELETE FROM clients WHERE id = "'.$_GET['delete'].'"');
					sql_request('DELETE FROM cart WHERE client_id = "'.$_GET['delete'].'"');
					sql_request('DELETE FROM orders WHERE client_id = "'.$_GET['delete'].'"');

					exit(show_message('Клиент удалён', '/admin/users.php'));
				} else {
					exit(show_message('Клиент не найден', '/admin/users.php'));
				}
			}
		?>

		<h1 class="main"> Управление пользователями </h1>

		<section>
			<?php $nav = ['users' => true]; ?>
			<?php include $_SERVER['DOCUMENT_ROOT'].'/admin/nav.php'; ?>

			<?php if (!isset($_GET['edit']) && !isset($_GET['create'])) { ?>
				<div class="content">
					<?php 
						$query = selectAll('SELECT * FROM clients');

						if (@count($query) <= 0) {
					?>
						<h4 class="mt-10 mt-center"> Клиентов не найдено. </h4>
					<?php
						} else { 
					?>
						<div class="products">
							<?php foreach ($query as $key => $value) { ?>
								<div class="product">
									<div class="product-info personal-info">
										<p class="title"><?php echo $value['name']; ?></p>
										
										<p class="email">
											<b>Почта:</b> 
											<span><?php echo $value['email']; ?></span>
										</p>

										<p class="email">
											<b>Телефон:</b> 
											<span><?php echo $value['phone']; ?></span>
										</p>

										<p class="email">
											<b>Логин:</b> 
											<span><?php echo $value['login']; ?></span>
										</p>

										<div class="control">
											<a href="?edit=<?php echo $value['id']; ?>">Редактировать</a>
											<a href="?delete=<?php echo $value['id']; ?>">Удалить</a>
										</div>
									</div>
								</div>
							<?php } ?>
						</div>
					<?php } ?>
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
								exit(show_message('Заполните поле '.$key, '/admin/users.php?edit=' . $_GET['edit']));
							}
						}

						if (empty($_GET['edit'])) {
							exit(show_message('Получены некорректные данные от сервера.', '/admin/users.php'));
						}

						$user = sql_request('SELECT * FROM clients WHERE id = '.$_GET['edit'])->fetch_assoc();

						if (!isset($user['id'])) {
							exit(show_message('Клиент не найден', '/admin/users.php'));
						} else {
							sql_request('UPDATE clients SET `name` = "'.$_POST['name'].'", `phone` = "'.$_POST['phone'].'", `email` = "'.$_POST['email'].'" WHERE id = "'.$_GET['edit'].'"');

							exit(show_message('Клиент сохранён', '/admin/users.php?edit=' . $_GET['edit']));
						}

					}
				?>
				<?php $user = selectOne('SELECT * FROM clients WHERE id = "'.$_GET['edit'].'"'); ?>

				<form class="edit" method="POST" enctype="multipart/form-data">
					<h3> Редактирование пользователя </h3>
					<input class="form-control" type="text" name="name" placeholder="имя" required="" value = "<?php echo $user['name']; ?>">
					<input type="text" name="phone" placeholder="Телефон" required="" value = "<?php echo $user['phone']; ?>">
					<input type="text" name="email" placeholder="Почта" required="" value = "<?php echo $user['email']; ?>">

					<div class="control">
						<button type="submit" class="submit-send" name="csave"> Сохранить </button>
					</div>
				</form>
			<?php } ?>
		</section>
	<?php } ?>
</div>

<?php include ($_SERVER['DOCUMENT_ROOT'].'/app/public/layouts/foot.php'); ?>