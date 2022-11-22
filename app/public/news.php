<?php $css = ['news.css']; $menu = ['news' => true]; ?>
<?php include ($_SERVER['DOCUMENT_ROOT'].'/app/public/layouts/head.php'); ?>
<div class="container">
	<h3 class="main"> Новости </h3>

	<?php 
		$query = selectAll('SELECT * FROM news');

		if (@count($query) <= 0) {
	?>
		<h4 class="mt-10 mt-center"> Новостей не найдено обратитесь к администратору сайта. </h4>
	<?php
		} else { 
	?>
		<?php foreach ($query as $key => $value) { ?>

			<?php $author = selectOne('SELECT * FROM clients WHERE id = '.$value['author_id'].''); ?>

			<div class="news">
				<img src="/assets/images/parallax.jpg">
				<div class="news-content">
					<h1><?php echo $value['title']; ?></h1>
					<p><?php echo $value['content']; ?></p>

					<span class="actor"><b>Автор:</b> <?php echo ($author == null) ? 'Неизвестно' : $author['name']; ?></span>
					<span class="date"><b>Дата публикации:</b> <?php echo $value['date']; ?></span>
				</div>
			</div>
		<?php } ?>

	<?php } ?>

</div>

<a class="top" href="#top">
	<span>↑</span>
</a>

<?php include ($_SERVER['DOCUMENT_ROOT'].'/app/public/layouts/foot.php'); ?>