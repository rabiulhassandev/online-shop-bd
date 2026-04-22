<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    /**
     * Only admins may update settings.
     */
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    /**
     * @return array<string, list<string>>
     */
    public function rules(): array
    {
        return [
            'site_name' => ['nullable', 'string', 'max:255'],
            'site_logo' => ['nullable', 'image', 'max:1024'],
            'site_favicon' => ['nullable', 'image', 'max:256'],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string', 'max:500'],
            'about_us' => ['nullable', 'string', 'max:10000'],
            'whatsapp' => ['nullable', 'string', 'max:20'],
            'facebook_url' => ['nullable', 'url', 'max:500'],
            'instagram_url' => ['nullable', 'url', 'max:500'],
            'delivery_charge' => ['nullable', 'numeric', 'min:0'],
            'cod_enabled' => ['nullable', 'boolean'],
            'bkash_enabled' => ['nullable', 'boolean'],
            'nagad_enabled' => ['nullable', 'boolean'],
            'maintenance_mode' => ['nullable', 'boolean'],
        ];
    }
}
