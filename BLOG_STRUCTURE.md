# 📊 Blog System Structure

## Page Flow

```
┌─────────────────────────────────────────────────────────────┐
│                        HOMEPAGE                              │
│  ┌────────────────────────────────────────────────────┐    │
│  │  Latest Travel Stories Section                      │    │
│  │  - Shows 3 latest blog posts                        │    │
│  │  - "View All Articles" button → Blog Index         │    │
│  └────────────────────────────────────────────────────┘    │
└─────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────┐
│                    BLOG INDEX PAGE                           │
│  ┌────────────────────────────────────────────────────┐    │
│  │  Hero Section                                       │    │
│  │  - Title, subtitle, stats                          │    │
│  └────────────────────────────────────────────────────┘    │
│  ┌────────────────────────────────────────────────────┐    │
│  │  Destination Filters                                │    │
│  │  [All] [Bali] [Switzerland] [Maldives] ...        │    │
│  └────────────────────────────────────────────────────┘    │
│  ┌──────────────────────────┬─────────────────────────┐    │
│  │  Featured Post           │  Sidebar                │    │
│  │  (Changes with filter)   │  - Search               │    │
│  │                          │  - Latest Posts         │    │
│  ├──────────────────────────┤  - Categories           │    │
│  │  Blog Grid (2 columns)   │  - Destinations         │    │
│  │  - Card 1    - Card 2    │  - Newsletter           │    │
│  │  - Card 3    - Card 4    │  - Tags                 │    │
│  │  - Card 5    - Card 6    │                         │    │
│  └──────────────────────────┴─────────────────────────┘    │
└─────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────┐
│                   BLOG DETAIL PAGE                           │
│  ┌────────────────────────────────────────────────────┐    │
│  │  Full-Width Hero Image                              │    │
│  │  - Breadcrumbs                                      │    │
│  │  - Category badge                                   │    │
│  │  - Title                                            │    │
│  │  - Meta (author, date, reading time, location)     │    │
│  └────────────────────────────────────────────────────┘    │
│  ┌──────────────────────────┬─────────────────────────┐    │
│  │  Article Content         │  Sidebar                │    │
│  │  - Drop cap first letter │  - Search               │    │
│  │  - Paragraphs            │  - Latest Posts         │    │
│  │  - Key Highlights        │  - Categories           │    │
│  │  - Social Sharing        │  - Destinations         │    │
│  │  - Author Box            │  - Newsletter           │    │
│  └──────────────────────────┴─────────────────────────┘    │
│  ┌────────────────────────────────────────────────────┐    │
│  │  Related Posts (3 cards)                            │    │
│  └────────────────────────────────────────────────────┘    │
└─────────────────────────────────────────────────────────────┘
```

## Data Flow

```
┌─────────────────────────────────────────────────────────────┐
│                      DATABASE                                │
│  ┌────────────────────────────────────────────────────┐    │
│  │  destinations table                                 │    │
│  │  ├── id                                             │    │
│  │  ├── name (Bali, Switzerland, etc.)                │    │
│  │  ├── slug                                           │    │
│  │  ├── image_url                                      │    │
│  │  └── blogs (JSON)                                   │    │
│  │      ├── title                                      │    │
│  │      ├── slug                                       │    │
│  │      ├── excerpt                                    │    │
│  │      ├── date                                       │    │
│  │      ├── reading_time                               │    │
│  │      ├── category                                   │    │
│  │      └── author                                     │    │
│  └────────────────────────────────────────────────────┘    │
└─────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────┐
│                   BlogController                             │
│  ┌────────────────────────────────────────────────────┐    │
│  │  buildBlogCollection()                              │    │
│  │  - Fetches all destinations                         │    │
│  │  - Extracts blogs from each                         │    │
│  │  - Normalizes data                                  │    │
│  │  - Sorts by date                                    │    │
│  │  - Returns collection                               │    │
│  └────────────────────────────────────────────────────┘    │
│  ┌────────────────────────────────────────────────────┐    │
│  │  index()                                            │    │
│  │  - Gets all blogs                                   │    │
│  │  - Gets featured post                               │    │
│  │  - Gets destinations list                           │    │
│  │  - Returns view with data                           │    │
│  └────────────────────────────────────────────────────┘    │
│  ┌────────────────────────────────────────────────────┐    │
│  │  show($destination, $slug)                          │    │
│  │  - Finds specific blog post                         │    │
│  │  - Gets related posts                               │    │
│  │  - Returns view with data                           │    │
│  └────────────────────────────────────────────────────┘    │
└─────────────────────────────────────────────────────────────┘
                            ↓
┌─────────────────────────────────────────────────────────────┐
│                      VIEWS                                   │
│  ┌────────────────────────────────────────────────────┐    │
│  │  blog/index.blade.php                               │    │
│  │  - Displays all blogs                               │    │
│  │  - Handles filtering                                │    │
│  │  - Shows featured post                              │    │
│  │  - Includes sidebar                                 │    │
│  └────────────────────────────────────────────────────┘    │
│  ┌────────────────────────────────────────────────────┐    │
│  │  blog/show.blade.php                                │    │
│  │  - Displays single blog                             │    │
│  │  - Shows content                                    │    │
│  │  - Includes sidebar                                 │    │
│  │  - Shows related posts                              │    │
│  └────────────────────────────────────────────────────┘    │
│  ┌────────────────────────────────────────────────────┐    │
│  │  partials/blog-sidebar.blade.php                    │    │
│  │  - Reusable sidebar component                       │    │
│  │  - Used on all blog pages                           │    │
│  └────────────────────────────────────────────────────┘    │
└─────────────────────────────────────────────────────────────┘
```

## Component Breakdown

### Blog Index Page Components
```
┌─────────────────────────────────────────────────────────────┐
│  Hero Section                                                │
│  ├── Title                                                   │
│  ├── Subtitle                                                │
│  └── Stats (Articles, Destinations, Readers)                │
├─────────────────────────────────────────────────────────────┤
│  Filter Section                                              │
│  └── Destination Buttons (All, Bali, Switzerland, ...)      │
├─────────────────────────────────────────────────────────────┤
│  Main Content Area                                           │
│  ├── Featured Post (Left)                                    │
│  │   ├── Large Image                                         │
│  │   ├── Badge                                               │
│  │   ├── Title                                               │
│  │   ├── Excerpt                                             │
│  │   ├── Meta Info                                           │
│  │   └── Read Button                                         │
│  └── Sidebar (Right)                                         │
│      ├── Search Box                                          │
│      ├── Latest Posts (5)                                    │
│      ├── Categories                                          │
│      ├── Destinations                                        │
│      ├── Newsletter                                          │
│      └── Tags                                                │
├─────────────────────────────────────────────────────────────┤
│  Blog Grid                                                   │
│  └── Blog Cards (2 columns)                                  │
│      ├── Image                                               │
│      ├── Category Badge                                      │
│      ├── Title                                               │
│      ├── Excerpt                                             │
│      └── Meta (Reading time, Location)                       │
└─────────────────────────────────────────────────────────────┘
```

### Blog Detail Page Components
```
┌─────────────────────────────────────────────────────────────┐
│  Hero Section (Full Width)                                   │
│  ├── Background Image                                        │
│  ├── Gradient Overlay                                        │
│  ├── Breadcrumbs                                             │
│  ├── Category Badge                                          │
│  ├── Title                                                   │
│  └── Meta (Author, Date, Reading Time, Location)            │
├─────────────────────────────────────────────────────────────┤
│  Content Area                                                │
│  ├── Article Content (Left)                                  │
│  │   ├── Drop Cap First Letter                              │
│  │   ├── Paragraphs                                          │
│  │   ├── Key Highlights Box                                  │
│  │   ├── Social Sharing Buttons                              │
│  │   └── Author Box                                          │
│  └── Sidebar (Right)                                         │
│      ├── Search Box                                          │
│      ├── Latest Posts                                        │
│      ├── Categories                                          │
│      ├── Destinations                                        │
│      ├── Newsletter                                          │
│      └── Tags                                                │
├─────────────────────────────────────────────────────────────┤
│  Related Posts Section                                       │
│  └── 3 Related Blog Cards                                    │
└─────────────────────────────────────────────────────────────┘
```

## Filtering Logic

```
User clicks destination filter
        ↓
JavaScript captures click
        ↓
Updates active button state
        ↓
Filters blog cards by destination
        ↓
Updates featured post
        ↓
Shows/hides cards based on filter
        ↓
Updates visible count
```

## Related Posts Algorithm

```
Find blog post
        ↓
Search for posts from same destination
        ↓
If found → Return top 3
        ↓
If not found → Search by same category
        ↓
If found → Return top 3
        ↓
If not found → Return latest 3 posts
```

## URL Structure

```
Homepage:           /
Blog Index:         /blogs
Blog Post:          /blogs/{destination-slug}/{blog-slug}

Examples:
/blogs/bali/bali-budget-itinerary
/blogs/switzerland/switzerland-winter-guide
/blogs/maldives/maldives-honeymoon-guide
```

## File Dependencies

```
blog/index.blade.php
├── layouts/app.blade.php
├── partials/blog-sidebar.blade.php
└── JavaScript (inline)

blog/show.blade.php
├── layouts/app.blade.php
├── partials/blog-sidebar.blade.php
└── CSS (inline)

partials/blog-sidebar.blade.php
├── CSS (inline)
└── No dependencies

partials/home-blog-section.blade.php
├── CSS (inline)
└── No dependencies
```

## Color Scheme

```
Primary Purple:     #667eea
Secondary Purple:   #764ba2
Accent Gold:        #fbbf24
Dark Text:          #1f2937
Medium Text:        #6b7280
Light Text:         #9ca3af
Background:         #f9fafb
White:              #ffffff
Border:             #e5e7eb
```

## Responsive Breakpoints

```
Desktop:    > 991px   (Full sidebar, 2-column grid)
Tablet:     768-991px (Sidebar below, 2-column grid)
Mobile:     < 768px   (Single column, stacked)
```

---

**This structure ensures a clean, maintainable, and scalable blog system!** 🎯
