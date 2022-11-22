<?php $css = ['products.css']; $menu = ['products' => true]; ?>
<?php include ($_SERVER['DOCUMENT_ROOT'].'/app/public/layouts/head.php'); ?>
<div class="container">
	<h3 class="main"> Список товаров </h3>

	<?php
		$data = $_POST;

		if (isset($data['buy_this'])) {
			
			if (!isset($_SESSION['user']['id'])) {
				exit(show_message('Вы не авторизированы для покупки товара.', '/?page=products'));
			}

			$select = selectOne('SELECT * FROM cart WHERE client_id = "'.$_SESSION['user']['id'].'" AND product_id = "'.$data['product_id'].'"');

			if ($select != null) {
				exit(show_message('Данный товар уже находится в корзине.', '/?page=products'));
			}

			sql_request('INSERT INTO cart SET client_id = "'.$_SESSION['user']['id'].'", product_id = "'.$data['product_id'].'"');
			exit(show_message('Товар добавлен в корзину', '/?page=products'));
		}
	?>

	<?php 
		$query = selectAll('SELECT * FROM products');

		if (@count($query) <= 0) {
	?>
		<h4 class="mt-10 mt-center"> Продуктов не найдено обратитесь к администратору сайта. </h4>
	<?php
		} else { 
	?>
		<div class="products">
			
			<?php foreach ($query as $key => $value) { ?>
				<form method="POST">
					<div class="product">
						<img src="<?php echo $value['image']; ?>">

						<div class="product-info">
							<p class="title"><?php echo $value['name']; ?></p>
							<p class="description"><?php echo $value['description']; ?></p>

							<div class="buy">
								<input type="hidden" name="product_id" value="<?php echo $value['id'];?>">
								<button type="submit" name="buy_this">Купить</button>
								<p class="price"><?php echo $value['price']; ?> Рублей</p>
							</div>
						</div>
					</div>
				</form>
			<?php } ?>

		</div>
	<?php } ?>

</div>

<a class="top" href="#top">
	<span>↑</span>
</a>

<?php include ($_SERVER['DOCUMENT_ROOT'].'/app/public/layouts/foot.php'); ?>