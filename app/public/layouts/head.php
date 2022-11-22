<?php 
	@session_start();

	include $_SERVER['DOCUMENT_ROOT'].'/app/functions/database.php';
	include $_SERVER['DOCUMENT_ROOT'].'/app/functions/message.php';
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>С иголочки</title>

		<link rel="stylesheet" type="text/css" href="/assets/css/cicd.css">
		<?php if (@count($css) > 0) { ?>

			<?php foreach ($css as $cssFile) { ?>
				<link rel="stylesheet" type="text/css" href="/assets/css/<?php echo $cssFile; ?>">
			<? } ?>

		<?php } ?>
	</head>

	<header>
		<div class="container">
			<a href="/"> 
				<img class="logo" src="/assets/images/logo.png"> 
			</a>

			<div class="info">
				<p>
					+7-900-000 00-00
				</p>

				<a href="https://vk.com/id0">
					<img src="/assets/images/vk.png">
				</a>
			</div>
		</div>

		<nav>
			<div class="container">
				<a class="<?php if ($menu['main'] == true) {echo 'active';} else {} ?>" href="/">Главная</a>
				<a class="<?php if ($menu['products'] == true) {echo 'active';} else {} ?>" href="/?page=products">Товары</a>
				<a class="<?php if ($menu['news'] == true) {echo 'active';} else {} ?>" href="/?page=news">Новости</a>
				<a class="<?php if ($menu['about'] == true) {echo 'active';} else {} ?>" href="/?page=about">О компании</a>
				<a class="<?php if ($menu['lc'] == true) {echo 'active';} else {} ?>" href="/?page=login">Личный кабинет</a>
				<a class="<?php if ($menu['link'] == true) {echo 'active';} else {} ?>" href="/?page=link">Связаться с нами</a>
			</div>
		</nav>
	</header>

	<body>