<?php

function show_message ($text, $href) {
	echo '<script>alert("'.$text.'"); location.href = "'.$href.'";</script>';
}

function redirect ($href) {
	echo '<script>location.href = "'.$href.'";</script>';
}