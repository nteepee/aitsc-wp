<?php
/**
 * Template Part: Overview Section
 * Alternating Zig-Zag Layout: Each h3 + content paired with image, alternating left/right
 */

$overview_text = get_field('overview_text');
if (!$overview_text) {
    return;
}

// Prepare fallback image URL (will be uploaded, so no URL encoding needed)
$fallback_image_url = content_url('/ATISC CONTENT/AITSC 2/Graphics/Untitled-6.png');
?>
<!-- OVERVIEW SECTION -->
<section class="py-16 bg-black">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

		<?php
		global $post;
		if ($post->post_name === 'fleet-safe-pro'):
			$overview_image = get_template_directory_uri() . '/assets/images/fleet-safe-overview.png';
			?>
            <!-- Fleet Safe Pro 50/50 Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Left: Text -->
                <div class="text-left">
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-600/10 text-blue-400 text-xs font-bold uppercase tracking-wider mb-6">
                        <span class="material-symbols-outlined text-sm">description</span> Product Overview
                    </div>

                    <?php if (get_field('overview_title')): ?>
                        <h2 class="text-3xl md:text-5xl font-bold text-white mb-8 leading-tight">
                            <?php echo esc_html(get_field('overview_title')); ?>
                        </h2>
                    <?php endif; ?>

                    <div class="text-slate-300 leading-relaxed text-lg space-y-6">
                        <?php echo wp_kses_post(wpautop($overview_text)); ?>
                    </div>
                </div>

                <!-- Right: Image -->
                <div class="relative">
                    <div
                        class="absolute -inset-4 bg-gradient-to-r from-blue-500/20 to-purple-500/20 rounded-3xl blur-2xl opacity-50">
                    </div>
                    <img src="<?php echo esc_url($overview_image); ?>" alt="Fleet Safe Pro Overview"
                        class="relative rounded-2xl shadow-2xl border border-slate-700/50 w-full h-auto object-cover transform hover:scale-[1.02] transition-transform duration-500">
                </div>
            </div>

		<?php else: ?>
            <!-- Solution 2 + 6 Hybrid for All Solution Pages -->

			<?php
			// Solution 6: Stats Strip (before overview)
			?>
			<div class="aitsc-stats-strip mb-16">
				<div class="grid grid-cols-3 gap-8 text-center">
					<div class="aitsc-stat-item">
						<span class="aitsc-stat-number">100%</span>
						<span class="aitsc-stat-label">Compliance Rate</span>
					</div>
					<div class="aitsc-stat-item">
						<span class="aitsc-stat-number">12mo</span>
						<span class="aitsc-stat-label">Warranty Coverage</span>
					</div>
					<div class="aitsc-stat-item">
						<span class="aitsc-stat-number">50+</span>
						<span class="aitsc-stat-label">Trusted Fleets</span>
					</div>
				</div>
			</div>

			<style>
			.aitsc-stats-strip {
				padding: 2rem 0;
				border-top: 1px solid rgba(255,255,255,0.1);
				border-bottom: 1px solid rgba(255,255,255,0.1);
			}
			.aitsc-stat-item {
				display: flex;
				flex-direction: column;
				align-items: center;
				gap: 0.5rem;
			}
			.aitsc-stat-number {
				font-size: 2.5rem;
				font-weight: 700;
				color: #0891b2;
				line-height: 1;
			}
			.aitsc-stat-label {
				font-size: 0.875rem;
				color: #94a3b8;
				text-transform: uppercase;
				letter-spacing: 0.05em;
			}
			</style>

            <!-- Solution 2: Alternating Zig-Zag Layout - Each h3 paired with image -->
            <div class="aitsc-overview-zigzag">
				<?php
				// Get ACF gallery for images
				$acf_gallery = get_field('gallery', get_the_ID());

				// Parse HTML to extract h3 sections
				preg_match_all('/<h3[^>]*>.*?<\/h3>(.*?)(?=<h3[^>]*>|$)/s', $overview_text, $h3_matches, PREG_SET_ORDER);

				// If no h3s found, try paragraphs
				if (empty($h3_matches)) {
					preg_match_all('/<p[^>]*>.*?<\/p>(\s*<[^>]+>.*?<\/[^>]+>\s*)*/s', $overview_text, $p_matches, PREG_SET_ORDER);
				}

				$section_index = 0;

				// Loop through each h3 section
				foreach ($h3_matches as $match):
					$section_index++;
					$h3_content = $match[0]; // Full h3 + following content
					$is_even = ($section_index % 2 === 0);

					// Get image for this section (cycle through gallery or use fallback)
					if ($acf_gallery && is_array($acf_gallery) && !empty($acf_gallery)) {
						$img_index = ($section_index - 1) % count($acf_gallery);
						if (is_numeric($acf_gallery[$img_index])) {
							$image_url = wp_get_attachment_url($acf_gallery[$img_index]);
						} elseif (is_array($acf_gallery[$img_index])) {
							$image_url = $acf_gallery[$img_index]['url'] ?? $fallback_image_url;
						} else {
							$image_url = $fallback_image_url;
						}
					} else {
						$image_url = $fallback_image_url;
					}
					?>
					<div class="aitsc-overview-row <?php echo $is_even ? 'aitsc-overview-row--reverse' : ''; ?> mb-16">
						<!-- Content Side -->
						<div class="aitsc-overview-content">
							<div class="text-slate-300 leading-relaxed">
								<?php echo wp_kses_post($h3_content); ?>
							</div>
						</div>

						<!-- Image Side -->
						<div class="aitsc-overview-image">
							<div class="relative">
								<div class="absolute -inset-4 bg-gradient-to-br <?php echo $is_even ? 'from-purple-500/10 to-pink-600/10' : 'from-cyan-500/10 to-blue-600/10'; ?> rounded-3xl blur-2xl opacity-50"></div>

								<img src="<?php echo esc_url($image_url); ?>"
									alt="<?php echo esc_attr(get_the_title()); ?> - Feature <?php echo esc_html($section_index); ?>"
									class="relative rounded-2xl shadow-2xl border border-slate-700/50 w-full h-auto object-cover transform hover:scale-[1.02] transition-transform duration-500"
									loading="<?php echo $section_index <= 2 ? 'eager' : 'lazy'; ?>">
							</div>
						</div>
					</div>
					<?php
				endforeach;

				// If no h3s were found, fall back to paragraphs
				if (empty($h3_matches) && !empty($p_matches)):
					foreach ($p_matches as $match):
						$section_index++;
						$is_even = ($section_index % 2 === 0);
						$p_content = $match[0];

						// Get image for this section
						if ($acf_gallery && is_array($acf_gallery) && !empty($acf_gallery)) {
							$img_index = ($section_index - 1) % count($acf_gallery);
							if (is_numeric($acf_gallery[$img_index])) {
								$image_url = wp_get_attachment_url($acf_gallery[$img_index]);
							} elseif (is_array($acf_gallery[$img_index])) {
								$image_url = $acf_gallery[$img_index]['url'] ?? $fallback_image_url;
							} else {
								$image_url = $fallback_image_url;
							}
						} else {
							$image_url = $fallback_image_url;
						}
						?>
						<div class="aitsc-overview-row <?php echo $is_even ? 'aitsc-overview-row--reverse' : ''; ?> mb-16">
							<!-- Content Side -->
							<div class="aitsc-overview-content">
								<div class="text-slate-300 leading-relaxed">
									<?php echo wp_kses_post($p_content); ?>
								</div>
							</div>

							<!-- Image Side -->
							<div class="aitsc-overview-image">
								<div class="relative">
									<div class="absolute -inset-4 bg-gradient-to-br <?php echo $is_even ? 'from-purple-500/10 to-pink-600/10' : 'from-cyan-500/10 to-blue-600/10'; ?> rounded-3xl blur-2xl opacity-50"></div>

									<img src="<?php echo esc_url($image_url); ?>"
										alt="<?php echo esc_attr(get_the_title()); ?> - Feature <?php echo esc_html($section_index); ?>"
										class="relative rounded-2xl shadow-2xl border border-slate-700/50 w-full h-auto object-cover transform hover:scale-[1.02] transition-transform duration-500"
										loading="lazy">
								</div>
							</div>
						</div>
						<?php
					endforeach;
				endif;
				?>
			</div>

			<style>
			.aitsc-overview-row {
				display: grid;
				grid-template-columns: 1fr 1fr;
				gap: 3rem;
				align-items: center;
			}

			.aitsc-overview-row--reverse {
				direction: rtl;
			}

			.aitsc-overview-row--reverse > * {
				direction: ltr;
			}

			.aitsc-overview-content h3 {
				color: #0f172a;
				font-size: 1.5rem;
				font-weight: 600;
				margin-bottom: 1rem;
				line-height: 1.3;
			}

			.aitsc-overview-content h2 {
				color: #1e293b;
				font-size: 2rem;
				font-weight: 700;
				margin-bottom: 1rem;
				line-height: 1.2;
			}

			.aitsc-overview-content p {
				color: #475569;
				margin-bottom: 0.75rem;
			}

			.aitsc-overview-content li {
				color: #64748b;
				margin-bottom: 0.5rem;
			}

			.aitsc-overview-content td {
				color: #64748b;
			}

			.aitsc-overview-content ul,
			.aitsc-overview-content ol {
				margin-left: 1.5rem;
				margin-bottom: 1rem;
			}

			.aitsc-overview-content table {
				width: 100%;
				border-collapse: collapse;
				margin: 1rem 0;
				font-size: 0.9rem;
			}

			.aitsc-overview-content th,
			.aitsc-overview-content td {
				border: 1px solid rgba(255,255,255,0.1);
				padding: 0.5rem;
				text-align: left;
			}

			.aitsc-overview-content th {
				background: rgba(255,255,255,0.05);
				font-weight: 600;
			}

			.aitsc-overview-image {
				position: relative;
			}

			/* Responsive */
			@media (max-width: 1024px) {
				.aitsc-overview-row {
					grid-template-columns: 1fr;
					gap: 2rem;
				}

				.aitsc-overview-row--reverse {
					direction: ltr;
				}

				.aitsc-overview-row--reverse .aitsc-overview-image {
					order: -1;
				}
			}
			</style>
		<?php endif; ?>

    </div>
</section>
