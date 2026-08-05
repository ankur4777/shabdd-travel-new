<!DOCTYPE html>
<html lang="en" style="overflow-x: hidden;">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @hasSection('meta')
        @yield('meta')
    @else
        <title>SHABDD TRAVEL</title>
    @endif
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
   <link rel="stylesheet" href="{{ asset('css/destination-detail.css') }}">
    <link rel="stylesheet" href="{{ asset('css/destination-filter.css') }}">
    <link rel="stylesheet" href="{{ asset('css/navbar-breakpoint-fix.css') }}">

    <!-- Premium header styles -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <div id="chatbot-toggle">
        <i class="bi bi-chat-dots-fill"></i>
    </div>

    <div id="chatbot-box">
        <div id="chatbot-header">
            Travel Assistant
            <span id="chatbot-close">&times;</span>
        </div>

        <div id="chatbot-messages">

            <div id="chatbot-empty-state">

                <i class="bi bi-robot"></i>

                <h5>Travel Assistant</h5>

            </div>

        </div>
        <div id="destination-suggestions"></div>
        <div id="chatbot-input-area">
            <input type="text" id="chatbot-input" autocomplete="off" placeholder="Ask about destinations...">

            <button id="chatbot-send">
                <i class="bi bi-send-fill"></i>
            </button>
        </div>
    </div>
    <style>
        #chatbot-toggle {
            position: fixed;
            bottom: 25px;
            right: 25px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: #FF5A4F;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            cursor: pointer;
            z-index: 9999;
        }

        #chatbot-box {
            position: fixed;
            bottom: 20px;
            right: 10px;
            width: 400px;
            max-width: 400px;
            height: 600px;
            max-height: 80vh;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, .15);
            display: none;
            flex-direction: column;
            overflow: hidden;
            z-index: 9999;
        }

        #chatbot-header {
            background: #FF5A4F;
            color: white;
            padding: 15px;
            font-weight: 700;
            display: flex;
            justify-content: space-between;
        }

        #chatbot-close {
            cursor: pointer;
        }

        #chatbot-messages {
            flex: 1;
            overflow-y: auto;
            padding: 10px;
        }

        .user-message {
            background: #f7827a;
            color: #fff;
            padding: 5px 9px;
            border-radius: 8px;
            margin-top: 15px;
            margin-bottom: 10px;
            width: fit-content;
            max-width: 80%;
            margin-left: auto;
            font-size: 14px;
            margin-right: 8px;
            text-align: left;
            max-width: 75%;
            line-height: 1.4;
        }

        .bot-message {
            background: #F7F7F7;
            padding: 8px 12px;
            border-radius: 12px;
            margin-bottom: 10px;
            width: fit-content;
            max-width: 75%;
            margin-right: 40px;
            font-size: 14px;
            line-height: 1.4;
        }

        #chatbot-input-area {
            display: flex;
            border-top: 1px solid #ddd;
        }

        #chatbot-input {
            flex: 1;
            border: none;
            padding: 12px;
            outline: none;
        }

        #chatbot-send {
            border: none;
            background: #FF5A4F;
            color: white;
            width: 60px;
        }

        .quick-options {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 10px;
            margin-right: 40px;
            justify-content: flex-start;
        }

        .quick-btn {
            border: 1px solid #f7827a;
            color: #f7827a;
            background: #fff;
            border-radius: 20px;
            padding: 6px 12px;
            cursor: pointer;
            font-size: 13px;
            transition: all .2s ease;
        }


        .quick-btn:hover {
            background: #f8f2f2;
            border-color: #f8c8c8;
            color: #f7827a;
        }

        .quick-btn:active {
            background: #fff2f1;
        }

        #chatbot-empty-state {
            text-align: center;
            padding: 10px 20px 5px;
        }

        #chatbot-empty-state .bi-robot {
            font-size: 60px;
            color: #FF5A4F;
            display: block;
            margin-bottom: 5px;
        }

        #chatbot-empty-state h5 {
            font-weight: 700;
            margin-top: 0;
            margin-bottom: 8px;
        }

        #chatbot-empty-state p {
            color: #777;
            font-size: 10px;
        }

        .typing-indicator {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #cfd8df;
            padding: 16px 18px;
            border-radius: 20px;
            margin-bottom: 10px;
            position: relative;
            width: fit-content;
        }

        /* chat bubble tail */
        .typing-indicator::before {
            content: '';
            position: absolute;
            left: -6px;
            bottom: 8px;
            width: 12px;
            height: 12px;
            background: #cfd8df;
            border-radius: 0 0 0 10px;
            transform: rotate(45deg);
        }

        .typing-indicator span {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #7a7a7a;
            display: block;
            animation: typingBounce 1.4s infinite ease-in-out;
        }

        .typing-indicator span:nth-child(1) {
            animation-delay: 0s;
        }

        .typing-indicator span:nth-child(2) {
            animation-delay: 0.2s;
        }

        .typing-indicator span:nth-child(3) {
            animation-delay: 0.4s;
        }

        #destination-suggestions {
            background: #fff;
            border: 1px solid #ddd;
            max-height: 180px;
            overflow-y: auto;
            display: none;
        }

        .destination-item {
            padding: 10px;
            cursor: pointer;
            transition: .2s ease;
        }

        .destination-item:hover {
            background: #f7827a;
        }

        @keyframes typingBounce {

            0%,
            80%,
            100% {
                transform: translateY(0);
                opacity: .4;
            }

            40% {
                transform: translateY(-5px);
                opacity: 1;
            }
        }

        .typing-indicator span {
            height: 8px;
            width: 8px;
            background: #888;
            border-radius: 50%;
            display: inline-block;
            margin: 0 2px;
            animation: bounce 1.4s infinite ease-in-out both;
        }

        .typing-indicator span:nth-child(1) {
            animation-delay: -0.32s;
        }

        .typing-indicator span:nth-child(2) {
            animation-delay: -0.16s;
        }

        #chatbot-input:disabled {
            background: #f3f3f3;
            cursor: not-allowed;
        }

        #chatbot-send:disabled {
            opacity: .6;
            cursor: not-allowed;
        }

        @media (max-width: 467px) {

            #chatbot-box {
                width: 300px;
                height: 95vh;
                max-width: 420px;
                ;
                max-height: none;
                right: 10px;
                height: 85vh;
                bottom: 10px;
                border-radius: 15px;
            }

            #chatbot-toggle {
                width: 55px;
                height: 55px;
                bottom: 15px;
                right: 15px;
            }

            #chatbot-messages {
                padding: 8px;
            }

            .bot-message {
                max-width: 85%;
                margin-right: 20px;
                font-size: 14px;
            }

            .user-message {
                max-width: 80%;
                font-size: 14px;
            }

            .quick-btn {
                font-size: 13px;
                padding: 6px 10px;
                white-space: normal;
                text-align: center;
            }
        }

        #chatbot-input {
            font-size: 14px;
            padding: 10px;
        }

        #chatbot-send {
            width: 55px;
        }
        }

        @keyframes bounce {

            0%,
            80%,
            100% {
                transform: scale(0);
            }

            40% {
                transform: scale(1);
            }
        }
    </style>
    <script>
        window.selectQuickOption = function (option) {

            document
                .querySelectorAll('.quick-options')
                .forEach(el => el.remove());

            document.getElementById('chatbot-input').value = option;

            document.getElementById('chatbot-send').click();
        }

        window.selectDestination = function (place) {

            document.getElementById(
                'destination-suggestions'
            ).style.display = 'none';

            document.getElementById('chatbot-input').value = place;

            document.getElementById('chatbot-send').click();
        }

        document.addEventListener('DOMContentLoaded', function () {

            const toggle = document.getElementById('chatbot-toggle');
            const box = document.getElementById('chatbot-box');
            const closeBtn = document.getElementById('chatbot-close');
            const sendBtn = document.getElementById('chatbot-send');
            const input = document.getElementById('chatbot-input');
            const messages = document.getElementById('chatbot-messages');
            const suggestionBox = document.getElementById('destination-suggestions');
            let selectedTripType = null;

            let currentStep = "trip_type";

            let leadData = {
                help_type: '',
                travel_date: '',
                departure_city: '',
                trip_type: '',
                destination: '',
                budget: '',
                travel_month: '',
                duration: '',
                name: '',
                phone: '',
                email: '',
                adults: '',
                children: '',
                hotel_category: '',
                flight_required: '',
                package_need: '',
                package_type: '',
                whatsapp_updates: '',
            };

            function addBotMessage(text) {
                messages.innerHTML += `
            <div class="bot-message">${text}</div>
        `;
            }
            function botReply(message, options = null, nextStep = null) {

                messages.innerHTML += `
            <div class="typing-indicator">
                <span></span>
                <span></span>
            </div>
        `;

                scrollBottom();

                input.disabled = true;
                sendBtn.disabled = true;

                setTimeout(() => {

                    removeTyping();

                    addBotMessage(message);

                    if (options) {
                        showQuickOptions(options);
                    }

                    if (nextStep) {
                        currentStep = nextStep;
                    }

                    scrollBottom();

                }, 600);
            }
            function removeTyping() {
                document.querySelectorAll('.typing-indicator')
                    .forEach(el => el.remove());
                input.disabled = false;
                sendBtn.disabled = false;
                input.focus();
            }

            function scrollBottom() {
                messages.scrollTo({
                    top: messages.scrollHeight,
                    behavior: 'smooth'
                });
            }

            function buildConversation() {
                return Array.from(messages.querySelectorAll('.user-message, .bot-message'))
                    .map(message => ({
                        sender: message.classList.contains('user-message') ? 'user' : 'bot',
                        message: message.textContent.trim().replace(/\s+/g, ' ')
                    }))
                    .filter(message => message.message.length);
            }

            function showQuickOptions(options) {

                let html = '<div class="quick-options">';

                options.forEach(option => {
                    let label = option;

                    if (currentStep === 'trip_type') {

                        const labels = {
                            honeymoon: 'Yes! A honeymoon trip',
                            family: 'Yes! For a family trip',
                            religiuos: 'Yes! A religious trip',
                            friends: 'Yes! For a trip with my friends',
                            solo: 'For a solo trip',
                            adventure: 'Yes! An adventure trip',
                            nature: 'Yes! A nature trip',
                            'water activities': 'For water activities',
                            'corporate tour': 'Yes! A corporate tour'
                        };

                        label = labels[option.toLowerCase()] || option;
                    }

                    html += `
                <button class="quick-btn"
                    onclick="selectQuickOption('${option}')">
                    
                    ${label}
                </button>
            `;
                });

                html += '</div>';

                messages.innerHTML += html;
                scrollBottom();

            }

            input.addEventListener('input', function () {

                if (
                    currentStep !== 'destination' &&
                    currentStep !== 'tentative_destination'
                ) {
                    return;
                }

                let q = this.value.trim();

                if (q.length < 1) {
                    suggestionBox.style.display = 'none';
                    return;
                }

                fetch('/chatbot/search-destinations?q=' + q)
                    .then(res => res.json())
                    .then(data => {

                        let html = '';

                        data.forEach(place => {

                            html += `
                    <div class="destination-item"
                        onclick="selectDestination('${place}')">
                        ${place}
                    </div>
                `;
                        });

                        suggestionBox.innerHTML = html;
                        suggestionBox.style.display = 'block';
                    });
            });
            let initialized = false;

            toggle.addEventListener('click', () => {

                box.style.display = 'flex';

                if (!initialized) {

                    addBotMessage(
                        "Hey 👋 I' m here to help you plan your perfect trip. Let's get started!"
                    );

                    fetch('/chatbot/travel-styles')
                        .then(res => res.json())
                        .then(data => {
                            showQuickOptions(data);
                            scrollBottom();
                        });


                    initialized = true;
                }
            });

            closeBtn.addEventListener('click', () => {
                box.style.display = 'none';
            });

            sendBtn.addEventListener('click', sendMessage);

            input.addEventListener('keypress', function (e) {
                if (e.key === 'Enter') {
                    sendMessage();
                }
            });

            function sendMessage() {
                const emptyState = document.getElementById('chatbot-empty-state');

                if (emptyState) {
                    emptyState.remove();
                }

                let text = input.value.trim();
                suggestionBox.style.display = 'none';
                suggestionBox.innerHTML = '';

                if (currentStep === "trip_type") {

                    selectedTripType = text;

                    leadData.trip_type = text;

                    messages.innerHTML +=
                        `<div class="user-message">
                    Yes! A ${text} trip
                </div>`;

                    input.value = '';

                    botReply(
                        'How can I help you plan your trip today?',
                        [
                            'Help me in deciding my destination',
                            'Calculate budget for my trip',
                            'Create best package for my trip',
                            'Plan day to day activity for my trip'
                        ],
                        'help_type'
                    );
                    return;
                }

                if (currentStep === "help_type") {

                    leadData.help_type = text;

                    messages.innerHTML +=
                        `<div class="user-message">${text}</div>`;

                    input.value = '';

                    if (text === 'Help me in deciding my destination') {

                        botReply(
                            "Do you already have a destination in mind? Tell me where you'd like to go.",
                            null,
                            'tentative_destination'
                        );
                        return;
                    }

                    botReply(
                        'Have you already chosen your destination?',
                        ['Yes', 'No'],
                        'destination_decision'
                    );

                    return;
                }

                if (currentStep === "destination_decision") {

                    messages.innerHTML +=
                        `<div class="user-message">${text}</div>`;

                    input.value = '';

                    if (text === 'Yes') {

                        botReply(
                            'Awesome! Which destination are you planning to visit?',
                            null,
                            'destination'
                        );

                    } else {

                        botReply(
                            'Tell me your tentative destination.',
                            null,
                            'tentative_destination'
                        );
                    }

                    return;
                }

                if (currentStep === "tentative_destination") {

                    leadData.destination = text;

                    messages.innerHTML +=
                        `<div class="user-message">${text}</div>`;

                    input.value = '';

                    const natureKeywords = [
                        'nature',
                        'cold',
                        'mountain',
                        'hill station',
                        'snow',
                        'beach',
                        'adventure'
                    ];

                    const query = text.toLowerCase();

                    let suggestions = [];

                    if (
                        query.includes('cold') ||
                        query.includes('snow') ||
                        query.includes('hill') ||
                        query.includes('mountain')
                    ) {
                        suggestions = [
                            'Kashmir',
                            'Manali',
                            'Shimla',
                            'Sikkim',
                            'Auli',
                            'Dharamshala'
                        ];
                    }
                    else if (
                        query.includes('nature') ||
                        query.includes('greenery') ||
                        query.includes('peace')
                    ) {
                        suggestions = [
                            'Kerala',
                            'Munnar',
                            'Coorg',
                            'Sikkim',
                            'Meghalaya',
                            'Ooty'
                        ];
                    }
                    else if (
                        query.includes('beach') ||
                        query.includes('sea')
                    ) {
                        suggestions = [
                            'Goa',
                            'Andaman',
                            'Pondicherry',
                            'Gokarna',
                            'Kovalam',
                            'Varkala'
                        ];
                    }
                    else if (
                        query.includes('adventure') ||
                        query.includes('trek')
                    ) {
                        suggestions = [
                            'Rishikesh',
                            'Ladakh',
                            'Spiti Valley',
                            'Manali',
                            'Kasol',
                            'Bir Billing'
                        ];
                    }

                    if (suggestions.length) {

                        botReply(
                            "Based on your preference, here are some destinations you may like:",
                            suggestions,
                            'destination_selection'
                        );

                        return;
                    }

                    botReply(
                        'Is your departure date fixed?',
                        ['Yes', 'No'],
                        'date_fixed'

                    );
                    return;
                }

                if (currentStep === "destination_selection") {

                    leadData.destination = text;

                    messages.innerHTML +=
                        `<div class="user-message">${text}</div>`;

                    input.value = '';

                    botReply(
                        'Have you finalized your travel dates?',
                        ['Yes', 'Not Yet'],
                        'date_fixed'
                    );
                    return;
                }

                if (currentStep === "date_fixed") {
                    console.log('DURATION HIT', text);

                    messages.innerHTML +=
                        `<div class="user-message">${text}</div>`;

                    input.value = '';

                    if (text === 'Yes') {

                        botReply(
                            "Great! What's your planned departure date? (e.g. 20 May 2026)",
                            null,
                            'travel_date'
                        );

                        return;
                    }

                    botReply(
                        'Which month are you planning your trip in?',
                        [
                            'January',
                            'February',
                            'March',
                            'April',
                            'May',
                            'June',
                            'July',
                            'August',
                            'September',
                            'October',
                            'November',
                            'December'
                        ],
                        'travel_month'
                    );
                    return;
                }
                if (currentStep === "destination") {

                    leadData.destination = text;

                    messages.innerHTML +=
                        `<div class="user-message">${text}</div>`;

                    input.value = '';

                    botReply(
                        'Have you finalized your travel dates?',
                        ['Yes', 'Not Yet'],
                        'date_fixed'
                    );
                    return;
                }

                if (currentStep === 'travel_date') {

                    messages.innerHTML +=
                        `<div class="user-message">${text}</div>`;

                    input.value = '';

                    const selectedDate = new Date(text);
                    const today = new Date();

                    today.setHours(0, 0, 0, 0);

                    if (
                        isNaN(selectedDate.getTime()) ||
                        selectedDate < today
                    ) {

                        botReply(
                            'Oops! Please enter a valid travel date.'
                        );

                        return;
                    }

                    leadData.travel_date = text;

                    botReply(
                        'How long would you like your trip to be?',
                        [
                            '2-3 Days',
                            '4-5 Days',
                            '6-7 Days',
                            '7+ Days'
                        ],
                        'duration'
                    );
                    return;
                }


                if (currentStep === 'travel_month') {

                    messages.innerHTML +=
                        `<div class="user-message">${text}</div>`;

                    input.value = '';

                    leadData.travel_month = text;

                    botReply(
                        'How long would you like your trip to be?',
                        [
                            '2-3 Days',
                            '4-5 Days',
                            '6-7 Days',
                            '7+ Days'
                        ],
                        'duration'
                    );

                    return;
                }
                if (currentStep === 'duration') {
                    console.log('DURATION HIT', text);

                    messages.innerHTML +=
                        `<div class="user-message">${text}</div>`;

                    input.value = '';

                    leadData.duration = text;
                    botReply(
                        'Done. How many adults (12+ years) are planning to go?',
                        [
                            '1',
                            '2',
                            '3-5',
                            '5+'
                        ],
                        'adults'
                    );

                    return;
                }

                if (currentStep === 'adults') {

                    messages.innerHTML +=
                        `<div class="user-message">${text}</div>`;

                    input.value = '';

                    leadData.adults = text;

                    botReply(
                        'Done. And how many children (0-12 yrs) are traveling with you?',
                        [
                            '0',
                            '1',
                            '2',
                            '3',
                            '4+'
                        ],
                        'children'
                    );
                    return;
                }

                if (currentStep === 'children') {

                    messages.innerHTML +=
                        `<div class="user-message">${text}</div>`;

                    input.value = '';

                    leadData.children = text;

                    botReply(
                        'What type of hotel would you prefer for your stay?',
                        [

                            'Luxury',
                            '5 Star',
                            '4 Star',
                            '3 Star',
                            '2 Star',
                            'Stay not required'
                        ],
                        'hotel_category'
                    );

                    return;
                }

                if (currentStep === 'hotel_category') {

                    messages.innerHTML +=
                        `<div class="user-message">${text}</div>`;

                    input.value = '';

                    leadData.hotel_category = text;

                    botReply(
                        'Have you already booked your flight/train tickets?',
                        [
                            'Yes',
                            'Not Yet'
                        ],
                        'flight_required'

                    );

                    return;
                }

                if (currentStep === 'flight_required') {

                    messages.innerHTML +=
                        `<div class="user-message">${text}</div>`;

                    input.value = '';

                    leadData.flight_required = text;

                    botReply(
                        'May I know where you would be leaving from?',
                        [
                            'New Delhi',
                            'Mumbai',
                            'Bengaluru',
                            'Hyderabad',
                            'Chennai',
                            'Kolkata',
                            'Pune',
                            'Other City'
                        ],
                        'departure_city'
                    );

                    return;
                }

                if (currentStep === 'departure_city') {

                    messages.innerHTML +=
                        `<div class="user-message">${text}</div>`;

                    input.value = '';

                    leadData.departure_city = text;

                    botReply(
                        "What's your approximate budget per person?",
                        [
                            'Under ₹10,000',
                            '₹10,000 - ₹20,000',
                            '₹20,000 - ₹30,000',
                            'Above ₹30,000'
                        ],
                        'budget'
                    );

                    return;
                }

                if (currentStep === 'budget') {
                    messages.innerHTML +=
                        `<div class="user-message">${text}</div>`;

                    input.value = '';
                    leadData.budget = text;

                    botReply(
                        'What would you like us to include in your package?',
                        [
                            'Hotel Only',
                            'Hotel + Private Cab',
                            'Hotel + Private Cab + Flights',
                            'Hotel + Flights',
                            'Other'
                        ],
                        'package_need'
                    );

                    return;
                }

                if (currentStep === 'package_need') {
                    messages.innerHTML +=
                        `<div class="user-message">${text}</div>`;

                    input.value = '';

                    leadData.package_need = text;

                    botReply(
                        'What kind of package are you looking for?',
                        [
                            'Non-Customizable Bestselling Packages',
                            'Customized to my needs'
                        ],
                        'package_type'
                    );

                    return;
                }

                if (currentStep === 'package_type') {
                    messages.innerHTML +=
                        `<div class="user-message">${text}</div>`;

                    input.value = '';

                    leadData.package_type = text;

                    botReply(
                        'Would you like to receive updates on WhatsApp?',
                        [
                            'Yes',
                            'No'
                        ],
                        'whatsapp_updates'
                    );
                    return;
                }

                if (currentStep === 'whatsapp_updates') {
                    messages.innerHTML +=
                        `<div class="user-message">${text}</div>`;

                    input.value = '';

                    leadData.whatsapp_updates = text;
                    botReply(
                        'May I have your name, please?',
                        null,
                        'name'
                    );

                    return;
                }

                if (currentStep === 'name') {
                    messages.innerHTML +=
                        `<div class="user-message">${text}</div>`;

                    input.value = '';

                    leadData.name = text;

                    botReply(
                        "What's the best number to reach you on?",
                        null,
                        'phone'
                    );
                    return;
                }

                if (currentStep === 'phone') {
                    messages.innerHTML +=
                        `<div class="user-message">${text}</div>`;

                    input.value = '';
                    const phoneRegex = /^[6-9]\d{9}$/;

                    if (!phoneRegex.test(text)) {

                        botReply(
                            '⚠️ Please enter a valid 10-digit mobile number.'
                        );

                        return;
                    }
                    leadData.phone = text;

                    botReply(
                        "And finally, what's your email address?",
                        null,
                        'email'
                    );

                    return;
                }

                if (currentStep === 'email') {
                    messages.innerHTML +=
                        `<div class="user-message">${text}</div>`;

                    input.value = '';
                    const emailRegex =
                        /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                    if (!emailRegex.test(text)) {

                        botReply(
                            '⚠️ Please enter a valid email address.'
                        );

                        return;
                    }

                    leadData.email = text;
                    leadData.conversation = buildConversation();

                    fetch('/chatbot/save-lead', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(leadData)
                    })
                        .then(res => {
                            if (!res.ok) {
                                throw new Error('Unable to save chatbot lead.');
                            }

                            return res.json();
                        })
                        .then(() => {
                            botReply(
                                'Thank you! Our travel expert will reach out to you shortly.',
                                null,
                                'completed'
                            );
                        })
                        .catch(() => {
                            botReply(
                                'Sorry, I could not save your details right now. Please try again.',
                                null,
                                'email'
                            );
                        });
                    return;
                }

                if (!text) return;

                messages.innerHTML +=
                    `<div class="user-message">${text}</div>`;

                input.value = '';

                let apiMessage = text;

                if (currentStep === "destination" && selectedTripType) {
                    apiMessage = selectedTripType + " " + text;
                }


                // SHOW TYPING
                messages.innerHTML += `
        <div class="typing-indicator">
            <span></span>
             <span></span>
            <span></span>
        </div>
        `;
                input.disabled = true;
                sendBtn.disabled = true;

                messages.scrollTop = messages.scrollHeight;

                fetch('/chat', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },

                    body: JSON.stringify({
                        message: apiMessage
                    })
                })
                    .then(res => res.json())
                    .then(data => {
                        removeTyping();

                        messages.innerHTML +=
                            `<div class="bot-message">${data.answer}</div>`;

                        messages.scrollTop = messages.scrollHeight;
                    });
            }

        });
    </script>
    @stack('styles')

</head>

<body style="overflow-x: hidden;">

    @include('partials.header')

    @yield('content')

    @include('partials.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

    <!-- App JS -->

    <!-- Testimonials CSS/JS -->
    <link rel="stylesheet" href="{{ asset('css/testimonials-section.css') }}">
    <script src="{{ asset('js/testimonials-section.js') }}" defer></script>
    <!-- Destination Filter JS -->
    <script src="{{ asset('js/destination-filter.js') }}" defer></script>
    <!-- Carousel JS -->
    <script src="{{ asset('js/carousel.js') }}" defer></script>
    <script src="{{ asset('js/script.js') }}" defer></script>
    @stack('scripts')


</body>

</html>
