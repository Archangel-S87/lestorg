<?php

/*
 * Создаёт массив из прекреплённых изображений к товару
 */

class WC_LT_Product_Gallery_Images
{
    private $product;

    private $images_id = [];

    // Хранит сформированый массив изображений
    private $images = [];

    // Размеры изображений для галереи
    private $sizes = [
        'thumbnail',
        'medium',
        'large',
        'full'
    ];

    public function __construct($product, $sizes = [], $add_thumbnail = true)
    {
        if (!$product instanceof WC_Product) return;

        $this->product = $product;

        if ($sizes) $this->sizes = $sizes;

        if ($add_thumbnail) {
            $attachment_id = $this->product->get_image_id();
            if ($attachment_id) {
                $this->images_id[] = (int) $attachment_id;
            }
        }

        $attachment_ids = $this->product->get_gallery_image_ids();
        $this->images_id = array_merge($this->images_id, $attachment_ids);
    }

    public function get_images(): array
    {
        foreach ($this->images_id as $id) {

            if (!$sizes = $this->get_images_sizes($id)) continue;

            if (!$alt = get_post_meta($id, '_wp_attachment_image_alt', true)) {
                $alt = $this->product->get_title();
            }

            $this->images[$id] = [
                'sizes' => $sizes,
                'alt' => $alt
            ];
        }

        return $this->images;
    }

    private function get_images_sizes($image_id): array
    {
        $sizes = [];
        foreach ($this->sizes as $size) {
            $url = wp_get_attachment_image_url($image_id, $size);
            if (!$url) {
                $url = wp_get_original_image_path($image_id);
                if (!$url) return [];
            }
            $sizes[$size] = $url;
        }
        return $sizes;
    }

}
