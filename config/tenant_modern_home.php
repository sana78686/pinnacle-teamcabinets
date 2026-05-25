<?php

/**
 * Default homepage content for the Modern storefront theme (Cabinets.com-style layout).
 * Media paths are relative to public/themes/modern/media/.
 */
return [
    /** Fallback copy when Home & FAQ fields are empty (Modern theme). */
    'content_defaults' => [
        'style_intro_title' => 'Cabinets for every style and budget',
        'style_intro_body' => '{company} makes kitchen design easy with multiple door styles, finishes, and construction options — tailored for your trade customers.',
        'door_title' => 'Door Styles',
        'door_body' => '21 door styles in Framed, Frameless, and European Frameless cabinets',
        'finish_title' => 'Finish Options',
        'finish_body' => 'More than 80 unique colors including stains, paints, and enhancements',
        'factory_title' => 'From our hands, to your home',
        'factory_body' => 'Technology meets craftsmanship at our facility, where we transform raw wood into kitchen cabinets for {company} partners.',
        'gallery_title' => 'Design inspiration',
        'cta_one_title' => 'Create-A-Kitchen Tool',
        'cta_one_body' => 'Our user-friendly virtual kitchen planner for approved dealers.',
        'cta_one_label' => 'Get access →',
        'cta_two_title' => 'Trade Pro Program',
        'cta_two_body' => 'For businesses directly involved with cabinet installation and distribution.',
        'cta_two_label' => 'Apply today →',
    ],

    'hero_video' => 'video/hero.mp4',
    'hero_poster' => 'video/hero-poster.jpg',
    'factory_video' => 'video/factory.mp4',
    'factory_poster' => 'video/factory-poster.jpg',

    /** Gallery & showcase image rotation interval (milliseconds). */
    'slideshow_interval_ms' => 2000,

    'door_styles' => [
        ['file' => 'door-styles/shaker-solid.png', 'alt' => 'Shaker solid maple doors'],
        ['file' => 'door-styles/belleair-glass.png', 'alt' => 'Belleair glass doors'],
        ['file' => 'door-styles/monaco-solid.png', 'alt' => 'Monaco solid doors'],
        ['file' => 'door-styles/hawthorne-mixed.png', 'alt' => 'Hawthorne mixed doors'],
        ['file' => 'door-styles/belleair-solid.png', 'alt' => 'Belleair solid maple doors'],
        ['file' => 'door-styles/jupiter-glass-bottom.png', 'alt' => 'Jupiter glass and solid doors'],
    ],

    'finish_options' => [
        ['file' => 'finish-options/haze.png', 'alt' => 'Haze painted maple'],
        ['file' => 'finish-options/java.png', 'alt' => 'Java stained cherry'],
        ['file' => 'finish-options/latte.png', 'alt' => 'Latte stained maple'],
        ['file' => 'finish-options/midnight.png', 'alt' => 'Midnight painted maple'],
        ['file' => 'finish-options/smoky-blue.png', 'alt' => 'Smoky Blue painted maple'],
        ['file' => 'finish-options/white.png', 'alt' => 'White painted maple'],
        ['file' => 'finish-options/willow-gray.png', 'alt' => 'Willow Gray painted maple'],
        ['file' => 'finish-options/thunder-gray.png', 'alt' => 'Thunder Gray painted maple'],
    ],

    'gallery' => [
        ['file' => 'gallery/1-Shaker-II-Maple-Bright-White-and-Willow-Gray.jpg', 'title' => 'Shaker II Bright White and Willow Gray', 'slug' => 'shaker-ii-bright-white-willow-gray'],
        ['file' => 'gallery/2-Slab-Linear-Tan-Heartwood.jpg', 'title' => 'Slab Linear Tan Heartwood', 'slug' => 'slab-linear-tan-heartwood'],
        ['file' => 'gallery/3-Belleair-Maple-Willow-Gray-Brushed-Gray-Glaze.jpg', 'title' => 'Belleair Willow Gray Brushed Gray Glaze', 'slug' => 'belleair-willow-gray'],
        ['file' => 'gallery/4-Shaker-Maple-Haze.jpg', 'title' => 'Shaker Haze', 'slug' => 'shaker-haze'],
        ['file' => 'gallery/5-Colonial-II-Maple-Thunder-Gray.jpg', 'title' => 'Colonial II Thunder Gray', 'slug' => 'colonial-ii-thunder-gray'],
        ['file' => 'gallery/6-Lombard-II-Soft-Beige.jpg', 'title' => 'Lombard II Soft Beige', 'slug' => 'lombard-ii-soft-beige'],
        ['file' => 'gallery/7-Shaker-Maple-Alabaster-and-Toffee.jpg', 'title' => 'Shaker Alabaster and Toffee', 'slug' => 'shaker-alabaster-toffee'],
        ['file' => 'gallery/8-Belleair-Maple-Midnight.jpg', 'title' => 'Belleair Midnight', 'slug' => 'belleair-midnight'],
        ['file' => 'gallery/9-Colonial-Maple-Oyster.jpg', 'title' => 'Colonial Oyster', 'slug' => 'colonial-oyster'],
        ['file' => 'gallery/10-Baldwin-Maple-Willow-Gray-and-Naval.jpg', 'title' => 'Baldwin Willow Gray and Naval', 'slug' => 'baldwin-willow-gray-naval'],
        ['file' => 'gallery/11-Shaker-II-Maple-Willow-Gray.jpg', 'title' => 'Shaker II Willow Gray', 'slug' => 'shaker-ii-willow-gray'],
        ['file' => 'gallery/12-Slab-Graphite-Effect-and-Linear-Beige-Heartwood.jpg', 'title' => 'Slab Graphite Effect and Linear Beige Heartwood', 'slug' => 'slab-graphite-linear-beige'],
    ],
];
