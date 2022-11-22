<?php $css = ['auth.css']; $menu = ['lc' => true]; ?>
<?php include ($_SERVER['DOCUMENT_ROOT'].'/app/public/layouts/head.php'); ?>

<?php
	$data = $_POST;

	if (!empty($_SESSION['user']['id'])) {
		exit(redirect('/?page=cabinet'));
	}

	if (isset($_POST['register'])) {
		$email = $data['email'];
		$login = $data['login'];

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			exit(show_message('Некорректно заполнено поле с почтой. Пример почты: test@mail.ru', '/?page=register'));
		}

		$CheckLogin = selectOne('SELECT * FROM `clients` WHERE login = "'.$login.'"');
		if ($CheckLogin != null) {
			exit(show_message('Пользователь с таким логином уже зарегистрирован ранее.', '/?page=register'));
		}

		$checkEmail = selectOne('SELECT * FROM `clients` WHERE email = "'.$email.'"');
		if ($checkEmail != null) {
			exit(show_message('Данный пользователь с такой почтой уже зарегистрирован', '/?page=register'));
		}

		if ($data['password'] != $data['r_password']) {
			exit(show_message('Пароли не совпадают в поле (Пароль, Повторите пароль)', '/?page=register'));
		}

		$data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
		sql_request('INSERT INTO clients SET name = "'.$data['fio'].'", login = "'.$data['login'].'", email = "'.$data['email'].'", phone = "'.$data['phone'].'", `password` = "'.$data['password'].'"');
		exit(show_message('Вы успешно зарегистрировались.', '/?page=login'));
	}
?>

<div class="container">
	<h1 class="main"> Личный кабинет </h1>

	<form method="POST">
		<h3>Регистрация</h3>

		<input type="text" name="fio" placeholder="ФИО" required>
		<input type="text" name="login" placeholder="Логин" required>
		<input type="text" name="email" placeholder="Почта" required>
		<input type="text" name="phone" placeholder="Номер телефона" required>
		<input type="password" name="password" placeholder="Пароль" required>
		<input type="password" name="r_password" placeholder="Подтверждение пароля" required>
		<button type="submit" name="register">Зарегистрироваться</button>

		<p class="ad"> Уже зарегистрированы? <a class="recomend" href="?page=login">Перейти к входу</a> </p>
	</form>
</div>
<?php include ($_SERVER['DOCUMENT_ROOT'].'/app/public/layouts/foot.php'); ?>