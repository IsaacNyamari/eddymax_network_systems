<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\EnvService;
use Livewire\Attributes\Validate;

class Settings extends Component
{
    #[Validate("string|required|min:1")]
    public $app_name;

    #[Validate("string|required|in:smtp,mailgun,ses,postmark,log,array,sendmail")]
    public $mail_mailer;

    #[Validate("string|required")]
    public $mail_host;

    #[Validate("string|required|numeric")]
    public $mail_port;

    #[Validate("string|required|email")]
    public $mail_username;

    #[Validate("string|nullable")]
    public $mail_password;

    #[Validate("string|nullable|in:tls,ssl")]
    public $mail_encryption;

    #[Validate("string|required|email")]
    public $mail_from_address;

    #[Validate("string|required")]
    public $mail_from_name;

    #[Validate("string|required|in:test,live")]
    public $paystack_mode;

    #[Validate("string|required")]
    public $paystack_public_key;

    #[Validate("string|required|url")]
    public $paystack_payment_url;

    public function mount()
    {
        // Load only non-sensitive values
        $envVars = EnvService::all();

        // Extract values and remove comments
        $this->app_name = $this->cleanValue($envVars['APP_NAME'] ?? '');
        $this->mail_mailer = $this->cleanValue($envVars['MAIL_MAILER'] ?? 'smtp');
        $this->mail_host = $this->cleanValue($envVars['MAIL_HOST'] ?? '');
        $this->mail_port = $this->cleanValue($envVars['MAIL_PORT'] ?? '587');
        $this->mail_username = $this->cleanValue($envVars['MAIL_USERNAME'] ?? '');
        $this->mail_password = ''; // Don't load password for security
        $this->mail_encryption = $this->cleanValue($envVars['MAIL_ENCRYPTION'] ?? 'tls');
        $this->mail_from_address = $this->cleanValue($envVars['MAIL_FROM_ADDRESS'] ?? '');
        $this->mail_from_name = $this->cleanValue($envVars['MAIL_FROM_NAME'] ?? '');
        $this->paystack_mode = $this->cleanValue($envVars['PAYSTACK_MODE'] ?? 'live');
        $this->paystack_public_key = $this->cleanValue($envVars['PAYSTACK_PUBLIC_KEY'] ?? '');
        $this->paystack_payment_url = $this->cleanValue($envVars['PAYSTACK_PAYMENT_URL'] ?? '');
    }

    // Remove inline comments from values
    private function cleanValue($value)
    {
        if (!is_string($value)) {
            return '';
        }
        
        if (strpos($value, '#') !== false) {
            $parts = explode('#', $value);
            $value = trim($parts[0]);
        }
        
        return trim($value, ' "\'');
    }

    public function saveSiteSetting()
    {
        $this->validate();
        
        // Only update password if it's not empty (to avoid overwriting with empty)
        $envData = [
            'APP_NAME' => $this->app_name,
            'MAIL_MAILER' => $this->mail_mailer,
            'MAIL_HOST' => $this->mail_host,
            'MAIL_PORT' => $this->mail_port,
            'MAIL_USERNAME' => $this->mail_username,
            'MAIL_ENCRYPTION' => $this->mail_encryption,
            'MAIL_FROM_ADDRESS' => $this->mail_from_address,
            'MAIL_FROM_NAME' => $this->mail_from_name,
            'PAYSTACK_MODE' => $this->paystack_mode,
            'PAYSTACK_PUBLIC_KEY' => $this->paystack_public_key,
            'PAYSTACK_PAYMENT_URL' => $this->paystack_payment_url,
        ];
        
        // Only add password if provided
        if (!empty($this->mail_password)) {
            $envData['MAIL_PASSWORD'] = $this->mail_password;
        }
        
        // Update .env with cleaned values
        EnvService::set($envData);

        session()->flash('message', 'Settings updated successfully!');
    }

    public function render()
    {
        return view('livewire.settings');
    }
}