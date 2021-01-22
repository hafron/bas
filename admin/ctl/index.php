<?php

if (!isset($_SESSION['auth'])) {
	header("Location: login");
}

$users = $model->users->get_all();
