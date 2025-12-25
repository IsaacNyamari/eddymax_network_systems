<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class OrderStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $status;
    public $action;
    public $products = [];

    public function __construct(Order $order, string $status, string $action)
    {
        $this->order = $order;
        $this->status = $status;
        $this->action = $action;

        // Decode JSON products and prepare with base64 images
        $this->prepareProducts();
    }

    public function build()
    {
        return $this->subject("Order #{$this->order->order_number} Status: {$this->status}")
            ->view('emails.order-status-updated')
            ->from(config('mail.from.address'), config('mail.from.name'));
    }

    /**
     * Prepare products with base64 encoded images
     */
    protected function prepareProducts()
    {
        try {
            // Decode the JSON products string
            $productsData = json_decode($this->order->products, true);

            if (!is_array($productsData) || empty($productsData)) {
                return;
            }

            foreach ($productsData as $productId => $product) {
                $imageData = null;
                $mimeType = 'image/jpeg';

                // Get base64 encoded image
                if (!empty($product['image']) && Storage::exists($product['image'])) {
                    try {
                        $imagePath = Storage::path($product['image']);
                        $imageData = base64_encode(file_get_contents($imagePath));
                        $mimeType = $this->getMimeType($imagePath);
                    } catch (\Exception $e) {
                        Log::error('Failed to encode image: ' . $e->getMessage());
                        $imageData = null;
                    }
                }

                // Prepare product for email
                $this->products[] = [
                    'id' => $productId,
                    'name' => $product['name'] ?? 'Product',
                    'price' => $product['price'] ?? 0,
                    'quantity' => $product['quantity'] ?? 1,
                    'description' => $product['description'] ?? '',
                    'image_data' => $imageData,
                    'mime_type' => $mimeType,
                    'has_image' => !empty($imageData),
                ];
            }
        } catch (\Exception $e) {
            Log::error('Failed to prepare products: ' . $e->getMessage());
            $this->products = [];
        }
    }

    /**
     * Get MIME type from file path
     */
    protected function getMimeType($filePath)
    {
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

        $mimeTypes = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
            'svg' => 'image/svg+xml',
            'bmp' => 'image/bmp',
        ];

        return $mimeTypes[$extension] ?? mime_content_type($filePath) ?: 'image/jpeg';
    }
}
