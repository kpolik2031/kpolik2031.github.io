<?php $css = ['link.css']; $menu = ['link' => true]; ?>
<?php include ($_SERVER['DOCUMENT_ROOT'].'/app/public/layouts/head.php'); ?>
<div class="container">
	<h1 class="main"> Связаться с нами </h1>

	<form>
		<h3>Оставитьте заявку</h3>

		<input type="text" name="first_name" placeholder="Имя" required>
		<input type="text" name="last_name" placeholder="Фамилия" required>
		<input type="email" name="email" placeholder="Электронная почта" required>
		<input type="text" name="phone" placeholder="Телефон" required>
		<textarea name="ask" placeholder="Напишите ваш вопрос" required></textarea>
		<button>Отправить</button>
	</form>
</div>
<?php include ($_SERVER['DOCUMENT_ROOT'].'/app/public/layouts/foot.php'); ?>