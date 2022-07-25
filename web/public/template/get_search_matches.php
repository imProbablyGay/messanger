<?
require '../core/common.php';

$data = json_decode(file_get_contents('php://input'), true);
$startID = $data['startID'];
$str = $data['str'];
$result = select("SELECT userName, id FROM users WHERE id >= $startID && userName != '$_COOKIE[login]' && userName != '' && userName LIKE '%$str%' LIMIT 10");
$matches = json_encode($result);
echo $matches;
?>