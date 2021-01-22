<?php

$verbs = array();
$action = 'index';
if (isset($_GET['request'])) {
	$request = $_GET['request'];
	$exp = explode('/', $request);
	$action = array_shift($exp);
	$verbs = $exp;
}

$ctl = 'ctl/'.$action.'.php';
$tpl = 'tpl/'.$action.'.php';

if (!file_exists($ctl)) {
	include '404.php';
	exit(0);
}

function post($name, $default='') {
	if (isset($_POST[$name])) {
		return $_POST[$name];
	}
	return $default;
}

function avatar_img($avatar, $classes='', $styles='') {
	$class = '';
	if ($classes != '') {
		$class = 'class="'.$classes.'"';
	}
	$style = '';
	if ($styles != '') {
		$style = 'style="'.$styles.'"';
	}
	
	if ($avatar == '') {
		return '<img src="images/user.png" '.$class.' '.$style.'>';
	}
	return '<img src="data:image/png;base64,'.base64_encode($avatar).'" '.$class.' '.$style.'>';
}

$basedir = __DIR__;

session_start();

include 'Model.class.php';
$model = new Model($basedir);

$errors = array();

$default_frame = true;
include $ctl;

if (file_exists($tpl)) {
	if ($default_frame)	include 'header.php';
	include $tpl;
	if ($default_frame)	include 'footer.php';
}

