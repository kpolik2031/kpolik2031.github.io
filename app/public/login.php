<?php $css = ['auth.css']; $menu = ['lc' => true]; ?>
<?php include ($_SERVER['DOCUMENT_ROOT'].'/app/public/layouts/head.php'); ?>

<?php
	$data = $_POST;

	if (!empty($_SESSION['user']['id'])) {
		exit(redirect('/?page=cabinet'));
	}

	if (isset($_POST['send_login'])) {
		$login = $data['login'];
		$password = $data['password'];

		$CheckLogin = selectOne('SELECT * FROM `clients` WHERE login = "'.$login.'"');
		if ($CheckLogin == null) {
			exit(show_message('Некорректный логин или пароль.', '/?page=login'));
		}

		if (!password_verify($password, $CheckLogin['password'])) {
			exit(show_message('Некорректный логин или пароль.', '/?page=login'));
		}

		$_SESSION['user'] = $CheckLogin;
		exit(show_message('Вы успешно вошли.', '/?page=cabinet'));
	}
?>

<div class="container">
	<h1 class="main"> Личный кабинет </h1>

	<form method="POST">
		<h3>Вход</h3>

		<input type="text" name="login" placeholder="Логин" required>
		<input type="password" name="password" placeholder="Пароль" required>
		<button type="submit" name="send_login">Войти</button>

		<p class="ad"> Еще не зарегистрировались? <a class="recomend" href="?page=register">Перейти к регистрации</a> </p>
	</form>
</div>
<?php include ($_SERVER['DOCUMENT_ROOT'].'/app/public/layouts/foot.php'); ?>