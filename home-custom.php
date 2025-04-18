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
    overflow: hidden;
}

.story-page-content {
    scroll-snap-type: y mandatory;
    overflow-y: auto;
    height: 100vh;
    position: relative;
    z-index: 1;
    /* Hides scrollbar on most browsers */
    scrollbar-width: none;         /* Firefox */
    -ms-overflow-style: none;      /* IE/Edge */
}

.page-content::-webkit-scrollbar {
    display: none; /* Chrome, Safari */
}

.snap-section {
    scroll-snap-align: start;
    padding: 4rem 2rem;
    max-width: 700px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    justify-content: center;
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
    margin-bottom: 100px;
}

.story-section.active {
    font-weight: 800;
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
    <div class="snap-section story-video" style="margin-bottom: 2rem;">
        <iframe width="100%" height="400" src="https://www.youtube.com/embed/<?php echo esc_attr($video_id); ?>" frameborder="0" allowfullscreen></iframe>
    </div>
        <?php
    endif;

        // Section outputs
    foreach ( $sections as $index => $text ) {
        if ($text ) {
            // Give each section a unique ID
            $section_id = "section-" . ($index + 1);
            echo '<div class="snap-section story-section" id="' . esc_attr($section_id) . '" style="">';
            // echo '<h3>Part ' . ( $index + 1 ) . '</h3>';
            echo '<p>' . esc_html($text) . '</p>';
            echo '</div>';
        }
    }
}
?>
</main>

<!-- This div will hold your p5.js sketch -->
<div id="p5-container"></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/p5.js/1.4.0/p5.js"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    const sections = document.querySelectorAll('.story-section');

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            } else {
                entry.target.classList.remove('active');
            }
        });
    }, {
        threshold: 0.5, // Adjust this based on when you want it to "activate"
    });

    sections.forEach(section => {
        observer.observe(section);
    });
});
    
let ripples = []; // Store active ripples
let slaps = []; // Store slap texts

let x = 0;
let y = 0;
let speedX = 3;
let speedY = 3;
let radius = 60;

function setup() {
  let canvas = createCanvas(windowWidth, windowHeight); 
  canvas.parent('p5-container');

  noStroke();
  // Initialize position and speed
  x = random(radius, width - radius);
  y = random(radius, height - radius);
  speedX = random(2, 5);
  speedY = random(2, 5);
}

function draw() {
  clear();

  // Move the bum
  x += speedX;
  y += speedY;

  // Bounce off edges
  if (x - radius < 0 || x + radius + 5 > width) {
    speedX *= -1;
  }
  if (y - radius < 0 || y + radius + 5 > height) {
    speedY *= -1;
  }

  let mainColor = color("#3300ff"); // Main bum color
  let shadowColor = lerpColor(mainColor, color("#330044"), 0.8); // Darker blue shadow
  let highlightColor = lerpColor(mainColor, color("#9999ff"), 0.5); // Lighter highlight

  // --- SHADING ---
  fill(shadowColor);
  ellipse(x + 75, y + 15, 125, 145); // Left cheek shadow
  fill(shadowColor);
  ellipse(x + 10, y + 10, 125, 145); // Right cheek shadow

  // --- BASE BUM COLOR ---
  fill(mainColor);
  ellipse(x, y, 120, 140); // Left cheek
  fill(51, 0, 225); // Slightly darker for depth
  ellipse(x + 70, y, 120, 140); // Right cheek (lighter side)

  // --- RIPPLES ---
  for (let i = ripples.length - 1; i >= 0; i--) {
    let r = ripples[i];
    fill(255, 8, 5, r.alpha);
    ellipse(r.x, r.y, r.size, r.size);
    r.size += 3;
    r.alpha -= 5;
    if (r.alpha <= 0) ripples.splice(i, 1);
  }

  // --- SLAP TEXT ---
  textSize(30);
  textAlign(CENTER, CENTER);
  for (let i = slaps.length - 1; i >= 0; i--) {
    let s = slaps[i];
    fill(252,170, 199, s.alpha);
    text("SLAP!", s.x, s.y);
    s.alpha -= 5;
    if (s.alpha <= 0) slaps.splice(i, 1);
  }
}

function mousePressed() {
  if (isMouseOnBum(mouseX, mouseY)) {
    ripples.push({ x: mouseX, y: mouseY, size: 10, alpha: 150 });
    slaps.push({ x: mouseX, y: mouseY - 20, alpha: 255 });
  }
}

function isMouseOnBum(mx, my) {
  let d1 = dist(mx, my, x, y);
  let inLeftCheek = d1 < 60;
  let d2 = dist(mx, my, x + 70, y);
  let inRightCheek = d2 < 60;
  let inBottom = (mx > x + 35 - 75 && mx < x + 35 + 75) && (my > y + 30 && my < y + 60);
  return inLeftCheek || inRightCheek || inBottom;
}
</script>

<?php
get_footer(); // Include the footer part of the theme
?>
