<?php
$hostName = 'localhost';
$hostuser = 'id21241452_tijabo';
$hostpassword = 'Tijabo123!';
$hosteddb = 'id21241452_tijabo';

$conn = mysqli_connect($hostName, $hostuser, $hostpassword, $hosteddb );
if(!$conn){
  die("Something went wrong...");
}






?>