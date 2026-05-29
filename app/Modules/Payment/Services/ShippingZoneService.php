<?php

declare(strict_types=1);

namespace App\Modules\Payment\Services;

use App\Modules\Payment\Models\ShippingZone;

class ShippingZoneService
{
    public function calculateShippingCost(string $zipCode): float
    {
        $zone = $this->findZoneByZipCode($zipCode);
        
        if (!$zone) {
            return 200.00; // Default fallback rate
        }
        
        return (float) $zone->flat_rate;
    }

    public function getEstimatedDays(string $zipCode): int
    {
        $zone = $this->findZoneByZipCode($zipCode);
        return $zone?->estimated_days ?? 7;
    }

    public function getAllZones()
    {
        return ShippingZone::all();
    }

    private function findZoneByZipCode(string $zipCode): ?ShippingZone
    {
        $zones = ShippingZone::all();
        
        foreach ($zones as $zone) {
            $patterns = explode('|', $zone->zip_code_pattern);
            foreach ($patterns as $pattern) {
                $regex = '/^' . str_replace('x', '\d', $pattern) . '$/';
                if (preg_match($regex, $zipCode)) {
                    return $zone;
                }
            }
        }
        
        return null;
    }
}