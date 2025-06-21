<?php
// Define allowed category slugs (exactly matching your sidebar links)
$allowed_categories = array(
    'Tools',
    'Needles',
);

// Get category from URL or show all allowed categories by default
$category_slug = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';
?>

<div class="sundries-page-wrapper">
    <div class="twc-inspired-sundries">
        <div class="twc-sidebar-wrapper">
            <div class="twc-sidebar">
                <h4 class="sidebar-title">Tools</h4>
                <ul class="category-list">
                    <li><a href="?">All Tools</a></li> <!-- Added "All" link -->
                    <li><a href="?category=Tools">Tools</a></li>
                    <li><a href="?category=Needles">Needles</a></li>
                    <!-- Add more links as needed -->
                </ul>
            </div>
        </div>

        <div class="twc-main-content">
    <?php if ($category_slug && in_array($category_slug, $allowed_categories)): 
        // SINGLE CATEGORY VIEW
        $args = array(
            'post_type' => 'product',
            'posts_per_page' => 34,
            'product_cat' => $category_slug
        );
        $products_query = new WP_Query($args);
        
        if ($products_query->have_posts()): ?>
            <div class="product-grid">
                <?php while ($products_query->have_posts()): $products_query->the_post(); 
                    global $product; ?>
                    <a href="<?php the_permalink(); ?>" class="product-card">
                        <div class="image-container">
                            <?php echo $product->get_image(); ?>
                        </div>
                        <span class="product-name"><?php the_title(); ?><br><?php echo $product->get_price_html(); ?></span>
                    </a>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>No products found in this category.</p>
        <?php endif;
        
    else: 
        // DEFAULT VIEW - ALL CATEGORIES IN ORDER
        foreach ($allowed_categories as $current_cat_slug): 
            $category = get_term_by('slug', $current_cat_slug, 'product_cat');
            if ($category): ?>
                <div class="category-group">
                    <h3 class="category-title"><?php echo esc_html($category->name); ?></h3>
                    <?php 
                    $args = array(
                        'post_type' => 'product',
                        'posts_per_page' => -1,
                        'product_cat' => $current_cat_slug
                    );
                    $cat_query = new WP_Query($args);
                    
                    if ($cat_query->have_posts()): ?>
                        <div class="product-grid">
                            <?php while ($cat_query->have_posts()): $cat_query->the_post(); 
                                global $product; ?>
                                <a href="<?php the_permalink(); ?>" class="product-card">
                                    <div class="image-container">
                                        <?php echo $product->get_image(); ?>
                                    </div>
                                    <span class="product-name"><?php the_title(); ?><br><?php echo $product->get_price_html(); ?></span>
                                </a>
                            <?php endwhile; ?>
                        </div>
                    <?php endif; 
                    wp_reset_postdata(); ?>
                </div>
            <?php endif;
        endforeach;
    endif; ?>
</div>

<style>

.category-group {
        margin-bottom: 40px;
    }
    .category-title {
        font-size: 18px;
        margin: 20px 0 15px;
        padding-bottom: 8px;
        border-bottom: 1px solid #eee;
        color: rgb(51, 51, 51);
        font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        font-weight: 100;
        letter-spacing: 1px;
    }
  
/* ===== Full Width Foundation ===== */
.sundries-page-wrapper {
  background-color:rgb(255, 255, 255);
  width: 100%;
  overflow-x: hidden;
}

/* ===== Main Content Container ===== */
.twc-inspired-sundries {
  display: flex;
  min-height: 100vh;
  padding: 40px 5%;
  font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
  color: #333;
  max-width: 1800px;
  margin: 0 auto;
  box-sizing: border-box;
}

/* ===== Sidebar ===== */
.twc-sidebar-wrapper {
  width: 220px;
  flex-shrink: 0;
}

.twc-sidebar {
  position: sticky;
  top: 40px;
  padding-right: 40px;
}

.sidebar-title {
  font-size: 16px;
  letter-spacing: 1px;
  text-transform: uppercase;
  margin-bottom: 25px;
  color: #333;
  font-weight: 400;
  border-bottom: 1px solid #e5e5e5;
  padding-bottom: 10px;
}

.category-list {
  list-style: none;
  padding: 0;
  margin: 0;
}

.category-list li {
  margin-bottom: 12px;
}

.category-list a {
  color: #333;
  text-decoration: none;
  font-size: 14px;
  letter-spacing: 0.5px;
  transition: color 0.3s;
  display: block;
  padding: 4px 0;
}

.category-list a:hover {
  color: #8a8a8a;
}

/* ===== Main Content ===== */
.twc-main-content {
  flex-grow: 1;
  padding-left: 40px;
}

/* ===== Product Grid ===== */
.product-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: 30px;
  padding: 0 20px;
  width: 100%;
}

.product-card {
  background: white;
  text-decoration: none;
  color: #333;
  transition: all 0.3s ease;
  box-shadow: 0 2px 10px rgba(0,0,0,0.05);
  border: 1px solid #e5e5e5;
}

.product-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
  border-color: #d5d5d5;
}

.image-container {
  width: 100%;
  height: 300px;
  overflow: hidden;
}

.image-container img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.3s ease;
}

.product-card:hover .image-container img {
  transform: scale(1.03);
}

.product-name {
  display: block;
  text-align: center;
  font-size: 14px;
  letter-spacing: 0.5px;
  padding: 20px 10px;
  line-height: 1.4;
  border-top: 1px solid #f0f0f0;
}

/* ===== Responsive Adjustments ===== */
@media (max-width: 1600px) {
  .twc-inspired-sundries {
    padding: 40px 3%;
  }
}

@media (max-width: 1200px) {
  .product-grid {
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
  }
}

@media (max-width: 900px) {
  .twc-inspired-sundries {
    flex-direction: column;
    padding: 40px 20px;
  }
  
  .twc-sidebar-wrapper {
    width: 100%;
    margin-bottom: 30px;
  }
  
  .twc-sidebar {
    position: relative;
    top: auto;
    padding-right: 0;
  }
  
  .twc-main-content {
    padding-left: 0;
  }
  
  .product-grid {
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
  }
}

@media (max-width: 600px) {
  .twc-inspired-sundries {
    padding: 40px 15px;
  }
  
  .product-grid {
    grid-template-columns: 1fr;
    gap: 20px;
    padding: 0;
  }
}
</style>