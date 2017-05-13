<?php require_once 'request.php';?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset='UTF-8'>
		<title>videoplayback</title>
		<meta name='viewport' content='width=device-width'>
		<link rel='icon' href='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAMAAAAoLQ9TAAAAA3NCSVQICAjb4U/gAAAACXBIWXMAAABvAAAAbwHxotxDAAAAGXRFWHRTb2Z0d2FyZQB3d3cuaW5rc2NhcGUub3Jnm+48GgAAAFFQTFRF////AAAAGwAALQEBPgICOAICSCEhTwMDUkVFUkZGVD4+VQMDXx0dghERkgUFmQUFmo+PnpaWogUFpQUFrgYGuQYGugYG0wcH1QcH6Ojo////VIe8EAAAAAZ0Uk5TAAhV1OLk46qZIwAAAFJJREFUGFdjYMAEjEgAyGViZkECzEwMzBIogJmBFUwLiUMFWCECwhxsoigC/IKSXLyoAlJSAjz4BdC0CHOiGYpsLdxhfOzs3CJizJhOx/AcOgAA5zwM2aaHDyMAAAAASUVORK5CYII='>
		<script src='//content.jwplatform.com/libraries/md7nkykN.js'></script>
		<link rel='stylesheet' href='css/normalize.css'>
		<link rel='stylesheet' href='css/tube.css'>
	</head>
	<body>
		<div id='videoContainer'>Loading Error...</div>
		<script><?php JsPacker($_SERVER['QUERY_STRING'])?></script>
		<noscript>您的瀏覽器不被網站支援</noscript>
	</body>
</html>