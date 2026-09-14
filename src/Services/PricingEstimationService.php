<?php
namespace App\Services;

class PricingEstimationService {
    public const AIRPORT_TRANSFER_PRICE = 35.00;
    public const FREE_TRANSFER_ACTIVITY_COUNT = 3;
    public const FREE_TRANSFER_MIN_AMOUNT = 99.00;
    public const DEPOSIT_PERCENTAGE = 0.30;

    public function calculateEstimate(array $items, bool $includeAirport = false, string $paymentMode = 'full'): array {
        $subtotal = 0.0;
        $categories = [];
        $validItemsCount = 0;

        foreach ($items as $item) {
            $qty = max(1, (int)($item['quantity'] ?? 1));
            $price = (float)($item['unit_price'] ?? 0.0);
            $cat = $item['category'] ?? 'activite';
            
            if ($cat !== 'transfert' && $price > 0) {
                $subtotal += ($price * $qty);
                $validItemsCount++;
                $categories[$cat] = true;
            }
        }

        // Calcul du palier de réduction dégressif
        $hasAccommodation = isset($categories['hotel']) || isset($categories['maison']);
        $discountRate = 0.0;
        $packLabel = 'Tarif Standard';
        $nextTierMessage = 'Ajoutez 1 activité pour économiser 5% sur tout votre séjour !';

        if ($validItemsCount >= 4 || ($hasAccommodation && $validItemsCount >= 2)) {
            $discountRate = 0.15;
            $packLabel = 'Pack Privilège Évasion (-15%)';
            $nextTierMessage = '✨ Remise maximale débloquée (-15%) + Transfert VIP Offert !';
        } else if ($validItemsCount === 3) {
            $discountRate = 0.10;
            $packLabel = 'Pack Aventure Djerba (-10%)';
            $nextTierMessage = 'Ajoutez 1 service pour débloquer la réduction maximale de -15% !';
        } else if ($validItemsCount === 2) {
            $discountRate = 0.05;
            $packLabel = 'Pack Découverte Djerba (-5%)';
            $nextTierMessage = 'Plus qu’une activité pour passer à -10% et débloquer l’Accueil Aéroport VIP GRATUIT !';
        }

        $discountAmount = round($subtotal * $discountRate, 2);
        $amountAfterDiscount = $subtotal - $discountAmount;

        // Règle d'or de l'accueil aéroport VIP
        $isAirportTransferFree = ($validItemsCount >= self::FREE_TRANSFER_ACTIVITY_COUNT) || ($subtotal >= self::FREE_TRANSFER_MIN_AMOUNT);
        $transferPrice = 0.0;
        
        if ($includeAirport) {
            $transferPrice = $isAirportTransferFree ? 0.0 : self::AIRPORT_TRANSFER_PRICE;
        }

        $totalNet = round($amountAfterDiscount + $transferPrice, 2);
        $transferSavings = ($includeAirport && $isAirportTransferFree) ? self::AIRPORT_TRANSFER_PRICE : ($isAirportTransferFree ? self::AIRPORT_TRANSFER_PRICE : 0.0);
        $totalSavings = round($discountAmount + ($includeAirport && $isAirportTransferFree ? self::AIRPORT_TRANSFER_PRICE : 0.0), 2);

        $depositAmount = round($totalNet * self::DEPOSIT_PERCENTAGE, 2);
        $remainingBalance = round($totalNet - $depositAmount, 2);
        $amountToPayNow = ($paymentMode === 'deposit') ? $depositAmount : $totalNet;

        return [
            'subtotal'                  => round($subtotal, 2),
            'discount_rate'             => $discountRate,
            'discount_percent'          => (int)($discountRate * 100),
            'discount_amount'           => $discountAmount,
            'airport_transfer_included' => $includeAirport,
            'airport_transfer_price'    => $transferPrice,
            'airport_transfer_free'     => $isAirportTransferFree,
            'transfer_savings'          => $transferSavings,
            'total_net'                 => $totalNet,
            'deposit_amount'            => $depositAmount,
            'remaining_balance'         => $remainingBalance,
            'amount_to_pay_now'         => $amountToPayNow,
            'payment_mode'              => $paymentMode,
            'total_savings'             => $totalSavings,
            'pack_label'                => $packLabel,
            'next_tier_message'         => $nextTierMessage,
            'items_count'               => $validItemsCount
        ];
    }
}
