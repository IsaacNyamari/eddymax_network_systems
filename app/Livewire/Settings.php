<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\EnvService;
use Illuminate\Support\Facades\Artisan;
use Livewire\Attributes\Validate;

class Settings extends Component
{
    // General Settings
    #[Validate("string|required|min:1")]
    public $app_name;
    
    #[Validate("string|required|timezone")]
    public $app_timezone;
    
    #[Validate("string|required|in:en,fr,es,de,sw")]
    public $app_locale;
    
    #[Validate("string|required|in:local,production,staging,testing")]
    public $app_env;
    
    #[Validate("boolean")]
    public $app_debug = false;

    // Social Media
    #[Validate("nullable|url")]
    public $facebook;
    
    #[Validate("nullable|string|min:1")]
    public $phone;
    
    #[Validate("nullable|url")]
    public $instagram;
    
    #[Validate("nullable|url")]
    public $twitter;
    
    #[Validate("nullable|string")]
    public $location;
    
    #[Validate("required|email")]
    public $support_email;

    // Mail Settings
    #[Validate("required|in:smtp,mailgun,ses,postmark,log,array,sendmail")]
    public $mail_mailer;

    #[Validate("required|string")]
    public $mail_host;

    #[Validate("required|numeric")]
    public $mail_port;

    #[Validate("required|email")]
    public $mail_username;

    #[Validate("nullable|string")]
    public $mail_password;

    #[Validate("nullable|in:tls,ssl,null")]
    public $mail_encryption;

    #[Validate("required|email")]
    public $mail_from_address;

    #[Validate("required|string")]
    public $mail_from_name;

    // Paystack Settings
    #[Validate("required|in:test,live")]
    public $paystack_mode;

    #[Validate("required|string")]
    public $paystack_public_key;
    
    #[Validate("nullable|string")]
    public $paystack_secret_key;

    #[Validate("required|url")]
    public $paystack_payment_url;

    public function mount()
    {
        $this->loadSettings();
    }

    private function loadSettings()
    {
        $envVars = EnvService::all();

        // General Settings
        $this->app_name = $this->cleanValue($envVars['APP_NAME'] ?? 'Laravel');
        $this->app_timezone = $this->cleanValue($envVars['APP_TIMEZONE'] ?? 'UTC');
        $this->app_locale = $this->cleanValue($envVars['APP_LOCALE'] ?? 'en');
        $this->app_env = $this->cleanValue($envVars['APP_ENV'] ?? 'local');
        $this->app_debug = filter_var($this->cleanValue($envVars['APP_DEBUG'] ?? 'false'), FILTER_VALIDATE_BOOLEAN);

        // Social Media
        $this->facebook = $this->cleanValue($envVars['FACEBOOK_LINK'] ?? '');
        $this->phone = $this->cleanValue($envVars['PHONE'] ?? '');
        $this->instagram = $this->cleanValue($envVars['INSTAGRAM_LINK'] ?? '');
        $this->twitter = $this->cleanValue($envVars['X_LINK'] ?? '');
        $this->location = $this->cleanValue($envVars['LOCATION'] ?? '');
        $this->support_email = $this->cleanValue($envVars['SUPPORT_EMAIL'] ?? 'support@example.com');

        // Mail Settings
        $this->mail_mailer = $this->cleanValue($envVars['MAIL_MAILER'] ?? 'smtp');
        $this->mail_host = $this->cleanValue($envVars['MAIL_HOST'] ?? 'smtp.mailtrap.io');
        $this->mail_port = $this->cleanValue($envVars['MAIL_PORT'] ?? '587');
        $this->mail_username = $this->cleanValue($envVars['MAIL_USERNAME'] ?? '');
        $this->mail_password = ''; // Don't load password for security
        $this->mail_encryption = $this->cleanValue($envVars['MAIL_ENCRYPTION'] ?? 'tls');
        $this->mail_from_address = $this->cleanValue($envVars['MAIL_FROM_ADDRESS'] ?? 'noreply@example.com');
        $this->mail_from_name = $this->cleanValue($envVars['MAIL_FROM_NAME'] ?? 'Example');

        // Paystack Settings
        $this->paystack_mode = $this->cleanValue($envVars['PAYSTACK_MODE'] ?? 'live');
        $this->paystack_public_key = $this->cleanValue($envVars['PAYSTACK_PUBLIC_KEY'] ?? '');
        $this->paystack_secret_key = ''; // Don't load secret key
        $this->paystack_payment_url = $this->cleanValue($envVars['PAYSTACK_PAYMENT_URL'] ?? 'https://api.paystack.co');
    }

    private function cleanValue($value)
    {
        if (!is_string($value)) {
            return $value;
        }

        $value = trim($value);
        
        // Remove inline comments
        if (strpos($value, '#') !== false) {
            $parts = explode('#', $value);
            $value = trim($parts[0]);
        }

        // Remove quotes
        $value = trim($value, ' "\'');

        return $value;
    }

    public function saveSiteSetting()
    {
        $this->validate();
        
        // Validate timezone is correct
        if (!in_array($this->app_timezone, timezone_identifiers_list())) {
            $this->addError('app_timezone', 'Invalid timezone. Use format like: Africa/Nairobi');
            return;
        }

        $envData = [
            // General Settings
            'APP_NAME' => $this->app_name,
            'APP_TIMEZONE' => $this->app_timezone,
            'APP_LOCALE' => $this->app_locale,
            'APP_ENV' => $this->app_env,
            'APP_DEBUG' => $this->app_debug ? 'true' : 'false',

            // Social Media
            'FACEBOOK_LINK' => $this->facebook,
            'PHONE' => $this->phone,
            'INSTAGRAM_LINK' => $this->instagram,
            'X_LINK' => $this->twitter,
            'LOCATION' => $this->location,
            'SUPPORT_EMAIL' => $this->support_email,

            // Mail Settings
            'MAIL_MAILER' => $this->mail_mailer,
            'MAIL_HOST' => $this->mail_host,
            'MAIL_PORT' => $this->mail_port,
            'MAIL_USERNAME' => $this->mail_username,
            'MAIL_ENCRYPTION' => $this->mail_encryption,
            'MAIL_FROM_ADDRESS' => $this->mail_from_address,
            'MAIL_FROM_NAME' => $this->mail_from_name,

            // Paystack Settings
            'PAYSTACK_MODE' => $this->paystack_mode,
            'PAYSTACK_PUBLIC_KEY' => $this->paystack_public_key,
            'PAYSTACK_PAYMENT_URL' => $this->paystack_payment_url,
        ];

        // Only update password if provided
        if (!empty($this->mail_password)) {
            $envData['MAIL_PASSWORD'] = $this->mail_password;
        }

        // Only update secret key if provided
        if (!empty($this->paystack_secret_key)) {
            $envData['PAYSTACK_SECRET_KEY'] = $this->paystack_secret_key;
        }

        // Update .env
        EnvService::set($envData);

        // Clear config cache to apply changes
        if (function_exists('artisan')) {
            Artisan::call('config:clear');
        }

        session()->flash('success', 'Settings updated successfully!');
        
        // Reload settings to show updated values
        $this->loadSettings();
    }

    public function getTimezonesProperty()
    {
        return collect(timezone_identifiers_list())
            ->groupBy(function($tz) {
                return explode('/', $tz)[0] ?? 'Other';
            })
            ->mapWithKeys(function($group, $continent) {
                return [$continent => $group->sort()->values()->toArray()];
            })
            ->toArray();
    }

    public function getLocalesProperty()
    {
        return [
            'en' => 'English',
            'fr' => 'French',
            'es' => 'Spanish',
            'de' => 'German',
            'sw' => 'Swahili',
        ];
    }

    public function render()
    {
        return view('livewire.settings', [
            'timezones' => $this->timezones,
            'locales' => $this->locales,
        ]);
    }
}