<?php

$block = $propertiesData['content']['content']['post'] ?? false;


if ( have_posts() ) :

    ?>
    <div class="products-container">

        <div class="results-wrapper">

            <div class="results">
                
            </div>

            <div class="ordering"></div>

        </div>
        
        <ul class="products"> 
        <?php while ( have_posts() ) : the_post(); ?>

            <li class="product">
            <?php echo \Breakdance\Render\renderGlobalBlock($block); ?>
            </li>

        <?php endwhile; ?>
        </ul>


        
        <div class="woocommerce-pagination custom-pagination">
        
        <?php
        echo paginate_links( array(
            'type'      => 'list',
            'prev_text' => '&larr;',
            'next_text' => '&rarr;',
        ) );
        ?>
        </div>

    </div>
    <?php 

else :
    echo __( 'Nem található termék.' );
endif;
