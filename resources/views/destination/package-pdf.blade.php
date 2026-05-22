<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $packagePageData['package_title'] }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            color: #333;
            line-height: 1.6;
            background: #fff;
        }

        .pdf-container {
            max-width: 850px;
            margin: 0 auto;
            padding: 40px 30px;
        }

        .pdf-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 8px;
            margin-bottom: 30px;
            text-align: center;
        }

        .pdf-header h1 {
            font-size: 32px;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .pdf-header .destination-info {
            font-size: 16px;
            opacity: 0.95;
        }

        .pdf-header .destination-info span {
            margin: 0 15px;
        }

        .package-details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
            background: #f5f5f5;
            padding: 25px;
            border-radius: 8px;
        }

        .detail-item {
            border-left: 4px solid #667eea;
            padding-left: 15px;
        }

        .detail-item .label {
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }

        .detail-item .value {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        .package-includes {
            background: white;
            padding: 25px;
            margin-bottom: 30px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
        }

        .package-includes h3 {
            font-size: 20px;
            margin-bottom: 15px;
            color: #333;
            border-bottom: 2px solid #667eea;
            padding-bottom: 10px;
        }

        .includes-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .include-item {
            padding: 12px;
            background: #f9f9f9;
            border-radius: 6px;
            border-left: 3px solid #667eea;
        }

        .include-item::before {
            content: "✓ ";
            color: #667eea;
            font-weight: bold;
            margin-right: 8px;
        }

        .section {
            background: white;
            padding: 25px;
            margin-bottom: 20px;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }

        .section h2 {
            font-size: 22px;
            margin-bottom: 15px;
            color: #333;
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 10px;
        }

        .overview-text {
            font-size: 14px;
            line-height: 1.8;
            color: #555;
            margin-bottom: 15px;
        }

        .highlight-badges {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .badge {
            background: #667eea;
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 13px;
            text-align: center;
        }

        .itinerary-list {
            list-style: none;
            counter-reset: day-counter;
        }

        .itinerary-item {
            margin-bottom: 15px;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 6px;
            border-left: 4px solid #667eea;
        }

        .itinerary-item .day-title {
            font-weight: bold;
            color: #667eea;
            margin-bottom: 5px;
            font-size: 15px;
        }

        .itinerary-item .day-description {
            font-size: 13px;
            color: #666;
            line-height: 1.6;
        }

        .inclexc-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .inclexc-box {
            padding: 20px;
            border-radius: 8px;
        }

        .inclexc-box h3 {
            margin-bottom: 15px;
            font-size: 16px;
        }

        .inclexc-box-in {
            background: #e8f5e9;
            border-left: 4px solid #4caf50;
        }

        .inclexc-box-in h3 {
            color: #2e7d32;
        }

        .inclexc-box-ex {
            background: #ffebee;
            border-left: 4px solid #f44336;
        }

        .inclexc-box-ex h3 {
            color: #c62828;
        }

        .inclexc-box ul {
            list-style: none;
            padding: 0;
        }

        .inclexc-box li {
            padding: 8px 0;
            padding-left: 20px;
            font-size: 13px;
            position: relative;
        }

        .inclexc-box-in li::before {
            content: "✓";
            position: absolute;
            left: 0;
            color: #4caf50;
            font-weight: bold;
        }

        .inclexc-box-ex li::before {
            content: "✗";
            position: absolute;
            left: 0;
            color: #f44336;
            font-weight: bold;
        }

        .hotel-info {
            padding: 20px;
            background: #f0f4f8;
            border-radius: 8px;
            margin: 15px 0;
        }

        .hotel-info h3 {
            font-size: 18px;
            margin-bottom: 8px;
            color: #333;
        }

        .hotel-info p {
            font-size: 13px;
            color: #666;
            margin-bottom: 10px;
        }

        .hotel-highlights {
            list-style: none;
            padding: 0;
        }

        .hotel-highlights li {
            padding: 6px 0;
            padding-left: 18px;
            font-size: 13px;
            position: relative;
        }

        .hotel-highlights li::before {
            content: "•";
            position: absolute;
            left: 5px;
            color: #667eea;
            font-weight: bold;
        }

        .contact-info {
            background: #667eea;
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            margin-top: 30px;
        }

        .contact-info h3 {
            margin-bottom: 10px;
            font-size: 18px;
        }

        .contact-info p {
            font-size: 14px;
            margin: 5px 0;
        }

        .price-section {
            background: #fff3e0;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: center;
            border-left: 4px solid #ff9800;
        }

        .price-section .label {
            font-size: 13px;
            color: #666;
            text-transform: uppercase;
        }

        .price-section .price {
            font-size: 32px;
            font-weight: bold;
            color: #ff9800;
            margin: 10px 0;
        }

        .price-section .note {
            font-size: 12px;
            color: #666;
        }

        .page-break {
            page-break-after: always;
        }

        .footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #e0e0e0;
            font-size: 12px;
            color: #999;
            margin-top: 30px;
        }

        @media print {
            body {
                background: white;
            }
            .section {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="pdf-container">
        <!-- Header -->
        <div class="pdf-header">
            <h1>{{ $packagePageData['package_title'] }}</h1>
            <div class="destination-info">
                <span>📍 {{ $packagePageData['destination_tagline'] }}</span>
                <span>📅 {{ $packagePageData['package_duration'] }}</span>
            </div>
        </div>

        <!-- Price Section -->
        <div class="price-section">
            <div class="label">Starting Price (Per Person)</div>
            <div class="price">{{ $packagePageData['starting_price'] }}</div>
            <div class="note">On twin sharing basis</div>
        </div>

        <!-- Package Details Grid -->
        <div class="package-details-grid">
            <div class="detail-item">
                <div class="label">Duration</div>
                <div class="value">{{ $packagePageData['night_count'] }} Nights / {{ $packagePageData['day_count'] }} Days</div>
            </div>
            <div class="detail-item">
                <div class="label">Destination</div>
                <div class="value">{{ $destination->name }}</div>
            </div>
            <div class="detail-item">
                <div class="label">Package Rating</div>
                <div class="value">⭐ {{ $packagePageData['package_rating'] }}/5</div>
            </div>
            <div class="detail-item">
                <div class="label">Reviews</div>
                <div class="value">{{ number_format((int) $packagePageData['review_count']) }}</div>
            </div>
        </div>

        <!-- Package Includes -->
        <div class="package-includes">
            <h3>What's Included in This Package</h3>
            <div class="includes-grid">
                <div class="include-item">Hotel Stay</div>
                <div class="include-item">Sightseeing Tours</div>
                <div class="include-item">Transfers & Transport</div>
                <div class="include-item">Meal(s) as per Itinerary</div>
            </div>
        </div>

        <!-- Overview Section -->
        <div class="section">
            <h2>Package Overview</h2>
            <p class="overview-text">{{ $packagePageData['overview_text'] }}</p>
            @if(!empty($packagePageData['highlight_points']))
                <div class="highlight-badges">
                    @foreach($packagePageData['highlight_points'] as $point)
                        <div class="badge">{{ $point }}</div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Itinerary Section -->
        <div class="section">
            <h2>Day Wise Itinerary</h2>
            <ul class="itinerary-list">
                @foreach($packagePageData['itinerary_items'] as $item)
                    <li class="itinerary-item">
                        <div class="day-title">Day {{ $item['day'] }}: {{ $item['title'] }}</div>
                        <div class="day-description">{{ $item['summary'] }}</div>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Hotel Details Section -->
        <div class="section">
            <h2>Hotel Details</h2>
            <div class="hotel-info">
                <h3>{{ $packagePageData['hotel_name'] }}</h3>
                <p>{{ $packagePageData['hotel_category'] }} • {{ $packagePageData['hotel_area'] }}</p>
                <ul class="hotel-highlights">
                    @foreach($packagePageData['hotel_highlights'] as $highlight)
                        <li>{{ $highlight }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Inclusions & Exclusions -->
        <div class="section">
            <h2>Inclusions & Exclusions</h2>
            <div class="inclexc-grid">
                <div class="inclexc-box inclexc-box-in">
                    <h3>✓ Inclusions</h3>
                    <ul>
                        @foreach($packagePageData['inclusions'] as $inclusion)
                            <li>{{ $inclusion }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="inclexc-box inclexc-box-ex">
                    <h3>✗ Exclusions</h3>
                    <ul>
                        @foreach($packagePageData['exclusions'] as $exclusion)
                            <li>{{ $exclusion }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!-- Contact Section -->
        <div class="contact-info">
            <h3>Need More Information?</h3>
            <p>📞 {{ $packagePageData['contact_phone'] }}</p>
            <p>📧 {{ $packagePageData['contact_email'] }}</p>
            <p style="margin-top: 15px; font-size: 12px; opacity: 0.9;">For inquiries, bookings, and customizations</p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>This is a PDF package itinerary from Shabdd Travel. For the latest updates and offers, visit our website.</p>
            <p>Generated on {{ now()->format('F j, Y') }}</p>
        </div>
    </div>
</body>
</html>
