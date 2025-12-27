<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class EnvService
{
    /**
     * Update environment variables
     */
    public static function set(array $values): bool
    {
        $path = self::getEnvPath();

        if (!File::exists($path)) {
            return false;
        }

        $content = File::get($path);

        foreach ($values as $key => $value) {
            $content = self::setVariable($content, $key, $value);
        }

        return File::put($path, $content) !== false;
    }

    /**
     * Get environment variable directly from .env file
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $path = self::getEnvPath();

        if (!File::exists($path)) {
            return $default;
        }

        $lines = File::lines($path);

        foreach ($lines as $line) {
            $line = trim($line);

            // Skip comments and empty lines
            if (empty($line) || str_starts_with($line, '#')) {
                continue;
            }

            if (str_contains($line, '=')) {
                [$currentKey, $currentValue] = explode('=', $line, 2);

                if (trim($currentKey) === $key) {
                    return trim($currentValue);
                }
            }
        }

        return $default;
    }

    /**
     * Check if environment variable exists
     */
    public static function has(string $key): bool
    {
        return self::get($key) !== null;
    }

    /**
     * Remove environment variable
     */
    public static function remove(string $key): bool
    {
        $path = self::getEnvPath();

        if (!File::exists($path)) {
            return false;
        }

        $lines = File::lines($path);
        $updatedContent = '';
        $removed = false;

        foreach ($lines as $line) {
            if (!empty(trim($line)) && !str_starts_with(trim($line), '#')) {
                [$currentKey,] = explode('=', $line, 2);

                if (trim($currentKey) === $key) {
                    $removed = true;
                    continue; // Skip this line
                }
            }
            $updatedContent .= $line . "\n";
        }

        if ($removed) {
            return File::put($path, rtrim($updatedContent) . "\n") !== false;
        }

        return false;
    }

    /**
     * Get all environment variables as array
     */
    public static function all(): array
    {
        $path = self::getEnvPath();
        $variables = [];

        if (!File::exists($path)) {
            return $variables;
        }

        $lines = File::lines($path);

        foreach ($lines as $line) {
            $line = trim($line);

            if (empty($line) || str_starts_with($line, '#')) {
                continue;
            }

            if (str_contains($line, '=')) {
                [$key, $value] = explode('=', $line, 2);
                $variables[trim($key)] = trim($value);
            }
        }

        return $variables;
    }

    /**
     * Helper: Set or update a variable in content
     */
    private static function setVariable(string $content, string $key, mixed $value): string
    {
        $key = strtoupper(trim($key));
        $value = self::formatValue($value);

        // Pattern to find existing key
        $pattern = "/^{$key}=.*/m";

        if (preg_match($pattern, $content)) {
            // Update existing
            return preg_replace($pattern, "{$key}={$value}", $content);
        }

        // Add new at the end
        return rtrim($content) . "\n{$key}={$value}\n";
    }

    /**
     * Helper: Format value for .env file
     */
    private static function formatValue(mixed $value): string
    {
        $value = (string) $value;

        // Remove surrounding quotes if present
        $value = trim($value, '"\'');

        // Add quotes if needed (spaces, special chars, or empty)
        if (preg_match('/[\s#"\']/', $value) || empty($value)) {
            return '"' . addcslashes($value, '"\\') . '"';
        }

        return $value;
    }

    /**
     * Helper: Get .env file path
     */
    private static function getEnvPath(): string
    {
        return base_path('.env');
    }
}
