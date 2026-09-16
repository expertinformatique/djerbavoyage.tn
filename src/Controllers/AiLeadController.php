<?php
namespace App\Controllers;

use Core\Controller;
use Core\Security;
use App\Services\AiLeadService;

class AiLeadController extends Controller {
    public function __construct(
        private AiLeadService $leadService
    ) {}

    public function submit(): void {
        header('Content-Type: application/json; charset=utf-8');

        $input = json_decode(file_get_contents('php://input'), true);
        if (!is_array($input)) {
            $input = $_POST;
        }

        $cleanData = [
            'name'        => Security::sanitize($input['name'] ?? ''),
            'email'       => Security::sanitize($input['email'] ?? ''),
            'phone'       => Security::sanitize($input['phone'] ?? ''),
            'travel_date' => Security::sanitize($input['travel_date'] ?? ''),
            'notes'       => Security::sanitize($input['notes'] ?? ''),
            'preferences' => is_array($input['preferences'] ?? null) ? $input['preferences'] : []
        ];

        $ip = $_SERVER['REMOTE_ADDR'] ?? null;
        $result = $this->leadService->processLead($cleanData, $ip);

        http_response_code($result['success'] ? 200 : 400);
        echo json_encode($result);
    }
}
