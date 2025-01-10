<?php get_header(); while (have_posts()) : the_post(); ?>


    <?php if (get_field('sections')) : ?>
        <?php foreach (get_field('sections') as $section) : ?>
            
            <?php if ($section['acf_fc_layout'] == 'blurb') : ?>
                <section class="blurby" id="<?php echo sanitize_title($section['title']); ?>">
                    <svg class="stamp" width="368px" height="402px" viewBox="0 0 368 402" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"> <defs> <polygon id="path-a3tt_he5r9-1" points="0 0 368 0 368 296 0 296"></polygon> </defs> <g id="GHF" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="home-copy-9" transform="translate(-1054, -542)"> <g id="Group-8" transform="translate(1054, 542)"> <path d="M133.437918,227 L236.567895,123.38935 C246.224067,113.70049 253.119731,102.295074 257.270584,90.1575302 C260.428013,80.9507483 262,71.3294697 262,61.6991803 C262,39.3704251 253.532349,17.0394173 236.567895,0 L149.624227,87.3394034 L133.437918,103.599387 C125.241608,111.833003 119.018692,121.314614 114.789352,131.426981 C103.332459,158.772497 106.375521,190.801375 123.918538,215.662165 C126.712683,219.64719 129.892537,223.438482 133.437918,227" id="Fill-1" fill="#F2E4D6"></path> <g id="Group-5" transform="translate(0, 106)"> <mask id="mask-a3tt_he5r9-2" fill="white"> <use xlink:href="#path-a3tt_he5r9-1"></use> </mask> <g id="Clip-4"></g> <path d="M368.000225,25.5179591 L142.711405,250.949101 L123.191471,270.458863 C120.695258,272.956653 118.109092,275.251919 115.410484,277.389667 C112.239619,279.887457 108.933824,282.115215 105.538075,284.117947 L105.515586,284.117947 C72.1652849,303.650212 28.6052485,299.104685 0,270.458863 L140.934821,129.457512 L164.32276,106.077301 L244.831242,25.5179591 C261.832475,8.50598638 284.118482,0 306.404489,0 C328.690497,0 350.976504,8.50598638 368.000225,25.5179591" id="Fill-3" fill="#F2E4D6" mask="url(#mask-a3tt_he5r9-2)"></path> </g> <path d="M157,361.084796 C195.557496,374.24281 239.946786,365.449143 270.694205,334.701554 C301.448345,303.947244 310.244203,259.557709 297.084021,221 L157,361.084796 Z" id="Fill-6" fill="#F2E4D6"></path> </g> </g> </g> </svg>
                    <div class="super-container" data-aos="fade-up" data-aos-duration="700">
                        <h2 class="h4"><?php echo $section['title']; ?></h2>
                        <div class="large-text">
                            <?php echo $section['content']; ?>
                        </div>
                    </div>
                </section>
            <?php endif; ?>

            <?php if ($section['acf_fc_layout'] == 'blurb_with_image') : ?>
                <section class="blurby-with-image" id="<?php echo sanitize_title($section['title']); ?>">
                    <?php if ($section['background']) : ?>
                        <img class="bg only-desktop" src="<?php echo $section['background']['url']; ?>" alt="<?php echo $section['title']; ?>" data-aos="fade-in" data-aos-duration="2500">
                    <?php endif; ?>
                    <div class="super-container" data-aos="fade-up" data-aos-duration="700">
                        <div class="contents">
                            <h2 class="h4"><?php echo $section['title']; ?></h2>
                            <div class="normal-text make-dark">
                                <?php echo $section['content']; ?>
                            </div>
                        </div>
                    </div>
                </section>
            <?php endif; ?>

            <?php if ($section['acf_fc_layout'] == 'grid') : ?>
                <section class="big-text-grid" id="<?php echo sanitize_title($section['title']); ?>" data-aos="fade-up" data-aos-duration="700">
                    <div class="super-container make-dark">
                        <h2><?php echo $section['title']; ?></h2>
                        <?php if ($section['subtitle']) : ?>
                            <p><?php echo $section['subtitle']; ?></p>
                        <?php endif; ?>
                        <?php if ($section['items']) : ?>
                            <div class="grid">
                                <?php 
                                $colors = ['orange', 'green', 'light-blue'];
                                $i = 0;
                                foreach ($section['items'] as $item) : 
                                ?>
                                    <div class="item <?php echo $colors[$i % 3]; ?>" data-aos="fade-up" data-aos-duration="700" data-aos-delay="<?php echo $i * 50; ?>">
                                        <div class="contents">
                                            <span class="number"><?php echo str_pad($i + 1, 2, '0', STR_PAD_LEFT) . '.'; ?></span>
                                            <h3 class="h4"><?php echo $item['name']; ?></h3>
                                            <p><?php echo $item['text']; ?></p>
                                        </div>
                                    </div>
                                <?php 
                                    $i++;
                                endforeach; 
                                ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>
            <?php endif; ?>


            <?php if ($section['acf_fc_layout'] == 'two_column') : ?>
                <section class="two-column-content">
                    <div class="columns">
                        <div class="item make-dark left" data-aos="fade-up" data-aos-duration="700">
                            <div class="wordpress">
                                <?php echo $section['left_column']; ?>
                            </div>
                        </div>
                        <div class="item right" data-aos="fade-up" data-aos-duration="700" data-aos-delay="100">
                            <div class="wordpress">
                                <?php echo $section['right_column']; ?>
                            </div>
                        </div>
                    </div>
                </section>
            <?php endif; ?>



        <?php endforeach; ?>
    <?php endif; ?>


    <?php if (get_the_content()) : ?>
    <section class="normal-content">
        <div class="super-container">
            <div class="wordpress">
                <?php the_content(); ?>    
            </div>
        </div>
    </section>
    <?php endif; ?>


<?php endwhile; get_footer(); ?>