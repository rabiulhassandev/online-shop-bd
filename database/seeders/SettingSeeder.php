<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Seed default site settings.
     */
    public function run(): void
    {
        /** @var array<string, string|null> $settings */
        $settings = [
            'site_name' => 'কাতুয়া শার্ট',
            'site_logo' => null,
            'site_favicon' => null,
            'phone' => '01700000000',
            'email' => 'info@katuashirt.com',
            'address' => 'ঢাকা, বাংলাদেশ',
            'whatsapp' => '8801700000000',
            'facebook_url' => 'https://facebook.com/katuashirt',
            'delivery_charge' => '80',
            'cod_enabled' => '1',
            'bkash_enabled' => '1',
            'nagad_enabled' => '1',
            'maintenance_mode' => '0',
        ];

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }
}
