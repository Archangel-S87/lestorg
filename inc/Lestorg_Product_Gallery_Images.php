<?php

/*
 * Создаёт массив из прекреплённых изображений к товару
 */

class Lestorg_Product_Gallery_Images
{
    /**
     * @var WC_Product
     */
    private $product;

    /**
     * @var array
     */
    private $images_id = [];

    /**
     * Хранит сформированый массив изображений
     *
     * @var array
     */
    private $images = [];

    /**
     * Размеры изображений для галереи
     *
     * @var array
     */
    private $sizes = [
        'thumbnail',
        'medium',
        'large',
        'full'
    ];

    public function __construct(WC_Product $product, $sizes = [], $add_thumbnail = true)
    {
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

    public function get_html() {
        if (!$this->images) return;
        wc_get_template('single-product/product-gallery.php', [
            'images' => $this->images
        ]);
    }
}
