<?php
/**
 * The template for displaying all single posts
 *
 * @package AITSC_Pro_Theme
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

// Calculate read time
$content = get_post_field('post_content', get_the_ID());
$word_count = str_word_count(strip_tags($content));
$read_time = ceil($word_count / 200);

// Get Author Data
$author_id = get_the_author_meta('ID');
$author_name = get_the_author();
?>

<main class="layout-container flex h-full grow flex-col bg-white dark:bg-slate-900">
    <div class="max-w-4xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8 md:py-12">
        <div class="layout-content-container flex flex-col flex-1">

            <!-- Breadcrumbs -->
            <div class="flex flex-wrap gap-2 mb-6">
                <a class="text-slate-500 hover:text-cyan-600 text-sm font-medium leading-normal transition-colors"
                    href="<?php echo home_url(); ?>">Home</a>
                <span class="text-slate-500 text-sm font-medium leading-normal">/</span>
                <a class="text-slate-500 hover:text-cyan-600 text-sm font-medium leading-normal transition-colors"
                    href="<?php echo home_url('/blog'); ?>">Blog</a>
                <span class="text-slate-500 text-sm font-medium leading-normal">/</span>
                <span
                    class="text-slate-900 dark:text-white text-sm font-medium leading-normal truncate max-w-[200px]"><?php the_title(); ?></span>
            </div>

            <?php while (have_posts()):
                the_post(); ?>

                <!-- Article Header -->
                <div class="mb-8">
                    <h1
                        class="text-slate-900 dark:text-white tracking-tight text-3xl md:text-4xl font-bold leading-tight mb-4">
                        <?php the_title(); ?></h1>
                    <p class="text-slate-500 dark:text-slate-400 text-sm font-normal leading-normal">
                        By <?php echo $author_name; ?> • Published on <?php echo get_the_date('F j, Y'); ?> •
                        <?php echo $read_time; ?> min read
                    </p>
                </div>

                <!-- HeaderImage -->
                <?php if (has_post_thumbnail()): ?>
                    <div class="mb-8">
                        <div class="w-full bg-center bg-no-repeat bg-cover flex flex-col justify-end overflow-hidden rounded-xl min-h-[300px] md:min-h-[400px]"
                            style="background-image: url('<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full'); ?>');">
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Main Content and Social Share -->
                <div class="flex flex-col md:flex-row gap-8 lg:gap-12">

                    <!-- Social Share Bar (Sticky) -->
                    <aside class="md:w-16 md:sticky md:top-24 h-fit">
                        <div class="flex md:flex-col gap-4 items-center">
                            <p class="hidden md:block text-xs font-bold uppercase text-slate-400 tracking-wider">SHARE</p>
                            <div class="flex md:flex-col gap-4">
                                <!-- LinkedIn -->
                                <a aria-label="Share on LinkedIn" target="_blank"
                                    href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode(get_permalink()); ?>"
                                    class="flex items-center justify-center size-10 rounded-full bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 transition-colors">
                                    <svg class="size-5 text-slate-600 dark:text-slate-400" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.225 0z">
                                        </path>
                                    </svg>
                                </a>
                                <!-- Twitter -->
                                <a aria-label="Share on Twitter" target="_blank"
                                    href="https://twitter.com/intent/tweet?text=<?php echo urlencode(get_the_title()); ?>&url=<?php echo urlencode(get_permalink()); ?>"
                                    class="flex items-center justify-center size-10 rounded-full bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 transition-colors">
                                    <svg class="size-5 text-slate-600 dark:text-slate-400" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.223.085c.645 1.956 2.52 3.374 4.738 3.414A9.87 9.87 0 010 17.538a13.94 13.94 0 007.548 2.212c9.142 0 14.307-7.443 14.307-14.03 0-.213-.005-.426-.015-.637.961-.689 1.79-1.56 2.459-2.544z">
                                        </path>
                                    </svg>
                                </a>
                                <!-- Email -->
                                <a aria-label="Share via Email"
                                    href="mailto:?subject=<?php echo urlencode(get_the_title()); ?>&body=<?php echo urlencode(get_permalink()); ?>"
                                    class="flex items-center justify-center size-10 rounded-full bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 transition-colors">
                                    <span
                                        class="material-symbols-outlined text-slate-600 dark:text-slate-400 text-xl">mail</span>
                                </a>
                            </div>
                        </div>
                    </aside>

                    <!-- Main Content Area -->
                    <article class="flex-1 prose prose-lg dark:prose-invert max-w-none 
                        prose-p:text-slate-600 dark:prose-p:text-slate-300 
                        prose-headings:text-slate-900 dark:prose-headings:text-white 
                        prose-a:text-cyan-600 hover:prose-a:underline 
                        prose-strong:text-slate-900 dark:prose-strong:text-white 
                        prose-blockquote:border-l-cyan-600">

                        <?php the_content(); ?>

                    </article>
                </div>

            <?php endwhile; ?>

            <!-- Related Articles Section -->
            <div class="mt-16 pt-12 border-t border-slate-200 dark:border-slate-800">
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-8">Related Articles</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php
                    // Related Posts Query
                    $related = new WP_Query(array(
                        'post_type' => 'post',
                        'posts_per_page' => 3,
                        'post__not_in' => array(get_the_ID()),
                        'orderby' => 'rand' // Random for now, or use category
                    ));

                    if ($related->have_posts()):
                        while ($related->have_posts()):
                            $related->the_post();
                            $rel_content = get_post_field('post_content', get_the_ID());
                            $rel_word_count = str_word_count(strip_tags($rel_content));
                            $rel_read_time = ceil($rel_word_count / 200);
                            ?>
                            <div class="flex flex-col group">
                                <a class="block overflow-hidden rounded-xl mb-4" href="<?php the_permalink(); ?>">
                                    <?php if (has_post_thumbnail()): ?>
                                        <img class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300"
                                            src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'medium_large'); ?>"
                                            alt="<?php the_title(); ?>">
                                    <?php else: ?>
                                        <div class="w-full h-48 bg-slate-200 flex items-center justify-center text-slate-400">No
                                            Image</div>
                                    <?php endif; ?>
                                </a>
                                <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-2 leading-snug">
                                    <a class="hover:text-cyan-600 transition-colors"
                                        href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                                <p class="text-sm text-slate-500 debug-date"><?php echo get_the_date('M j, Y'); ?> •
                                    <?php echo $rel_read_time; ?> min read</p>
                            </div>
                            <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
            </div>

        </div>
    </div>
</main>

<?php
get_footer();
