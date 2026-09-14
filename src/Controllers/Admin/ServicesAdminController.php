<?php
namespace App\Controllers\Admin;

use Core\Controller;
use App\Interfaces\BookingScheduleRepositoryInterface;
use App\Services\SettingsService;

class ServicesAdminController extends Controller {
    public function __construct(
        private BookingScheduleRepositoryInterface $scheduleRepo,
        private SettingsService $settings
    ) {}

    public function index(): void {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['admin_logged'])) {
            $this->redirect('/admin/login');
        }

        $passes = $this->scheduleRepo->getAllPassOrders(50);

        $this->render('admin/services-bookings', [
            'passes'   => $passes,
            'settings' => $this->settings
        ], 'layouts/admin');
    }

    public function updateTransfer(): void {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['admin_logged'])) {
            $this->json(['error' => 'Non autorisé.'], 401);
        }

        $input = json_decode(file_get_contents('php://input'), true) ?? [];
        $transferId = (int)($input['transfer_id'] ?? 0);
        $status = trim($input['status'] ?? 'driver_assigned');
        $notes = trim($input['notes'] ?? '');

        if (!$transferId) {
            $this->json(['error' => 'Identifiant transfert manquant.'], 400);
        }

        $ok = $this->scheduleRepo->updateAirportStatus($transferId, $status, $notes);
        $this->json(['success' => $ok]);
    }
}
