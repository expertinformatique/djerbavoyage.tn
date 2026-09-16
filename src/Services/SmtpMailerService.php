<?php
namespace App\Services;

use Throwable;

class SmtpMailerService {
    public const SMTP_HOST = 'mail.djerbavoyage.tn';
    public const SMTP_PORT = 465;
    public const SMTP_USER = 'reservation@djerbavoyage.tn';
    public const SMTP_PASS = 'Djerba_Voyage_2026';
    public const SMTP_FROM_NAME = 'Djerba Voyage Club';

    public const IMAP_PORT = 993;
    public const POP3_PORT = 995;

    public function getSettings(): array {
        return [
            'outgoing' => [
                'server' => self::SMTP_HOST,
                'port'   => self::SMTP_PORT,
                'secure' => 'SSL/TLS',
                'user'   => self::SMTP_USER,
            ],
            'incoming' => [
                'server' => self::SMTP_HOST,
                'imap'   => self::IMAP_PORT,
                'pop3'   => self::POP3_PORT,
                'user'   => self::SMTP_USER,
            ]
        ];
    }

    public function send(string $to, string $subject, string $htmlBody, string $textBody = ''): bool {
        try {
            return $this->sendViaSmtpSocket($to, $subject, $htmlBody, $textBody);
        } catch (Throwable $e) {
            $rootPath = defined('ROOT_PATH') ? ROOT_PATH : dirname(__DIR__, 2);
            @error_log("[" . date('Y-m-d H:i:s') . "] SMTP ERROR " . $e->getCode() . ": " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine() . PHP_EOL, 3, $rootPath . '/error.log');
            return false;
        }
    }

    private function sendViaSmtpSocket(string $to, string $subject, string $htmlBody, string $textBody = ''): bool {
        $timeout = 8;
        $context = stream_context_create([
            'ssl' => [
                'verify_peer'       => false,
                'verify_peer_name'  => false,
                'allow_self_signed' => true
            ]
        ]);

        $socket = @stream_socket_client(
            "ssl://" . self::SMTP_HOST . ":" . self::SMTP_PORT,
            $errno,
            $errstr,
            $timeout,
            STREAM_CLIENT_CONNECT,
            $context
        );

        if (!$socket) {
            throw new \Exception("Connexion SMTP échouée à " . self::SMTP_HOST . ": $errstr ($errno)");
        }

        stream_set_timeout($socket, $timeout);
        $this->readResponse($socket, '220');

        $this->sendCommand($socket, "EHLO djerbavoyage.tn", '250');
        $this->sendCommand($socket, "AUTH LOGIN", '334');
        $this->sendCommand($socket, base64_encode(self::SMTP_USER), '334');
        $this->sendCommand($socket, base64_encode(self::SMTP_PASS), '235');

        $this->sendCommand($socket, "MAIL FROM: <" . self::SMTP_USER . ">", '250');
        $this->sendCommand($socket, "RCPT TO: <" . trim($to) . ">", '250');
        $this->sendCommand($socket, "DATA", '354');

        $headers  = "From: " . self::SMTP_FROM_NAME . " <" . self::SMTP_USER . ">\r\n";
        $headers .= "Reply-To: " . self::SMTP_USER . "\r\n";
        $headers .= "To: <" . trim($to) . ">\r\n";
        $headers .= "Subject: =?UTF-8?B?" . base64_encode($subject) . "?=\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $headers .= "Date: " . date('r') . "\r\n";

        $message = $headers . "\r\n" . $htmlBody . "\r\n.\r\n";
        fputs($socket, $message);
        $this->readResponse($socket, '250');

        $this->sendCommand($socket, "QUIT", '221');
        fclose($socket);

        return true;
    }

    private function sendCommand($socket, string $command, string $expectedCode): void {
        fputs($socket, $command . "\r\n");
        $this->readResponse($socket, $expectedCode);
    }

    private function readResponse($socket, string $expectedCode): string {
        $response = '';
        while ($line = fgets($socket, 515)) {
            $response .= $line;
            if (isset($line[3]) && $line[3] === ' ') {
                break;
            }
        }
        if (substr($response, 0, strlen($expectedCode)) !== $expectedCode) {
            throw new \Exception("Réponse SMTP inattendue: " . trim($response) . " (attendu $expectedCode)");
        }
        return $response;
    }
}
