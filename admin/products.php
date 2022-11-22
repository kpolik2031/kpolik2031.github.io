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
						'Вы действительно хотите удалить товар с идентификатором ' . $_GET['delete'] . '?',
						'/admin/products.php?delete='.$_GET['delete'].'&confirm'
					)
				);
			}

			if (isset($_GET['delete']) && isset($_GET['confirm'])) {

				$select = selectOne('SELECT * FROM products WHERE id = "'.$_GET['delete'].'"');

				if ($select != null) {
					sql_request('DELETE FROM products WHERE id = "'.$_GET['delete'].'"');
					sql_request('DELETE FROM cart WHERE product_id = "'.$_GET['delete'].'"');
					exit(show_message('Товар удалён', '/admin/products.php'));
				} else {
					exit(show_message('Товар не найден', '/admin/products.php'));
				}
			}
		?>

		<h1 class="main"> Управление товарами </h1>

		<section>
			<?php $nav = ['products' => true]; ?>
			<?php include $_SERVER['DOCUMENT_ROOT'].'/admin/nav.php'; ?>

			<?php if (!isset($_GET['edit']) && !isset($_GET['create'])) { ?>
				<div class="content">
					<?php 
						$query = selectAll('SELECT * FROM products');

						if (@count($query) <= 0) {
					?>
						<h4 class="mt-10 mt-center"> Товаров не найдено - создайте товар. </h4>
					<?php
						} else { 
					?>
						<div class="products">
							<?php foreach ($query as $key => $value) { ?>
								<div class="product">
									<img src="<?php echo $value['image']; ?>">

									<div class="product-info">
										<p class="title"><?php echo $value['name']; ?></p>
										<p class="description"><?php echo $value['description']; ?></p>
										<p class="price"><?php echo $value['price']; ?> Рублей</p>

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

				<a class="top" href="?create">
					<span>Создать товар</span>
				</a>
			<?php } ?>

			<?php if (isset($_GET['edit'])) { ?>

				<?php 
					if (isset($_POST['csave'])) {
						foreach ($_POST as $key => $string) {
							if ($key == "PhotoFile" || $key == "csave") {
								continue;
							}

							if (empty($string) || $string == "") {
								exit(show_message('Заполните поле '.$key, '/admin/products.php?edit=' . $_GET['edit']));
							}
						}

						if (empty($_GET['edit'])) {
							exit(show_message('Получены некорректные данные от сервера.', '/admin/products.php'));
						}

						$product = sql_request('SELECT * FROM products WHERE id = '.$_GET['edit'])->fetch_assoc();

						if (!isset($product['id'])) {
							exit(show_message('Товар не найден', '/admin/products.php'));
						} else {
							$files = $_FILES;
							$file = $files['PhotoFile'];
							$image = '';

							if ($file['size'] != 0) {
								if (!isCorrectFormatFile($file)) {
									exit(show_message('Файл не соответствует типу. Файл должен быть с типом: (png, jpeg, jpg)', '/admin/products.php?edit=' . $_GET['edit']));
								}

								$type = explode('.', $file['name'])[1];
								$fileid = md5(uniqid(rand(), true));

								$upload = move_uploaded_file($file['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/assets/images/products/'.$fileid.'.'.$type);
								if (!$upload) {
									exit(show_message('Ошибка загрузки файла', '/admin/products.php?edit=' . $_GET['edit']));
								}

								$image = ', `image` = "/assets/images/products/'.$fileid.'.'.$type.'"';
							}

							sql_request('UPDATE products SET `description` = "'.$_POST['description'].'", `name` = "'.$_POST['title'].'", `price` = "'.$_POST['price'].'"'.$image.' WHERE id = "'.$_GET['edit'].'"');

							exit(show_message('Товар сохранён', '/admin/products.php?edit=' . $_GET['edit']));
						}

					}
				?>
				<?php $product = selectOne('SELECT * FROM products WHERE id = "'.$_GET['edit'].'"'); ?>

				<form class="edit" method="POST" enctype="multipart/form-data">
					<input class="input-file" type="file" name="PhotoFile" id="PhotoFile" placeholder="Название">
					<label for="PhotoFile" class="input-trigger">Выбрать файл</label>

					<input class="form-control" type="text" name="title" placeholder="Название" required="" value = "<?php echo $product['name']; ?>">
					<textarea name="description" placeholder="Описание" required=""><?php echo $product['description']; ?></textarea>
					<input type="text" name="price" placeholder="Цена" required="" value = "<?php echo $product['price']; ?>">

					<div class="control">
						<button type="submit" class="submit-send" name="csave"> Сохранить </button>
					</div>
				</form>
			<?php } ?>

			<?php if (isset($_GET['create'])) { ?>
				<?php 
					if (isset($_POST['ccreate'])) {
						foreach ($_POST as $key => $string) {
							if ($key == "ccreate") {
								continue;
							}

							if (empty($string) || $string == "") {
								exit(show_message('Заполните поле '.$key, '/admin/products.php?create'));
							}
						}

						$files = $_FILES;
						$file = $files['PhotoFile'];

						if (!isCorrectFormatFile($file)) {
							exit(show_message('Файл не соответствует типу. Файл должен быть с типом: (png, jpeg, jpg)', '/admin/products.php?create'));
						}

						$type = explode('.', $file['name'])[1];
						$fileid = md5(uniqid(rand(), true));

						$upload = move_uploaded_file($file['tmp_name'], $_SERVER['DOCUMENT_ROOT'].'/assets/images/products/'.$fileid.'.'.$type);

						if (!$upload) {
							exit(show_message('Ошибка загрузки файла', '/admin/products.php?create'));
						}

						sql_request('INSERT INTO products SET `description` = "'.$_POST['description'].'", `name` = "'.$_POST['title'].'", `price` = "'.$_POST['price'].'", `image` = "/assets/images/products/'.$fileid.'.'.$type.'"');
						exit(show_message('Товар создан', '/admin/products.php?create'));

					}
				?>

				<form class="edit" method="POST" enctype="multipart/form-data">
					<input class="input-file" type="file" name="PhotoFile" id="PhotoFile" placeholder="Название">
					<label for="PhotoFile" class="input-trigger">Выбрать файл</label>

					<input class="form-control" type="text" name="title" placeholder="Название" required="">
					<textarea name="description" placeholder="Описание" required=""></textarea>
					<input type="text" name="price" placeholder="Цена" required="">

					<div class="control">
						<button type="submit" class="submit-send" name="ccreate"> Создать </button>
					</div>
				</form>
			<?php } ?>
		</section>
	<?php } ?>
</div>

<?php include ($_SERVER['DOCUMENT_ROOT'].'/app/public/layouts/foot.php'); ?>