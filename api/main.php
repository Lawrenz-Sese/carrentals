<?php
header("Access-Control-Allow-Origin: *");
require_once("./config/Config.php");

$db = new Connection();
$pdo = $db->connect();
$auth = new Auth($pdo);
$gm = new GlobalMethods($pdo);
$post = new Post($pdo);
$get = new Get($pdo);


if (isset($_REQUEST['request'])) {
	$req = explode('/', rtrim($_REQUEST['request'], '/'));
} else {
	$req = array("errorcatcher");
}

switch ($_SERVER['REQUEST_METHOD']) {
	case 'POST':

		switch ($req[0]) {

				// AUTH
			case 'regUser':
				$d = json_decode(base64_decode(file_get_contents("php://input")));
				echo json_encode($auth->regUser($d), JSON_PRETTY_PRINT);
				break;

			case 'login':
				$d = json_decode(base64_decode(file_get_contents("php://input")));
				echo json_encode($auth->loginUser($d), JSON_PRETTY_PRINT);
				break;

				// ADD ENDPOINTS
			case 'addProducts':
				$d = json_decode(base64_decode(file_get_contents("php://input")));
				echo json_encode($post->addProducts($d), JSON_PRETTY_PRINT);
				break;

			case 'addCart':
				$d = json_decode(base64_decode(file_get_contents("php://input")));
				echo json_encode($post->addCart($d), JSON_PRETTY_PRINT);
				break;

			case 'addCheckInfo':
				$d = json_decode(base64_decode(file_get_contents("php://input")));
				echo json_encode($post->addCheckInfo($d), JSON_PRETTY_PRINT);
				break;

			case 'addCheck':
				$d = json_decode(base64_decode(file_get_contents("php://input")));
				echo json_encode($post->addCheckout($d), JSON_PRETTY_PRINT);
				break;

			case 'addFeedback':
				$d = json_decode(base64_decode(file_get_contents("php://input")));
				echo json_encode($post->addFeedback($d), JSON_PRETTY_PRINT);
				break;

			case 'addDiscussion':
				$d = json_decode(base64_decode(file_get_contents("php://input")));
				echo json_encode($post->addDiscussions($d), JSON_PRETTY_PRINT);
				break;

			case 'addQuestion':
				$d = json_decode(base64_decode(file_get_contents("php://input")));
				echo json_encode($post->addQuestions($d), JSON_PRETTY_PRINT);
				break;

				// PULL CHECKPOINTS
			case 'categories':
				$d = json_decode(base64_decode(file_get_contents("php://input")));
				echo json_encode($get->pullCategory($d), JSON_PRETTY_PRINT);
				break;

			case 'users':
				$d = json_decode(base64_decode(file_get_contents("php://input")));
				echo json_encode($get->pullUser($d), JSON_PRETTY_PRINT);
				break;

			case 'userss':
				$d = json_decode(base64_decode(file_get_contents("php://input")));
				echo json_encode($get->pullUserss($d), JSON_PRETTY_PRINT);
				break;

			case 'user':
				$d = json_decode(base64_decode(file_get_contents("php://input")));
				echo json_encode($get->pullUsers($d), JSON_PRETTY_PRINT);
				break;

			case 'products':
				$d = json_decode(base64_decode(file_get_contents("php://input")));
				echo json_encode($get->pullProducts($d), JSON_PRETTY_PRINT);
				break;

			case 'product':
				$d = json_decode(base64_decode(file_get_contents("php://input")));
				echo json_encode($get->pullProduct($d), JSON_PRETTY_PRINT);
				break;

			case 'cart':
				$d = json_decode(base64_decode(file_get_contents("php://input")));
				echo json_encode($get->pullCart($d), JSON_PRETTY_PRINT);
				break;

			case 'checkout':
				$d = json_decode(base64_decode(file_get_contents("php://input")));
				echo json_encode($get->pullCheckout($d), JSON_PRETTY_PRINT);
				break;

			case 'checkoutinfo':
				$d = json_decode(base64_decode(file_get_contents("php://input")));
				echo json_encode($get->pullCheckoutInfo($d), JSON_PRETTY_PRINT);
				break;

			case 'checkoutinfos':
				$d = json_decode(base64_decode(file_get_contents("php://input")));
				echo json_encode($get->pullCheckoutInfos($d), JSON_PRETTY_PRINT);
				break;

			case 'checkouts':
				$d = json_decode(base64_decode(file_get_contents("php://input")));
				echo json_encode($get->pullCheckouts($d), JSON_PRETTY_PRINT);
				break;

			case 'threecart':
				$d = json_decode(base64_decode(file_get_contents("php://input")));
				echo json_encode($get->pullThreeCart($d), JSON_PRETTY_PRINT);
				break;

			case 'threeproducts':
				$d = json_decode(base64_decode(file_get_contents("php://input")));
				echo json_encode($get->pullThreeProducts($d), JSON_PRETTY_PRINT);
				break;

			case 'orders':
				$d = json_decode(base64_decode(file_get_contents("php://input")));
				echo json_encode($get->pullOrders($d), JSON_PRETTY_PRINT);
				break;

			case 'orderscomplete':
				$d = json_decode(base64_decode(file_get_contents("php://input")));
				echo json_encode($get->pullComplete($d), JSON_PRETTY_PRINT);
				break;

			case 'feedbacks':
				$d = json_decode(base64_decode(file_get_contents("php://input")));
				echo json_encode($get->pullFeedbacks($d), JSON_PRETTY_PRINT);
				break;

			case 'discussions':
				$d = json_decode(base64_decode(file_get_contents("php://input")));
				echo json_encode($get->pullDiscussions($d), JSON_PRETTY_PRINT);
				break;

			case 'discussionsone':
				$d = json_decode(base64_decode(file_get_contents("php://input")));
				echo json_encode($get->pullDiscussionSolo($d), JSON_PRETTY_PRINT);
				break;

			case 'question':
				$d = json_decode(base64_decode(file_get_contents("php://input")));
				echo json_encode($get->pullQuestions($d), JSON_PRETTY_PRINT);
				break;




				// DELETE ENDPOINTS
			case 'deleteCart':
				$d = json_decode(base64_decode(file_get_contents("php://input")));
				echo json_encode($post->deleteCart($d), JSON_PRETTY_PRINT);
				break;

			case 'deleteCheck':
				$d = json_decode(base64_decode(file_get_contents("php://input")));
				echo json_encode($post->deleteCheckout($d), JSON_PRETTY_PRINT);
				break;

			case 'deleteProducts':
				$d = json_decode(base64_decode(file_get_contents("php://input")));
				echo json_encode($post->deleteProducts($d), JSON_PRETTY_PRINT);
				break;

			case 'deleteDiscussion':
				$d = json_decode(base64_decode(file_get_contents("php://input")));
				echo json_encode($post->deleteDiscussion($d), JSON_PRETTY_PRINT);
				break;

			case 'deleteUsers':
				$d = json_decode(base64_decode(file_get_contents("php://input")));
				echo json_encode($post->deleteUsers($d), JSON_PRETTY_PRINT);
				break;

				// UPDATE ENDPOINTS
			case 'updateProducts':
				$d = json_decode(base64_decode(file_get_contents("php://input")));
				echo json_encode($post->updateProducts($d), JSON_PRETTY_PRINT);
				break;

			case 'updateActive':
				$d = json_decode(base64_decode(file_get_contents("php://input")));
				echo json_encode($post->updateActive($d), JSON_PRETTY_PRINT);
				break;

			case 'updateActives':
				$d = json_decode(base64_decode(file_get_contents("php://input")));
				echo json_encode($post->updateActives($d), JSON_PRETTY_PRINT);
				break;

			case 'updateVerification':
				$d = json_decode(base64_decode(file_get_contents("php://input")));
				echo json_encode($post->updateVerification($d), JSON_PRETTY_PRINT);
				break;

			case 'updateQuantity':
				$d = json_decode(base64_decode(file_get_contents("php://input")));
				echo json_encode($post->updateQuantity($d), JSON_PRETTY_PRINT);
				break;

			case 'acceptOrder':
				$d = json_decode(base64_decode(file_get_contents("php://input")));
				echo json_encode($post->acceptOrder($d), JSON_PRETTY_PRINT);
				break;

			case 'declineOrder':
				$d = json_decode(base64_decode(file_get_contents("php://input")));
				echo json_encode($post->declineOrder($d), JSON_PRETTY_PRINT);
				break;

			case 'receivedOrder':
				$d = json_decode(base64_decode(file_get_contents("php://input")));
				echo json_encode($post->receivedOrder($d), JSON_PRETTY_PRINT);
				break;


			case 'updateUser':
				$d = json_decode(base64_decode(file_get_contents("php://input")));
				echo json_encode($post->updateUser($d), JSON_PRETTY_PRINT);
				break;

			case 'updateDiscussion':
				$d = json_decode(base64_decode(file_get_contents("php://input")));
				echo json_encode($post->updateDiscussions($d), JSON_PRETTY_PRINT);
				break;


				// REQUESTS for forgot password

				case 'pullAllUsers':
					$d = json_decode(base64_decode(file_get_contents("php://input")));
					echo json_encode($get->pullAllUsers($d), JSON_PRETTY_PRINT);
					break;
				
				case 'updateVerificationFp':
					$d = json_decode(base64_decode(file_get_contents("php://input")));
					echo json_encode($post->updateVerificationFp($d), JSON_PRETTY_PRINT);
					break;

				
					case 'changePasswordFp':
						$d = json_decode(base64_decode(file_get_contents("php://input")));
						echo json_encode($auth->changePasswordFp($d), JSON_PRETTY_PRINT);
						break;
		}
		break;

	case 'GET':
		switch ($req[0]) {



			default:
				http_response_code(400);
				echo "Bad Request";
				break;
		}
		break;

	default:
		http_response_code(403);
		echo "Please contact the Systems Administrator";
		break;
}
