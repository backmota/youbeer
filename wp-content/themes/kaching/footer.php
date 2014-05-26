<?php
/**
 * The template for displaying the footer.
 *
 * @package WordPress
 * @subpackage tfbasedetails
 * @since tfbasedetails 1.0
 */
?>
</div>
<?php if ((get_option('tf_enable_footercta') == 'true') || (get_option('tf_enable_smicons') == 'true')) : ?>
<footer id="site-footer" role="contentinfo">
<?php if (get_option('tf_enable_footercta') == 'true') : ?>
    <div class="topfooter container">
        <?php
        get_sidebar('top-footer');
        ?>
        <div class="clearboth"></div> 
    </div>    
<?php endif; ?>
<?php if (get_option('tf_enable_smicons') != null) : ?>
    <div class="middlefooter container">
        <?php
        get_sidebar('middle-footer');
        ?>
        <div class="clearboth"></div> 
    </div>    
<?php endif; ?>
    <div class="container">
        <?php
        get_sidebar('footer');
        ?>
        <div class="clearboth"></div> 
    </div>
</footer>
<?php endif; ?>
<div class="clearboth"></div> 

<div class="clearboth"></div>
<?php
/* Always have wp_footer() just before the closing </body>
 * tag of your theme, or you will break many plugins, which
 * generally use this hook to reference JavaScript files.
 */
wp_footer();
?>
</body>
</html>