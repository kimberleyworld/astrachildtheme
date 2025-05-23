<?php
/**
 * Template Name: Home Page Template
 *
 * A custom page template for a page created from the child theme.
 *
 * @category WordPress_Theme
 * @package  Astrachildtheme
 * @author   Kimberley Dobney <username@example.com>
 * @license  https://www.gnu.org/licenses/gpl-2.0.html GPL-2.0-or-later
 * @version  PHP 7.4
 * @link     https://developer.wordpress.org/themes/basics/theme-functions/
 * @since    1.0.0
 */
get_header(); // Include the header part of the theme
?>
<style>
html, body {
    height: 100%;
}
#content, .site-primary-header-wrap, .site-below-footer-wrap[data-section="section-below-footer-builder"]  {
    /* background-color: #f7792b;; */
}

.button {
    max-height: 50px;
}
.story-page-content {
    position: relative;
    z-index: 1;
    scrollbar-width: none;         /* Firefox */
    -ms-overflow-style: none;      /* IE/Edge */
    align-self: center;
}

.snap-section {
    padding: 1rem 2rem;
    max-width: 700px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.story-intro h2{
    text-align: center;
    margin: 60px 0;
}

#p5-container {
    position: fixed; 
    left: 0;
    width: 100vw;
    height: 100vh;
    z-index: 100;
    pointer-events: none;
}


.story-section {
    font-weight: 200;
    display: flex;
    flex-direction: row;
    align-self: center;
    padding-left: 20px !important;
    padding-right: 20px !important;
}

.image-frame-wrapper {
    position: relative;
    display: inline-block;
    width: 100%;
    max-width: 500px;
}

.image-frame-wrapper img {
    display: block;
    width: 100%;
    height: auto;
}

.custom-frame {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    pointer-events: none;
}

.frame-line {
    position: absolute;
    background-color: #3300ff;
}

.frame-line.top {
    top: 20px;
    left: 20px;
    right: 20px;
    height: 1px;
    z-index: 4;
}

.frame-line.right {
    top: 20px;
    bottom: 20px;
    right: 20px;
    width: 1px;
    z-index: 3;
}

.frame-line.bottom {
    left: 20px;
    right: 20px;
    bottom: 20px;
    height: 1px;
    z-index: 5; 
}

.frame-line.left {
    top: 20px;
    bottom: 20px;
    left: 20px;
    width: 1px;
    z-index: 2;
}


.story-section p {
    padding-right: 20px;
    margin-bottom: 0px;
    align-self: center;
}

.story-section p,
.story-image {
    width: 50%;
}

.story-image img {
    margin: 0px !important;
}

#section-2, #section-4 {
    flex-direction: row-reverse;
}

#section-2 p, #section-4 p {
    padding-right: 0px;
    padding-left: 20px;
}

/* Make sure no scrollbars are forced */
.story-wrapper::-webkit-scrollbar {
    display: none;
}

.menu-item a, .button, a {
    position: relative;
    z-index: 10000; /* Ensure buttons and links are clickable above the canvas */
}
.home-img {
    width: 500px;
}
.story-video{
    margin-top: 30px;
    margin-bottom: 30px;
}
.ytmCuedOverlayGradient{
    display: none !important;
}
.story-button{
    margin-top: 20px;
}
@media (max-width: 768px) {
    .story-section, #section-2, #section-4 {
        flex-direction: column;
    }
    .story-section p,
    .story-image {
    width: 100%;
    }
   .story-section p{
    padding-right: 0px !important;
    padding-left: 0px !important;
    padding-bottom: 20px;
    }
    .story-section {
        height: auto;
        min-height: 200px;
        margin-bottom: 0px;
        padding-bottom: 0px;
    }
    .story-intro h2 {
        margin: 20px 0;
    }
    .story-button{
        justify-content: flex-start;
    }
    .woocommerce-js a.button{
        background-color: #3300ff !important;
        color: white !important;
        width: 100%;
        text-align: center;
    }
    .button:hover {
        background-color: #fcaac7;
        border: #3300ff solid 1px;
    }

}
</style>
<main class="story-page-content">
<?php
$story_query = new WP_Query(
    [
    'post_type' => 'page',
    'title'     => 'Story',
    'post_status' => 'publish',
    'posts_per_page' => 1
    ]
);

$story_id = 0;
if ($story_query->have_posts() ) {
    $story_query->the_post();
    $story_id = get_the_ID();
}
wp_reset_postdata();

if ($story_id ) {
    $video = get_post_meta($story_id, '_story_video_url', true);
    $sections = [];
    for ( $i = 1; $i <= 4; $i++ ) {
        $sections[] = get_post_meta($story_id, "_story_section_$i", true);
    }

    $video_id = get_post_meta(get_the_ID(), '_story_video_id', true);

    if ($video_id) :
        // Display YouTube video using the saved video ID
        ?>
    <div class="story-video">
<iframe width="100%" height="400"
    src="https://www.youtube.com/embed/<?php echo esc_attr($video_id); ?>?controls=0&modestbranding=1&rel=0&showinfo=0"
    frameborder="0"
    allowfullscreen>
</iframe>    </div>
        <?php
    endif;

        // Section outputs
    $manual_images = [
     get_stylesheet_directory_uri() . '/img/sofa_green_chaps.JPG',
     get_stylesheet_directory_uri() . '/img/monsta_munch.JPG',
     get_stylesheet_directory_uri() . '/img/stained_glass.jpg',
     get_stylesheet_directory_uri() . '/img/ella_farm.jpg'
    ];

    echo '<div class="story-intro">';
    echo '<h2>Discover the Story Behind the Pieces</h2>';
    echo '</div>';

    foreach ($sections as $index => $text) {
        if ($text) {
            $section_id = "section-" . ($index + 1);
            $image_url = $manual_images[$index] ?? '';
            Render_Story_section($section_id, $text, $image_url);
        }
    }
    echo '<div class="story-section story-button">';
    echo '<a href="' . esc_url(home_url('/shop')) . '" class="button customise-button">Explore the Shop</a>';
    echo '</div>';

}
?>
</main>
<!-- This div will hold your p5.js sketch -->
<div id="p5-container"></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/1.4.0/p5.js"></script>
<script>
let x, y;
let speedX, speedY;

let stars = [];

function setup() {
  let canvas = createCanvas(windowWidth, windowHeight);
  canvas.parent('p5-container');
  noStroke();
}

function draw() {
  clear();

  // --- Add new star at mouse position ---
  if (frameCount % 2 === 0 && mouseX >= 0 && mouseY >= 0) {
    stars.push(new Star(mouseX, mouseY));
  }

  // --- Draw and update stars ---
  for (let i = stars.length - 1; i >= 0; i--) {
    stars[i].update();
    stars[i].display();
    if (stars[i].isDead()) {
      stars.splice(i, 1);
    }
  }
}

class Star {
  constructor(x, y) {
    this.x = x;
    this.y = y;
    this.life = 255;
    this.outerRadius = random(6, 10);
    this.innerRadius = this.outerRadius / 2.5;
    this.angle = random(TWO_PI);
    this.speed = random(0.2, 1.5);
  }

  update() {
    this.x += cos(this.angle) * this.speed;
    this.y += sin(this.angle) * this.speed;
    this.life -= 4;
  }

  display() {
    push();
    translate(this.x, this.y);
    fill(255, 255, 255, this.life);
    beginShape();
    let points = 5;
    for (let i = 0; i < points * 2; i++) {
      let angle = PI * i / points;
      let r = i % 2 === 0 ? this.outerRadius : this.innerRadius;
      let sx = cos(angle) * r;
      let sy = sin(angle) * r;
      vertex(sx, sy);
    }
    endShape(CLOSE);
    pop();
  }

  isDead() {
    return this.life <= 0;
  }
}

function windowResized() {
  resizeCanvas(windowWidth, windowHeight);
}
</script>

<?php
get_footer(); // Include the footer part of the theme
?>
