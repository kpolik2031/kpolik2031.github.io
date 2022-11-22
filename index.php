<?php
	$page = $_GET['page'];

	if (isset($page)) {
		$file = $_SERVER['DOCUMENT_ROOT'].'/app/public/'.$page.'.php';

		if (!file_exists($file)) {
			include ($_SERVER['DOCUMENT_ROOT'].'/app/public/404.php');
		} else {
			include $file;
		}

		exit();
	}

	$css = ['slaider.css']; $menu = ['main' => true];
?>
<?php include ($_SERVER['DOCUMENT_ROOT'].'/app/public/layouts/head.php'); ?>
<div class="container">
	<section class="slaider">
		<div class="slider-container">

			<div class="slider">
				<div class="slides">
					<div id="slides__1" class="slide">
						<span class="slide__text"></span>

						<a class="slide__prev" href="#slides__4" title="Предыдущая"></a>
						<a class="slide__next" href="#slides__2" title="Следующая"></a>
					</div>
					<div id="slides__2" class="slide">
						<span class="slide__text"></span>

						<a class="slide__prev" href="#slides__1" title="Предыдущая"></a>
						<a class="slide__next" href="#slides__3" title="Следующая"></a>
					</div>
					<div id="slides__3" class="slide">
						<span class="slide__text"></span>

						<a class="slide__prev" href="#slides__2" title="Предыдущая"></a>
						<a class="slide__next" href="#slides__4" title="Следующая"></a>
					</div>
					<div id="slides__4" class="slide">
						<span class="slide__text"></span>

						<a class="slide__prev" href="#slides__3" title="Предыдущая"></a>
						<a class="slide__next" href="#slides__1" title="Следующая"></a>
					</div>
				</div>

			</div>
		</div>
	</section>
</div>

<section class="company-detail container">
	<h1> Ателье по ремонту и пошиву одежды в СПб </h1>

	<p>
		Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nisl nunc, porta sit amet accumsan non, elementum eu mauris. Pellentesque eros erat, efficitur quis sodales at, elementum et felis. Phasellus at sodales diam, viverra ultrices arcu. Phasellus diam nunc, auctor nec placerat porttitor, mattis ut quam. Proin maximus volutpat rhoncus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent dui ipsum, malesuada eget bibendum vel, fermentum ut nulla. Donec euismod tincidunt convallis. Integer finibus nec massa sed tincidunt. Sed rhoncus arcu id congue vulputate. Aliquam odio dui, eleifend quis sodales sit amet, faucibus eget quam. Vivamus et lectus ac metus congue sollicitudin at et lectus. Nam in sodales felis. Quisque nibh metus, dignissim eu euismod eu, rutrum sed arcu. Quisque ornare condimentum sem, suscipit porttitor ante maximus ac.
	</p>

	<p>
		Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam nisl nunc, porta sit amet accumsan non, elementum eu mauris. Pellentesque eros erat, efficitur quis sodales at, elementum et felis. Phasellus at sodales diam, viverra ultrices arcu. Phasellus diam nunc, auctor nec placerat porttitor, mattis ut quam. Proin maximus volutpat rhoncus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent dui ipsum, malesuada eget bibendum vel, fermentum ut nulla. Donec euismod tincidunt convallis. Integer finibus nec massa sed tincidunt. Sed rhoncus arcu id congue vulputate. Aliquam odio dui, eleifend quis sodales sit amet, faucibus eget quam. Vivamus et lectus ac metus congue sollicitudin at et lectus. Nam in sodales felis. Quisque nibh metus, dignissim eu euismod eu, rutrum sed arcu. Quisque ornare condimentum sem, suscipit porttitor ante maximus ac.
	</p>
</section>

<a class="top" href="#top">
	<span>↑</span>
</a>

<?php include ($_SERVER['DOCUMENT_ROOT'].'/app/public/layouts/foot.php'); ?>