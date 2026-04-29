<?php
/**
 * Page Template
 * 
 * @package Websiteku
 */

get_header();
?>

<main class="page-content" style="padding-top: 100px; min-height: 60vh;">
    <div class="container">
        <?php while (have_posts()):
            the_post(); ?>
            <article id="page-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="page-header" style="margin-bottom: var(--spacing-xl); text-align: center;">
                    <h1>
                        <?php the_title(); ?>
                    </h1>
                </header>

                <div class="page-body" style="max-width: 800px; margin: 0 auto;">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>