<?php

require_once 'Lestorg_Single.php';

class Lestorg_Single_Simple extends Lestorg_Single
{
    use Lestorg_Instance;

    public function run()
    {
        parent::run();

        $this->add_action('woocommerce_single_product_summary', [$this, 'get_the_preview']);
    }

    public function get_the_preview() {
        ?>
        <div class="product-grid">
            <div class="product-grid__col">
                <?php $this->get_the_gallery(); ?>
            </div>
            <div class="product-grid__col">

                <div class="product-info box">
                    <div class="product-info__wrap">
                        <div class="product-info__main">
                            <?php $this->get_the_info_table(); ?>
                        </div>

                        <?php $this->get_the_share(); ?>

                    </div>
                </div>

            </div>
        </div>
        <?php
    }
}
