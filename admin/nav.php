<div class="navigation">
	<a class="<?php if ($nav['panel'] == true) {echo 'active';} else {} ?>" href="/admin/">Панель состояния</a>
	
	<a class="<?php if ($nav['users'] == true) {echo 'active';} else {} ?>" href="/admin/users.php">Посетители</a>
	
	<a href="/?page=logout&admin=true">Выйти</a>
</div>