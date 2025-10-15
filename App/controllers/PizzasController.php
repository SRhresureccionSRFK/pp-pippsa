<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, PATCH, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

class PizzasController extends Controller {
    public function Index(): void {
		
		header('Content-Type: application/json');
		$methods_with_body = ['POST', 'PUT', 'DELETE', 'PATCH'];
		$data = null;

		if (in_array($_SERVER['REQUEST_METHOD'], $methods_with_body)) {
			$raw = file_get_contents('php://input');
			$data = json_decode($raw, true);

			if (json_last_error() !== JSON_ERROR_NONE) {
				http_response_code(400);
				echo json_encode(['error' => 'JSON inválido']);
				exit;
			}
		}
        $response = [
            'method'  => $_SERVER['REQUEST_METHOD'],
        ];
		if (!empty($data)) {
			$response['data'] = $data;
		}
		echo json_encode($response);
		exit;
		
    }
    public function bue(): void {
		require(APP_PATH."public/dist/index.html");
	}
}
