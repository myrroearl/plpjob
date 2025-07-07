const daysTag = document.querySelector(".days"),
currentDate = document.querySelector(".current-date"),
prevNextIcon = document.querySelectorAll(".icons span");
// getting new date, current year and month
let date = new Date(),
currYear = date.getFullYear(),
currMonth = date.getMonth();
// storing full name of all months in array
const months = ["January", "February", "March", "April", "May", "June", "July",
              "August", "September", "October", "November", "December"];

// Sample university events 
const universityEvents = [
    { day: 3, month: 2, year: 2025, title: "Brigada Eskuwela Kick-Off for 2nd Semester", status: "past", department: "Student Affairs", time: "9:00 AM - 4:00 PM", location: "Main Campus" },
    { day: 15, month: 2, year: 2025, title: "Annual Research Symposium 2025", status: "past", department: "Research & Development", time: "8:00 AM - 5:00 PM", location: "PLP Auditorium" },
    { day: 28, month: 2, year: 2025, title: "Spring Career Fair 2025", status: "past", department: "Career Services", time: "10:00 AM - 4:00 PM", location: "University Gymnasium" },
    { day: 5, month: 3, year: 2025, title: "Women's Month Celebration", status: "past", department: "Student Affairs", time: "9:00 AM - 3:00 PM", location: "Student Center" },
    { day: 12, month: 3, year: 2025, title: "Science and Technology Week", status: "past", department: "College of Science", time: "8:00 AM - 5:00 PM", location: "Science Building" },
    { day: 7, month: 4, year: 2025, title: "Brigada Eskuwela Kick-Off for 2nd Semester", status: "ongoing", department: "College of Science", time: "8:00 AM - 5:00 PM", location: "Science Building" },
    { day: 15, month: 4, year: 2025, title: "Science and Technology Week", status: "upcoming", department: "College of Science", time: "8:00 AM - 5:00 PM", location: "Science Building" },

];

// Function to check if a date has an event
const hasEvent = (day, month, year) => {
    return universityEvents.some(event => 
        event.day === day && event.month === month + 1 && event.year === year
    );
};

// Function to get event details for a specific date
const getEventDetails = (day, month, year) => {
    return universityEvents.find(event => 
        event.day === day && event.month === month + 1 && event.year === year
    );
};

// Function to get all events for a specific date
const getAllEventsForDate = (day, month, year) => {
    return universityEvents.filter(event => 
        event.day === day && event.month === month + 1 && event.year === year
    );
};

// Function to get event status class
const getEventStatusClass = (status) => {
    switch(status) {
        case 'upcoming': return 'status-upcoming';
        case 'ongoing': return 'status-ongoing';
        case 'past': return 'status-past';
        default: return '';
    }
};

// Function to get event status color
const getEventStatusColor = (status) => {
    switch(status) {
        case 'upcoming': return '#0B7D3F'; // Green
        case 'ongoing': return '#f7d707'; // Yellow
        case 'past': return '#6c757d'; // Gray
        default: return '#032A6D'; // Default blue
    }
};

const renderCalendar = () => {
    let firstDayofMonth = new Date(currYear, currMonth, 1).getDay(), // getting first day of month
    lastDateofMonth = new Date(currYear, currMonth + 1, 0).getDate(), // getting last date of month
    lastDayofMonth = new Date(currYear, currMonth, lastDateofMonth).getDay(), // getting last day of month
    lastDateofLastMonth = new Date(currYear, currMonth, 0).getDate(); // getting last date of previous month
    let liTag = "";
    
    // Add month and year to the header
    currentDate.innerHTML = `<span class="month">${months[currMonth]}</span> <span class="year">${currYear}</span>`;
    
    // Create days for previous month
    for (let i = firstDayofMonth; i > 0; i--) { 
        liTag += `<li class="inactive">${lastDateofLastMonth - i + 1}</li>`;
    }
    
    // Get today's date for comparison
    const today = new Date();
    const isCurrentMonth = currMonth === today.getMonth() && currYear === today.getFullYear();
    const todayDate = today.getDate();
    
    // Create days for current month
    for (let i = 1; i <= lastDateofMonth; i++) { 
        // Check if this is today
        let isToday = isCurrentMonth && i === todayDate ? "active today" : "";
        
        // Check if this day has events
        let eventsForDay = getAllEventsForDate(i, currMonth, currYear);
        let hasEventClass = eventsForDay.length > 0 ? "has-event" : "";
        
        // Determine the primary event status for this day
        let primaryEventStatus = "";
        if (eventsForDay.length > 0) {
            // Prioritize ongoing events, then upcoming, then past
            if (eventsForDay.some(e => e.status === 'ongoing')) {
                primaryEventStatus = 'status-ongoing';
            } else if (eventsForDay.some(e => e.status === 'upcoming')) {
                primaryEventStatus = 'status-upcoming';
            } else {
                primaryEventStatus = 'status-past';
            }
        }
        
        // Create event indicators if there are multiple events
        let eventIndicators = '';
        if (eventsForDay.length > 1) {
            eventIndicators = `<div class="event-indicators">
                ${eventsForDay.slice(0, 3).map(event => 
                    `<span class="event-dot" style="background-color: ${getEventStatusColor(event.status)}"></span>`
                ).join('')}
                ${eventsForDay.length > 3 ? `<span class="event-count">+${eventsForDay.length - 3}</span>` : ''}
            </div>`;
        }
        
        // Get event title for tooltip
        let eventTitle = eventsForDay.length > 0 ? eventsForDay[0].title : "";
        let tooltipAttr = eventTitle ? `title="${eventTitle}"` : "";
        
        // Add today indicator if this is today's date
        let todayIndicator = isToday ? '<span class="today-indicator">Today</span>' : '';
        
        liTag += `<li class="${isToday} ${hasEventClass} ${primaryEventStatus}" ${tooltipAttr}>
            ${i}
            ${todayIndicator}
            ${eventIndicators}
        </li>`;
    }
    
    // Create days for next month
    for (let i = lastDayofMonth; i < 6; i++) { 
        liTag += `<li class="inactive">${i - lastDayofMonth + 1}</li>`
    }
    
    daysTag.innerHTML = liTag;

    // Add click event to all days
    const dayElements = document.querySelectorAll('.days li');
    dayElements.forEach(day => {
        day.addEventListener('click', function() {
            // Remove active class from all days
            dayElements.forEach(d => d.classList.remove('active'));
            
            // Add active class to clicked day
            this.classList.add('active');
            
            // If this day has an event, show a notification
            if (this.classList.contains('has-event')) {
                const dayNumber = this.textContent.trim().split('\n')[0]; // Get just the day number
                const eventsForDay = getAllEventsForDate(parseInt(dayNumber), currMonth, currYear);
                
                // Show event notification
                showEventNotification(eventsForDay, dayNumber);
            }
        });
    });
}

// Function to show event notification
const showEventNotification = (events, dayNumber) => {
    // Check if notification container exists, if not create it
    let notificationContainer = document.querySelector('.calendar-notification');
    
    if (!notificationContainer) {
        notificationContainer = document.createElement('div');
        notificationContainer.className = 'calendar-notification';
        document.querySelector('.wrapper').appendChild(notificationContainer);
    }
    
    // Create notification content
    let notificationContent = `
        <div class="notification-header">
            <h4>Events on ${dayNumber} ${months[currMonth]}</h4>
            <button class="close-notification">&times;</button>
        </div>
        <div class="notification-content">
    `;
    
    // Add each event to the notification
    events.forEach((event, index) => {
        const statusClass = getEventStatusClass(event.status);
        const statusColor = getEventStatusColor(event.status);
        
        notificationContent += `
            <div class="event-item" style="border-left: 3px solid ${statusColor}">
                <div class="event-status ${statusClass}">${event.status.charAt(0).toUpperCase() + event.status.slice(1)}</div>
                <h5>${event.title}</h5>
                <div class="event-details">
                    <p><i class="fas fa-building"></i> <strong>Department:</strong> ${event.department}</p>
                    <p><i class="far fa-clock"></i> <strong>Time:</strong> ${event.time}</p>
                    <p><i class="fas fa-map-marker-alt"></i> <strong>Location:</strong> ${event.location}</p>
                </div>
                ${index < events.length - 1 ? '<hr class="event-divider">' : ''}
            </div>
        `;
    });
    
    notificationContent += `</div>`;
    notificationContainer.innerHTML = notificationContent;
    
    // Show notification with animation
    notificationContainer.classList.add('show');
    
    // Add event listener to close button
    const closeBtn = notificationContainer.querySelector('.close-notification');
    closeBtn.addEventListener('click', () => {
        notificationContainer.classList.remove('show');
    });
    
    // Auto-hide notification after 8 seconds
    setTimeout(() => {
        notificationContainer.classList.remove('show');
        notificationContainer.remove();
    }, 5000);
}

renderCalendar();
prevNextIcon.forEach(icon => { // getting prev and next icons
    icon.addEventListener("click", () => { // adding click event on both icons
        // if clicked icon is previous icon then decrement current month by 1 else increment it by 1
        currMonth = icon.id === "prev" ? currMonth - 1 : currMonth + 1;
        if(currMonth < 0 || currMonth > 11) { // if current month is less than 0 or greater than 11
            // creating a new date of current year & month and pass it as date value
            date = new Date(currYear, currMonth, new Date().getDate());
            currYear = date.getFullYear(); // updating current year with new date year
            currMonth = date.getMonth(); // updating current month with new date month
        } else {
            date = new Date(); // pass the current date as date value
        }
        renderCalendar(); // calling renderCalendar function
    });
});

// Filter Events Dropdown
document.addEventListener('DOMContentLoaded', function() {
    const filterHeader = document.querySelector('.categories-container .header');
    const categoriesList = document.querySelector('.categories-list');

    filterHeader.addEventListener('click', function() {
        this.classList.toggle('active');
        categoriesList.classList.toggle('show');
    });

    // Initialize filter checkboxes
    const filterCheckboxes = document.querySelectorAll('.filter-option input[type="checkbox"]');
    filterCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            filterEvents();
        });
    });
    
    // Function to filter events based on selected criteria
    function filterEvents() {
        const selectedTypes = Array.from(document.querySelectorAll('input[name="type"]:checked')).map(cb => cb.value);
        const selectedDepartments = Array.from(document.querySelectorAll('input[name="department"]:checked')).map(cb => cb.value);
        const selectedPeriods = Array.from(document.querySelectorAll('input[name="period"]:checked')).map(cb => cb.value);
        
        // Get all event cards
        const eventCards = document.querySelectorAll('.event-card');
        
        eventCards.forEach(card => {
            let showCard = true;
            
            // Check if card matches selected filters
            if (selectedTypes.length > 0) {
                const cardType = card.getAttribute('data-type');
                if (!selectedTypes.includes(cardType)) {
                    showCard = false;
                }
            }
            
            if (selectedDepartments.length > 0) {
                const cardDepartment = card.getAttribute('data-department');
                if (!selectedDepartments.includes(cardDepartment)) {
                    showCard = false;
                }
            }
            
            if (selectedPeriods.length > 0) {
                const cardPeriod = card.getAttribute('data-period');
                if (!selectedPeriods.includes(cardPeriod)) {
                    showCard = false;
                }
            }
            
            // Show or hide card based on filter results
            card.style.display = showCard ? 'block' : 'none';
        });
    }
});

// Event data store
const eventData = {
    1: {
        title: "Brigada Eskuwela Kick-Off for 2nd Semester",
        date: "February 3, 2025",
        time: "9:00 AM - 4:00 PM",
        location: "Main Campus",
        department: "Student Affairs",
        status: "upcoming",
        description: "Going back to campus feels extra special when it is not just familiar—it is greener and cleaner! Join us for another impactful edition of Brigada Eskuwela! This semester's kick-off event will focus on sustainable campus beautification and essential maintenance work to ensure our learning spaces are at their best.",
        highlights: [
            "Campus clean-up activities",
            "Gardening and landscaping",
            "Classroom maintenance",
            "Team-building activities",
            "Refreshments for volunteers"
        ],
        venue: "Main Campus, Pamantasan ng Lungsod ng Pasig",
        coordinates: { lat: 14.5764, lng: 121.0851 }
    },
    2: {
        title: "Annual Research Symposium 2025",
        date: "February 15, 2025",
        time: "8:00 AM - 5:00 PM",
        location: "PLP Auditorium",
        department: "Research & Development",
        status: "upcoming",
        description: "Join us for a day of scholarly presentations and discussions featuring groundbreaking research from our faculty and students. The symposium will showcase innovative projects across various disciplines.",
        highlights: [
            "Research paper presentations",
            "Panel discussions",
            "Poster exhibitions",
            "Networking opportunities",
            "Certificate awarding"
        ],
        venue: "PLP Auditorium, Pamantasan ng Lungsod ng Pasig",
        coordinates: { lat: 14.5764, lng: 121.0851 }
    }
};

// Function to show event details
function showEventDetails(element) {
    const eventId = element.dataset.eventId;
    const event = eventData[eventId];
    if (!event) return;

    // Get the events container
    const eventsRemoval = document.querySelector('.events-removal');
    const eventsContainer = document.querySelector('.events-container');
    
    // Get image source if available, otherwise use a default image
    let imageSrc = '';
    if (element.querySelector('img')) {
        imageSrc = element.querySelector('img').src;
    } else {
        // Use a default image based on event type or department
        imageSrc = `assets/images/events/${event.department.toLowerCase().replace(/[^a-z0-9]/g, '-')}.jpg`;
    }

    // CSS
    if (!document.querySelector('link[href="css/events.css"]')) {
        const link = document.createElement('link');
        link.rel = 'stylesheet';
        link.type = 'text/css';
        link.href = 'css/events.css'; // Path to your CSS file
        document.head.appendChild(link);
    }

    // Create the detailed view HTML
    const detailsHTML = `
        <div class="event-details-view">
            <div class="event-details-header d-flex justify-content-between align-items-center mb-4">
                <button class="back-to-events btn btn-link text-decoration-none" onclick="hideEventDetails()">
                    <i class="fas fa-arrow-left"></i> Back
                </button>
            </div>

            <div class="row g-4">
                <div class="col-xl-8">
                    <div class="event-banner mb-4 position-relative">
                        <img src="${imageSrc}" alt="${event.title}" class="img-fluid rounded w-100" style="max-height: 300px; object-fit: cover;" onerror="this.src='assets/images/events/default-event.jpg'">
                        <div class="event-status status-${event.status} position-absolute top-0 end-0 m-3">${event.status}</div>
                    </div>

                    <h2 class="event-title h3 mb-4">${event.title}</h2>

                    <div class="event-meta-grid mb-4">
                        <div class="meta-item d-flex align-items-center mb-2">
                            <i class="far fa-calendar me-2 d-flex align-items-center justify-content-center" style="width: 20px; height: 20px;"></i>
                            <span>${event.date}</span>
                        </div>
                        <div class="meta-item d-flex align-items-center mb-2">
                            <i class="far fa-clock me-2 d-flex align-items-center justify-content-center" style="width: 20px; height: 20px;"></i>
                            <span>${event.time}</span>
                        </div>
                        <div class="meta-item d-flex align-items-center mb-2">
                            <i class="fas fa-map-marker-alt me-2 d-flex align-items-center justify-content-center" style="width: 20px; height: 20px;"></i>
                            <span>${event.location}</span>
                        </div>
                        <div class="meta-item d-flex align-items-center mb-2">
                            <i class="fas fa-users me-2 d-flex align-items-center justify-content-center" style="width: 20px; height: 20px;"></i>
                            <span>${event.department}</span>
                        </div>
                    </div>

                    <div class="event-description mb-4">
                        <h3 class="h5 mb-3">About the Event</h3>
                        <p class="mb-0">${event.description}</p>
                    </div>

                    <div class="event-highlights">
                        <h3 class="h5 mb-3">What to Expect</h3>
                        <ul class="highlights-list ps-3 mb-0">
                            ${event.highlights.map(item => `<li class="mb-2">${item}</li>`).join('')}
                        </ul>
                    </div>
                </div>

                <div class="col-xl-4">
                    <div class="event-sidebar bg-light p-4 rounded">
                        <div class="action-buttons mb-4">
                            <button class="btn btn-primary w-100 mb-3" onclick="handleRegistration()">
                                <i class="fas fa-user-plus me-2"></i> Register Now
                            </button>
                            <button class="btn btn-outline-primary w-100" onclick="handleAddToCalendar()">
                                <i class="far fa-calendar-plus me-2"></i> Add to Calendar
                            </button>
                        </div>

                        <div class="location-info">
                            <h3 class="h5 mb-3">Location</h3>
                            <p class="venue-name mb-3">${event.venue}</p>
                            <div class="event-map rounded" id="eventMap" style="height: 200px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;

    // Hide the events-container content (all event cards)
    eventsContainer.style.display = 'none';
    
    // Create or update event details view
    let detailsView = eventsRemoval.querySelector('.event-details-view');
    if (detailsView) {
        detailsView.outerHTML = detailsHTML;
    } else {
        eventsRemoval.insertAdjacentHTML('beforeend', detailsHTML);
    }

    // Initialize map
    const mapContainer = document.getElementById('eventMap');
    if (mapContainer) {
        initializeMap(mapContainer, event.coordinates);
    }

    // Scroll to top of the details
    eventsRemoval.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

// Function to handle registration
function handleRegistration() {
    // Placeholder for registration functionality
    alert('Registration will be implemented soon. Please check back later.');
}

// Function to handle adding to calendar
function handleAddToCalendar() {
    // Placeholder for calendar functionality
    alert('Calendar integration will be implemented soon. Please check back later.');
}

// Function to hide event details and restore the grid view
function hideEventDetails() {
    const eventsRemoval = document.querySelector('.events-removal');
    const eventsContainer = document.querySelector('.events-container');
    
    // Show the events container again (all event cards)
    eventsContainer.style.display = 'flex';  // or 'block' depending on your CSS
    eventsContainer.classList.add('row');    // Ensure row class is present
    
    // Find and remove the event details view
    const detailsView = eventsRemoval.querySelector('.event-details-view');
    if (detailsView) {
        detailsView.remove();
    }
}

// Function to attach event listeners to the grid items
function attachEventListeners() {
    const eventCards = document.querySelectorAll('.event-card');
    eventCards.forEach(card => {
        card.addEventListener('click', function() {
            showEventDetails(this);
        });
    });
}

// Initialize event listeners when the page loads
document.addEventListener('DOMContentLoaded', function() {
    attachEventListeners();
});

// Function to initialize map (using Google Maps as an example)
function initializeMap(container, coordinates) {
    // Check if Google Maps script is loaded
    if (typeof google === 'undefined') {
        // Load Google Maps script if not already loaded
        const script = document.createElement('script');
        script.src = `https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY`;
        script.async = true;
        script.defer = true;
        script.onload = () => createMap(container, coordinates);
        document.head.appendChild(script);
    } else {
        createMap(container, coordinates);
    }
}

// Function to create the map
function createMap(container, coordinates) {
    const map = new google.maps.Map(container, {
        center: coordinates,
        zoom: 15,
        styles: [
            {
                "featureType": "all",
                "elementType": "geometry",
                "stylers": [{"color": "#f5f5f5"}]
            },
            {
                "featureType": "water",
                "elementType": "geometry",
                "stylers": [{"color": "#e9e9e9"}]
            }
        ]
    });
    
    // Add marker for the location
    new google.maps.Marker({
        position: coordinates,
        map: map,
        title: 'Event Location'
    });
}

// Add click event listeners to calendar buttons
document.addEventListener('DOMContentLoaded', function() {
    const calendarButtons = document.querySelectorAll('.calendar-button');
    calendarButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation();
            // Add event to calendar functionality
            // This is just a placeholder - implement actual calendar integration
            alert('Calendar integration will be implemented here');
        });
    });
    
    const registerButtons = document.querySelectorAll('.register-button');
    registerButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation();
            // Registration functionality
            // This is just a placeholder - implement actual registration
            alert('Registration form will be implemented here');
        });
    });
});