# Cheek – Custom Chaps WooCommerce Child Theme

Welcome to the Cheek site! This is a custom WordPress child theme for WooCommerce, designed for a playful, interactive shopping experience focused on custom chaps orders.

---

## Features

- **Custom Product Form:**  
  A bespoke form for the "Custom Chaps" product, allowing users to select shape, style, materials, colours, accessories, vibes, and provide extra notes. Data is saved to the cart, displayed in the cart/checkout, and stored in the order.

- **Interactive UI:**  
  Tag selectors for multi-choice fields, styled with custom CSS for a unique look and feel.

- **Story Page:**  
  A custom template (`home-custom.php`) that dynamically loads story content and media, including YouTube video embeds and custom image frames.

- **p5.js Integration:**  
  An animated, interactive canvas overlay for visual flair on the homepage.

- **WooCommerce Integration:**  
  All custom product data is seamlessly integrated into the WooCommerce cart and order flow.

---

## File Structure

- `/wp-content/themes/astrachildtheme/`
  - `functions.php` – Main theme functions and includes.
  - `/inc/custom-chaps-form.php` – All logic and markup for the custom chaps product form and WooCommerce hooks.
  - `/home-custom.php` – Custom homepage template with dynamic story and media content.
  - `/js/` – (Optional) JavaScript files for interactive features.
  - `/img/` – Custom images for the story page and product frames.

---

## Setup

1. **Install & Activate:**  
   Upload the child theme to your WordPress installation and activate it.

2. **WooCommerce:**  
   Ensure WooCommerce is installed and activated.

3. **Custom Product:**  
   Create a product titled **"Custom Chaps"**. The custom form will only appear on this product.

4. **Story Page:**  
   Create a page titled **"Story"** and add custom fields for video and section content as needed.

5. **Permalinks:**  
   After setup, visit **Settings > Permalinks** and click "Save Changes" to refresh rewrite rules.

---

## Customization

- **Form Options:**  
  Edit `/inc/custom-chaps-form.php` to change available materials, colours, accessories, or vibes.
- **Styling:**  
  Adjust CSS in the same file or add your own stylesheets.
- **JS/CSS:**  
  Add or modify scripts in the `/js/` directory and enqueue them in `functions.php`.

---

## Troubleshooting

- If the custom form does not appear, ensure the product title matches **"Custom Chaps"** exactly.
- If custom data is not saved, check WooCommerce is active and the hooks are not being overridden by another plugin or theme.
- For issues with the homepage or story content, verify the page title and custom fields.

---

## Credits

- Theme by Kimberley Dobney
- Built on Astra Child Theme
- Uses [WooCommerce](https://woocommerce.com/) and [p5.js](https://p5js.org/)

---

## License

GPL-2.0-or-later
