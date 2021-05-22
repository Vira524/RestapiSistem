<?php

require_once("vendor/autoload.php");
require_once("Connection.php");

use Slim\App;
use Slim\Container;

$setting = array(
"setting" => array(
"displayErrorDetails" => true

   )

);

$container = new Container($setting);
$app = new App($container);
$db = new Connection();

$app->get("/siswa/all", function($request, $response) {
	$db = new Connection();
	$query = "SELECT * FROM siswa";
	$daftar_siswa = $db->fetchAll($query, []);
	return $response->withJson($daftar_siswa);
});

$app->get("/siswa/detail", function($request, $response){
	$db = new Connection();
	$params = $request->getQueryParams();
	$id_siswa = $params['id_siswa'];
	$args = array(":id" => $id_siswa);
	$query = "SELECT * FROM siswa WHERE id = :id";
	$siswa = $db->fetch($query, $args);
	return $response->withJson($siswa);
});

$app->post("/siswa/add", function($request, $response){
	$db = new Connection();
	$param = $request->getParsedBody();
	$query = "INSERT INTO siswa( nama, kelas, sekolah) VALUES (:nama, :kelas, :sekolah)";
	$args = [
		":nama" => $param['nama'],
		":kelas" => $param['kelas'],
		":sekolah" => $param['sekolah']
	];
	$db->execute($query, $args);
	return $response->withJson(["message" => "Success !"]);
});

$app->post("/siswa/edit", function($request, $response){
	$db = new Connection();
	$params = $request->getParsedBody();
	$query = "UPDATE siswa SET nama = :nama, kelas = :kelas, sekolah = :sekolah WHERE id = :id";
	$args = [
		":nama" => $params['nama'],
		":kelas" => $params['kelas'],
		":sekolah" => $params['sekolah'],
		":id" => $params['id']
	];
	$db->execute($query, $args);
	return $response->withJson(["message" => "Success !"]);
});

$app->post("/siswa/delete", function($request, $response){
	$db = new Connection();
	$param = $request->getParsedBody();
	$query = "DELETE FROM siswa WHERE id = :id";
	$args = [
		":id" => $param['id']
	];
	$db->execute($query, $args);
	return $response->withJson(["message" => "Success !"]);
});

$app->run();