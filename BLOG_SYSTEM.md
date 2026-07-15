# Dynamic Blog System - Shabdd Travel

## Overview
A fully dynamic blog system integrated with the destinations database. Blog posts are stored as JSON data in the destinations table and dynamically rendered.

## Features

### Blog Index Page (`/blogs`)
- **Featured Post Section**: Highlights the latest blog post with large image and full excerpt
- **Filter by Destination**: Dynamic filter buttons to show blogs by destination
- **Responsive Grid Layout**: 3-column grid on desktop, responsive on mobile
- **Blog Cards**: Each card shows:
  - Featured image
  - Category badge
  - Title
  - Excerpt
  - Reading time
  - Destination name

### Blog Detail Page (`/blogs/{destination}/{slug}`)
- **Hero Section**: Full-width image with overlay and post metadata
- **Article Content**: Clean, readable typography with proper spacing
- **Key Highlights**: Bulleted list of main points
- **Author Box**: Author information with avatar
- **Related Posts**: 3 related blog posts based on destination or category
- **Responsive Design**: Mobile-optimized layout

## How to Add New Blog Posts

### Method 1: Via Database Seeder
Edit `database/seeders/DestinationSeeder.php` and add blog entries to any destination:

```php
'blogs' => [
    [
        'title' => 'Your Blog Title',
        'slug' => 'your-blog-slug',
        'excerpt' => 'Short description of the blog post',
        'date' => '2026-05-15',
        'reading_time' => 8,
        'category' => 'Destination Guide',
        'author' => 'Author Name',
        'role' => 'Travel Expert', // Optional
    ],
],
```

Then run: `php artisan db:seed --class=DestinationSeeder`

### Method 2: Via Tinker
```php
php artisan tinker

$destination = \App\Models\Destination::where('name', 'Bali')->first();
$blogs = $destination->blogs ?? [];
$blogs[] = [
    'title' => 'New Blog Post',
    'slug' => 'new-blog-post',
    'excerpt' => 'Description here',
    'date' => now()->toDateString(),
    'reading_time' => 5,
    'category' => 'Travel Tips',
];
$destination->blogs = $blogs;
$destination->save();
```

## Blog Categories
- Destination Guide
- Travel Tips
- Budget Travel
- Honeymoon
- Adventure
- Family Trips

## Routes
- `GET /blogs` - Blog index page
- `GET /blogs/{destination}/{blog}` - Individual blog post

## Files Structure
```
resources/views/blog/
├── index.blade.php    # Blog listing page
└── show.blade.php     # Blog detail page

app/Http/Controllers/
└── BlogController.php # Blog logic

public/css/
└── blog.css          # Blog-specific styles

database/seeders/
└── DestinationSeeder.php # Sample blog data
```

## Customization

### Change Blog Layout
Edit `resources/views/blog/index.blade.php` or `show.blade.php`

### Modify Blog Logic
Edit `app/Http/Controllers/BlogController.php`

### Add More Fields
1. Add fields to the blog array in seeder
2. Update the BlogController's `normalizeBlog()` method
3. Display new fields in the blade templates

## Dynamic Content
The blog system automatically:
- Generates slugs from titles
- Calculates reading time based on content length
- Infers categories from destination and title keywords
- Creates excerpts if not provided
- Builds content paragraphs dynamically
- Finds related posts by destination and category

## SEO Friendly
- Clean URLs: `/blogs/bali/budget-itinerary`
- Semantic HTML structure
- Meta information ready for enhancement
- Fast loading with optimized images

## Future Enhancements
- Add search functionality
- Implement pagination
- Add comments system
- Social media sharing buttons
- Newsletter subscription
- Blog post likes/bookmarks
- Admin panel for blog management
