<?php
/**
Template name: homepage
 */

get_header(); ?>

<div class="contentAreaContainer">
            <h2 class="pageTitle">... recently completed web projects</h2>
            <div class="bannerArea">
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<? the_content();?>
<?php endwhile; endif; ?>
            </div>
            <div class="contentArea">
<?
	wtz_show_stuff_posts('category=7&numberposts=0');
?>
                <div class="testimonials">
                    <div class="testimonialsContainer">
                        <h2>... what do they say about us</h2>
                        <div class="testimonialsContentArea">
                            <div class="iconNav">
                                <ul>
                                    <li> <a href="#"><img width="96" height="34" border="0" align="" class="thumb" src="images/portfolio/sml/gifts2mobile-logo.jpg"></a> </li>
                                    <li> <a href="#"><img width="96" height="34" border="0" align="" class="thumb" src="images/portfolio/sml/alltheworldsfare-logo.jpg"></a> </li>
                                    <li> <a href="#"><img width="96" height="34" border="0" align="" class="thumb" src="images/portfolio/sml/interpartner-logo.jpg"></a> </li>
                                    <li class="current"> <a href="#"><img width="96" height="34" border="0" align="" class="thumb" src="images/portfolio/sml/toysgiftsgadgets-logo.jpg"></a> </li>
                                    <li> <a href="#"><img width="96" height="34" border="0" align="" class="thumb" src="images/portfolio/sml/queensparkrealestates-logo.jpg"></a> </li>
                                    <li> <a href="#"><img width="96" height="34" border="0" align="" class="thumb" src="images/portfolio/sml/mobilepersonalgifts-logo.jpg"></a> </li>
                                    <li> <a href="#"><img width="96" height="34" border="0" align="" class="thumb" src="images/portfolio/sml/tailoredimage-logo.jpg"></a> </li>
                                    <li> <a href="#"><img width="96" height="34" border="0" align="" class="thumb" src="images/portfolio/sml/winneronline-logo.jpg"></a> </li>
                                    <li> <a href="#"><img width="96" height="34" border="0" align="" class="thumb" src="images/portfolio/sml/superstarholidays-logo.jpg"></a> </li>
                                </ul>
                            </div>
                            <div class="testimonialsContent">
                                <div class="aTestimonial">
                                    <h2>ToysGiftsGadgets.com</h2>
                                    <a class="secondaryBtn" href="">find out more</a>
                                    <div class="quoteholder">
                                        <blockquote> "In todays business world, if you don't have an online business strategy, then your business will not maximise its full potential. You have to strive and give your customers the best service, this is the key to success!
                                            With the help of Webtrendz we are now able to compete online. The site is superb and our users seem to like it, looking at the figures, and I always do.... they dont lie." <span class="quotePerson">... Anand Lakhani.</span> </blockquote>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<?
	wtz_show_articles();
?>
<?
wtz_pre_footer();
?>
            </div>
        </div>

<?php get_footer(); ?>
