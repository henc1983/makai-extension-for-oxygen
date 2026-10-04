<?php


$block_grid = $propertiesData['content']['content']['grid'] ?? false;
$block_row = $propertiesData['content']['content']['row'] ?? false;
$layout = get_query_var( 'layout' );

$rendered_block = $layout == 'grid' ? $block_grid : $block_row;

$id = "mex-view-switch-radio-layout";


if ( have_posts() ) :
    
    ?>
    <div class="products-container <?php echo $layout; ?>-layout">

        <div class="results-wrapper">

            <span class="results">Nehany termek megjelenitve</span>

            <div id="mex-view-layout" class="mex-view-layout form-wrapper">
                <form method="post" class="form" action="" id="mex-view-switch">
                    <div class="radio-section">
                        <div class="radio-options">
                            <label class="radio-btn <?php echo $layout == "grid" ? "checked" : "" ; ?>">
                                <input type="radio" name="mex-layout" value="grid" <?php echo $layout == "grid" ? "checked" : "" ; ?> />
                                <i class="far fa-grid"></i>
                            </label>
                            <label class="radio-btn <?php echo $layout == "row" ? "checked" : "" ; ?>">
                                <input type="radio" name="mex-layout" value="row" <?php echo $layout == "row" ? "checked" : "" ; ?> />
                                <i class="far fa-bars"></i>
                            </label>
                        </div>
                    </div>
                </form>
            </div>

            <span class="vertical-divider"></span>
            <span class="ordering"></span>

        </div>
        
        <ul class="products"> 
        <?php while ( have_posts() ) : the_post(); ?>

            <li class="product">
            <?php echo \Breakdance\Render\renderGlobalBlock($rendered_block); ?>
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
