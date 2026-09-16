<?php
namespace App\Repositories;

use App\Interfaces\BookingScheduleRepositoryInterface;
use App\Models\ServiceBooking;
use App\Models\AirportTransfer;
use App\Models\LocalService;
use PDO;
use Throwable;

class PdoBookingScheduleRepository implements BookingScheduleRepositoryInterface {
    public function __construct(private PDO $pdo) {}

    private function logError(Throwable $e): void {
        $rootPath = defined('ROOT_PATH') ? ROOT_PATH : dirname(__DIR__, 2);
        @error_log("[" . date('Y-m-d H:i:s') . "] ERROR " . $e->getCode() . ": " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine() . PHP_EOL, 3, $rootPath . '/error.log');
    }

    public function createBooking(ServiceBooking $booking): ServiceBooking {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO service_bookings (order_id, service_id, scheduled_date, scheduled_time, guests_count, unit_price, total_price, notes, status)
                VALUES (:order_id, :service_id, :scheduled_date, :scheduled_time, :guests_count, :unit_price, :total_price, :notes, :status)
            ");
            $stmt->execute([
                'order_id'       => $booking->orderId,
                'service_id'     => $booking->serviceId,
                'scheduled_date' => $booking->scheduledDate,
                'scheduled_time' => $booking->scheduledTime,
                'guests_count'   => $booking->guestsCount,
                'unit_price'     => $booking->unitPrice,
                'total_price'    => $booking->totalPrice,
                'notes'          => $booking->notes,
                'status'         => $booking->status
            ]);
            $booking->id = (int)$this->pdo->lastInsertId();
            return $booking;
        } catch (Throwable $e) {
            $this->logError($e);
            return $booking;
        }
    }

    public function getBookingsByOrderId(int $orderId): array {
        try {
            $stmt = $this->pdo->prepare("
                SELECT b.*, s.name as s_name, s.category as s_category, s.slug as s_slug, 
                       s.short_description as s_desc, s.image_url as s_img, 
                       s.unit_label as s_unit, s.duration_label as s_dur, s.location_label as s_loc
                FROM service_bookings b
                LEFT JOIN local_services s ON b.service_id = s.id
                WHERE b.order_id = :order_id
                ORDER BY b.id ASC
            ");
            $stmt->execute(['order_id' => $orderId]);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $bookings = [];
            foreach ($rows as $row) {
                $b = ServiceBooking::fromArray($row);
                if (!empty($row['s_name'])) {
                    $b->service = new LocalService(
                        id: (int)$row['service_id'],
                        category: $row['s_category'] ?? '',
                        slug: $row['s_slug'] ?? '',
                        name: $row['s_name'],
                        shortDescription: $row['s_desc'] ?? '',
                        priceEur: (float)($row['unit_price'] ?? 0.0),
                        unitLabel: $row['s_unit'] ?? '',
                        durationLabel: $row['s_dur'] ?? '',
                        locationLabel: $row['s_loc'] ?? '',
                        imageUrl: $row['s_img'] ?? ''
                    );
                }
                $bookings[] = $b;
            }
            return $bookings;
        } catch (Throwable $e) {
            $this->logError($e);
            return [];
        }
    }

    public function findBookingById(int $id): ?ServiceBooking {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM service_bookings WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data ? ServiceBooking::fromArray($data) : null;
        } catch (Throwable $e) {
            $this->logError($e);
            return null;
        }
    }

    public function updateBookingSchedule(int $bookingId, string $date, string $time, ?string $notes = null): bool {
        try {
            $stmt = $this->pdo->prepare("
                UPDATE service_bookings
                SET scheduled_date = :date, scheduled_time = :time, notes = COALESCE(:notes, notes), status = 'scheduled'
                WHERE id = :id
            ");
            return $stmt->execute([
                'date'  => $date,
                'time'  => $time,
                'notes' => $notes,
                'id'    => $bookingId
            ]);
        } catch (Throwable $e) {
            $this->logError($e);
            return false;
        }
    }

    public function saveAirportTransfer(AirportTransfer $transfer): AirportTransfer {
        try {
            $existing = $this->getAirportTransferByOrderId($transfer->orderId);
            if ($existing && $existing->id) {
                $stmt = $this->pdo->prepare("
                    UPDATE airport_transfers 
                    SET flight_number = :flight, airline = :airline, arrival_date = :adate, 
                        arrival_time = :atime, passengers_count = :passengers, 
                        dropoff_location = :dropoff, phone_whatsapp = :phone, 
                        status = 'confirmed', driver_notes = :notes
                    WHERE id = :id
                ");
                $stmt->execute([
                    'flight'     => $transfer->flightNumber,
                    'airline'    => $transfer->airline,
                    'adate'      => $transfer->arrivalDate,
                    'atime'      => $transfer->arrivalTime,
                    'passengers' => $transfer->passengersCount,
                    'dropoff'    => $transfer->dropoffLocation,
                    'phone'      => $transfer->phoneWhatsapp,
                    'notes'      => $transfer->driverNotes,
                    'id'         => $existing->id
                ]);
                $transfer->id = $existing->id;
            } else {
                $stmt = $this->pdo->prepare("
                    INSERT INTO airport_transfers 
                    (order_id, flight_number, airline, arrival_date, arrival_time, passengers_count, dropoff_location, phone_whatsapp, status, driver_notes)
                    VALUES (:order_id, :flight, :airline, :adate, :atime, :passengers, :dropoff, :phone, :status, :notes)
                ");
                $stmt->execute([
                    'order_id'   => $transfer->orderId,
                    'flight'     => $transfer->flightNumber,
                    'airline'    => $transfer->airline,
                    'adate'      => $transfer->arrivalDate,
                    'atime'      => $transfer->arrivalTime,
                    'passengers' => $transfer->passengersCount,
                    'dropoff'    => $transfer->dropoffLocation,
                    'phone'      => $transfer->phoneWhatsapp,
                    'status'     => $transfer->status,
                    'notes'      => $transfer->driverNotes
                ]);
                $transfer->id = (int)$this->pdo->lastInsertId();
            }
            return $transfer;
        } catch (Throwable $e) {
            $this->logError($e);
            return $transfer;
        }
    }

    public function getAirportTransferByOrderId(int $orderId): ?AirportTransfer {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM airport_transfers WHERE order_id = :order_id LIMIT 1");
            $stmt->execute(['order_id' => $orderId]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data ? AirportTransfer::fromArray($data) : null;
        } catch (Throwable $e) {
            $this->logError($e);
            return null;
        }
    }

    public function getAllPassOrders(int $limit = 30): array {
        try {
            $stmt = $this->pdo->prepare("
                SELECT o.*, t.flight_number, t.arrival_date, t.arrival_time, t.status as transfer_status 
                FROM orders o 
                LEFT JOIN airport_transfers t ON t.order_id = o.id 
                WHERE o.type = 'service_pass' 
                ORDER BY o.id DESC 
                LIMIT :limit
            ");
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Throwable $e) {
            $this->logError($e);
            return [];
        }
    }

    public function countPassOrders(): int {
        try {
            $stmt = $this->pdo->query("SELECT COUNT(*) FROM orders WHERE type = 'service_pass'");
            return (int)$stmt->fetchColumn();
        } catch (Throwable $e) {
            $this->logError($e);
            return 0;
        }
    }

    public function getPaginatedPassOrders(int $page = 1, int $limit = 15): array {
        try {
            $page   = max(1, $page);
            $limit  = max(1, $limit);
            $offset = ($page - 1) * $limit;
            $total  = $this->countPassOrders();

            $stmt = $this->pdo->prepare("
                SELECT o.*, t.flight_number, t.arrival_date, t.arrival_time, t.status as transfer_status 
                FROM orders o 
                LEFT JOIN airport_transfers t ON t.order_id = o.id 
                WHERE o.type = 'service_pass' 
                ORDER BY o.id DESC 
                LIMIT :limit OFFSET :offset
            ");
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            $items = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

            return [
                'items' => $items,
                'total' => $total
            ];
        } catch (Throwable $e) {
            $this->logError($e);
            return ['items' => [], 'total' => 0];
        }
    }

    public function updateAirportStatus(int $transferId, string $status, ?string $notes = null): bool {
        try {
            $stmt = $this->pdo->prepare("
                UPDATE airport_transfers 
                SET status = :status, driver_notes = COALESCE(:notes, driver_notes) 
                WHERE id = :id
            ");
            return $stmt->execute(['status' => $status, 'notes' => $notes, 'id' => $transferId]);
        } catch (Throwable $e) {
            $this->logError($e);
            return false;
        }
    }
}
