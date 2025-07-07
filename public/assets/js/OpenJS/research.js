document.addEventListener('DOMContentLoaded', function() {
    // Calendar data
    const eventsData = [
        {
            day: 5,
            month: 5,
            year: 2025,
            title: 'STUDENT ART FAIR',
            time: '10AM - 4PM',
            description: 'Join us for showcasing new talent & skills at PLP Campus Student Art Exhibition. All are welcome to attend and show support.',
            highlight: true
        },
        {
            day: 7,
            month: 5,
            year: 2025,
            title: 'MOVIE NIGHT: THE GRADUAL THEORY',
            time: '5:00PM',
            description: 'We all know the film, but it\'s awesome and it\'s shockingly fun to talk about it during viewing. Come over and chat!',
            highlight: false
        },
        {
            day: 14,
            month: 5,
            year: 2025,
            title: 'SEMESTER 1 WRAP UP',
            time: '10AM',
            description: 'We\'ll have a free time where we can do the bit we need to discuss with your pals. Open on WED 14th.',
            highlight: true
        },
        {
            day: 21,
            month: 5,
            year: 2025,
            title: 'TIME TO CONSOLIDATE',
            time: '9AM',
            description: 'Professors solving forms, grad protocol and admin matters are happening today. Please secure your documents.',
            highlight: true
        },
        {
            day: 24,
            month: 5,
            year: 2025,
            title: 'RESEARCH SYMPOSIUM',
            time: '10AM - 3PM',
            description: 'Annual Research Symposium featuring student and faculty research presentations and posters.',
            highlight: true
        },
        {
            day: 31,
            month: 5,
            year: 2025,
            title: 'FINAL YEAR MEETING',
            time: '10AM',
            description: 'We\'ll have a free time where we can do the bit we need to discuss with your pals.',
            highlight: false
        }
    ];

    // Get today's date
    const today = new Date();
    
    // Current displayed month/year - initialize with today's date
    let currentMonth = today.getMonth(); // 0-based (0 = January, 11 = December)
    let currentYear = today.getFullYear();
    
    // Today's day
    const todayDay = today.getDate();
    
    // Selected date (for filtering)
    let selectedDay = null;
    
    // Month names for header
    const monthNames = [
        'JANUARY', 'FEBRUARY', 'MARCH', 'APRIL', 'MAY', 'JUNE',
        'JULY', 'AUGUST', 'SEPTEMBER', 'OCTOBER', 'NOVEMBER', 'DECEMBER'
    ];

    // Get root CSS variables
    const rootStyles = getComputedStyle(document.documentElement);
    const primaryColor = rootStyles.getPropertyValue('--primary-color').trim();
    const plpYellow = rootStyles.getPropertyValue('--plp-yellow').trim();

    // Handle section navigation
    const navLinks = document.querySelectorAll('.research-nav .nav-link');
    const sections = document.querySelectorAll('section[id]');

    // Add click event listeners for section navigation
    if (navLinks && navLinks.length > 0) {
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1); // Remove the # from href
            
            // Remove active class from all nav links
            navLinks.forEach(navLink => navLink.classList.remove('active'));
            // Add active class to clicked link
            this.classList.add('active');
            
            // Hide all sections first
            sections.forEach(section => {
                section.classList.remove('active');
                section.style.display = 'none';
            });
            
            // Show only the target section
            const targetSection = document.getElementById(targetId);
            if (targetSection) {
                targetSection.classList.add('active');
                targetSection.style.display = 'block';
                // Scroll to section
                window.scrollTo({
                    top: targetSection.offsetTop - 80,
                    behavior: 'smooth'
                });
            }
        });
    });
    }
    
    // Calendar navigation buttons
    const prevMonthBtn = document.querySelector('.month-nav-btn.prev');
    const nextMonthBtn = document.querySelector('.month-nav-btn.next');
    const currentMonthDisplay = document.querySelector('.current-month');
    const monthSelector = document.querySelector('.month-selector');
    const monthDropdown = document.querySelector('#monthDropdown');
    const monthOptions = document.querySelectorAll('.month-option');
    
    // Toggle month dropdown when clicking on the month display
    if (monthSelector) {
        monthSelector.addEventListener('click', function(e) {
            monthDropdown.classList.toggle('active');
            e.stopPropagation(); // Prevent event bubbling
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!monthSelector.contains(e.target)) {
                monthDropdown.classList.remove('active');
            }
        });
        
        // Handle month selection
        monthOptions.forEach(option => {
            option.addEventListener('click', function() {
                const selectedMonth = parseInt(this.getAttribute('data-month'));
                
                // Update calendar to the selected month (keeping the same year)
                currentMonth = selectedMonth;
                
                // Reset selected day when changing months
                selectedDay = null;
                
                // Close dropdown
                monthDropdown.classList.remove('active');
                
                updateMonthDisplay();
                updateCalendarGrid();
                filterEvents();
                updateFilterInfo();
            });
        });
    }
    
    if (prevMonthBtn) {
        prevMonthBtn.addEventListener('click', () => {
            navigateMonth(-1);
        });
    }
    
    if (nextMonthBtn) {
        nextMonthBtn.addEventListener('click', () => {
            navigateMonth(1);
        });
    }
    
    // Function to navigate through months
    function navigateMonth(direction) {
        currentMonth += direction;
        
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        } else if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        
        // Reset selected day when changing months
        selectedDay = null;
        
        updateMonthDisplay();
        updateCalendarGrid(); // Update the calendar grid when changing months
        filterEvents();
        updateFilterInfo(); // Directly call updateFilterInfo to ensure it gets updated
    }
    
    // Update the month display in the header
    function updateMonthDisplay() {
        if (currentMonthDisplay) {
            currentMonthDisplay.textContent = `${monthNames[currentMonth]} ${currentYear}`;
            currentMonthDisplay.style.color = primaryColor;
        }
    }
    
    // Function to update the calendar grid with the current month's days
    function updateCalendarGrid() {
        const calendarGrid = document.querySelector('.calendar-days-grid');
        if (!calendarGrid) return;
        
        // Clear existing grid
        calendarGrid.innerHTML = '';
        
        // Get the first day of the month (0 = Sunday, 1 = Monday, etc.)
        const firstDayOfMonth = new Date(currentYear, currentMonth, 1).getDay();
        // Adjust for Monday as first day (0 = Monday, 6 = Sunday)
        const firstDayAdjusted = firstDayOfMonth === 0 ? 6 : firstDayOfMonth - 1;
        
        // Get the last day of the month
        const lastDayOfMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
        
        // Get the last day of the previous month
        const lastDayOfPrevMonth = new Date(currentYear, currentMonth, 0).getDate();
        
        // Add days from previous month
        for (let i = 0; i < firstDayAdjusted; i++) {
            const day = lastDayOfPrevMonth - firstDayAdjusted + i + 1;
            const dayElement = document.createElement('div');
            dayElement.className = 'calendar-day prev-month';
            dayElement.textContent = day;
            calendarGrid.appendChild(dayElement);
        }
        
        // Add days of current month
        for (let day = 1; day <= lastDayOfMonth; day++) {
            const dayElement = document.createElement('div');
            dayElement.className = 'calendar-day';
            dayElement.textContent = day;
            dayElement.setAttribute('data-day', day);
            
            // Check if this day has an event
            const hasEvent = eventsData.some(event => 
                event.day === day && 
                event.month - 1 === currentMonth && 
                event.year === currentYear
            );
            
            if (hasEvent) {
                dayElement.classList.add('has-event');
            }
            
            // Highlight today's date if we're in the current month and year
            if (day === todayDay && 
                currentMonth === today.getMonth() && 
                currentYear === today.getFullYear()) {
                dayElement.classList.add('today');
            }
            
            // Add click event listener
            dayElement.addEventListener('click', function() {
                // Skip prev/next month days
                if (this.classList.contains('prev-month') || this.classList.contains('next-month')) {
                    return;
                }
                
                // Remove highlight from all days
                document.querySelectorAll('.calendar-day').forEach(d => {
                    if (!d.classList.contains('has-event')) {
                        d.classList.remove('highlight');
                    }
                });
                
                // Toggle highlight on clicked day
                this.classList.toggle('highlight');
                
                // Set selected day or clear if already selected
                if (this.classList.contains('highlight')) {
                    selectedDay = parseInt(this.textContent);
                    
                    // Check if this day has an event
                    if (hasEvent) {
                        // Show popup with event details
                        showEventPopup(this, selectedDay);
                    } else {
                        // Hide popup if no event
                        hideEventPopup();
                    }
                } else {
                    selectedDay = null;
                    // Hide popup when deselecting
                    hideEventPopup();
                }
                
                // Filter events based on selection
                filterEvents();
            });
            
            calendarGrid.appendChild(dayElement);
        }
        
        // Calculate how many days from next month to show
        const totalCells = 42; // 6 rows * 7 days
        const cellsFilled = firstDayAdjusted + lastDayOfMonth;
        const remainingCells = totalCells - cellsFilled;
        
        // Add days from next month
        for (let day = 1; day <= remainingCells; day++) {
            const dayElement = document.createElement('div');
            dayElement.className = 'calendar-day next-month';
            dayElement.textContent = day;
            calendarGrid.appendChild(dayElement);
        }
    }
    
    // Handle calendar day clicks
    const calendarDays = document.querySelectorAll('.calendar-day');
    const dayEventPopup = document.querySelector('.day-event-popup');
    const closePopupButton = document.querySelector('.day-event-popup-close');

    if (calendarDays && calendarDays.length > 0) {
        calendarDays.forEach(day => {
            day.addEventListener('click', function(e) {
                // Skip prev/next month days
                if (this.classList.contains('prev-month') || this.classList.contains('next-month')) {
                    return;
                }
                
                // Remove highlight from all days
                calendarDays.forEach(d => {
                    if (!d.classList.contains('has-event')) {
                        d.classList.remove('highlight');
                    }
                });
                
                // Toggle highlight on clicked day
                this.classList.toggle('highlight');
                
                // Set selected day or clear if already selected
                if (this.classList.contains('highlight')) {
                    selectedDay = parseInt(this.textContent);
                    
                    // Check if this day has an event
                    const hasEvent = this.classList.contains('has-event');
                    if (hasEvent && dayEventPopup) {
                        // Show popup with event details
                        showEventPopup(this, selectedDay);
                    } else {
                        // Hide popup if no event
                        hideEventPopup();
                    }
                } else {
                    selectedDay = null;
                    // Hide popup when deselecting
                    hideEventPopup();
                }
                
                // Filter events based on selection
                filterEvents();
            });
        });
    }

    if (closePopupButton) {
        closePopupButton.addEventListener('click', function(e) {
            e.stopPropagation(); // Prevent event bubbling
            hideEventPopup();
        });
    }

    // Show event popup with details
    function showEventPopup(dayElement, day) {
        if (!dayEventPopup) return;
        
        // Find event for this day
        const event = eventsData.find(e => e.day === day && e.month - 1 === currentMonth && e.year === currentYear);
        if (!event) return;
        
        // Populate popup content
        const dateElement = dayEventPopup.querySelector('.day-event-popup-date');
        const titleElement = dayEventPopup.querySelector('.day-event-popup-title');
        const timeElement = dayEventPopup.querySelector('.day-event-popup-time');
        const descElement = dayEventPopup.querySelector('.day-event-popup-desc');
        
        if (dateElement) dateElement.textContent = `${monthNames[currentMonth]} ${day}, ${currentYear}`;
        if (titleElement) titleElement.textContent = event.title;
        if (timeElement) timeElement.textContent = event.time;
        if (descElement) descElement.textContent = event.description;
        
        // Position popup near the day element
        const dayRect = dayElement.getBoundingClientRect();
        const calendarRect = document.querySelector('.calendar-grid').getBoundingClientRect();
        
        // Calculate position relative to calendar
        let left = dayRect.left - calendarRect.left + dayRect.width + 10;
        let top = dayRect.top - calendarRect.top;
        
        // Check if popup would overflow right edge of calendar
        if (left + 220 > calendarRect.width) {
            // Position popup to the left of the day
            left = dayRect.left - calendarRect.left - 220 - 10;
        }
        
        // Ensure popup doesn't go off the top or bottom
        if (top + 150 > calendarRect.height) {
            top = calendarRect.height - 150;
        }
        if (top < 0) {
            top = 0;
        }
        
        // Set popup position
        dayEventPopup.style.left = `${left}px`;
        dayEventPopup.style.top = `${top}px`;
        
        // Show popup
        dayEventPopup.classList.add('show');
    }

    // Hide event popup
    function hideEventPopup() {
        if (!dayEventPopup) return;
        dayEventPopup.classList.remove('show');
    }
    
    // Filter events based on selected day/month
    function filterEvents() {
        const eventItems = document.querySelectorAll('.calendar-event-item');
        const noEventsMessage = document.querySelector('.no-events-message') || createNoEventsMessage();
        const eventsContainer = document.querySelector('.events-sidebar');
        
        // Filter events based on month and optionally day
        const filteredEvents = eventsData.filter(event => {
            if (event.month - 1 === currentMonth && event.year === currentYear) {
                return selectedDay ? event.day === selectedDay : true;
            }
            return false;
        });
        
        // Hide all event items first
        eventItems.forEach(item => {
            item.style.display = 'none';
        });
        
        // Show no events message if no events match
        if (filteredEvents.length === 0) {
            noEventsMessage.style.display = 'block';
            noEventsMessage.textContent = selectedDay 
                ? `No events on ${monthNames[currentMonth]} ${selectedDay}, ${currentYear}` 
                : `No events in ${monthNames[currentMonth]} ${currentYear}`;
        } else {
            noEventsMessage.style.display = 'none';
            
            // Show matching events
            filteredEvents.forEach(event => {
                const eventItem = findEventItemByDay(event.day);
                if (eventItem) {
                    eventItem.style.display = 'flex';
                }
            });
            
            // If a specific day is selected, scroll to make the event visible
            if (selectedDay) {
                const selectedEventItem = findEventItemByDay(selectedDay);
                if (selectedEventItem && eventsContainer) {
                    // Scroll the event into view with a small delay to ensure rendering
                    setTimeout(() => {
                        selectedEventItem.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }, 100);
                }
            } else {
                // Reset scroll position when showing all events for a month
                if (eventsContainer) {
                    eventsContainer.scrollTop = 0;
                }
            }
        }
        
        // Update filter info display
        updateFilterInfo();
    }
    
    // Create a "no events" message element if it doesn't exist
    function createNoEventsMessage() {
        const eventsContainer = document.querySelector('.events-sidebar');
        const noEventsMessage = document.createElement('div');
        noEventsMessage.className = 'no-events-message';
        noEventsMessage.style.padding = '20px';
        noEventsMessage.style.textAlign = 'center';
        noEventsMessage.style.color = '#666';
        noEventsMessage.style.fontStyle = 'italic';
        eventsContainer.appendChild(noEventsMessage);
        return noEventsMessage;
    }
    
    // Find event item in DOM by day
    function findEventItemByDay(day) {
        const eventItems = document.querySelectorAll('.calendar-event-item');
        for (let i = 0; i < eventItems.length; i++) {
            const dayElement = eventItems[i].querySelector('.event-day');
            if (dayElement && parseInt(dayElement.textContent) === day) {
                return eventItems[i];
            }
        }
        return null;
    }
    
    // Add filter info display
    function addFilterInfoDisplay() {
        const eventsContainer = document.querySelector('.events-sidebar');
        if (!eventsContainer) return;
        
        const filterInfo = document.createElement('div');
        filterInfo.className = 'filter-info';
        filterInfo.style.padding = '10px 15px';
        filterInfo.style.borderBottom = '1px solid #e0e0e0';
        filterInfo.style.fontSize = '0.9rem';
        filterInfo.style.color = '#666';
        
        // Add text span
        const textSpan = document.createElement('span');
        textSpan.className = 'filter-info-text';
        filterInfo.appendChild(textSpan);
        
        // Add clear button
        const clearButton = document.createElement('button');
        clearButton.textContent = 'Clear Filter';
        clearButton.className = 'clear-filter-btn';
        clearButton.style.border = 'none';
        clearButton.style.background = 'none';
        clearButton.style.color = primaryColor;
        clearButton.style.cursor = 'pointer';
        clearButton.style.fontSize = '0.8rem';
        clearButton.style.fontWeight = 'bold';
        clearButton.style.marginLeft = '10px';
        clearButton.style.padding = '0';
        clearButton.style.display = 'none';
        
        clearButton.addEventListener('click', () => {
            selectedDay = null;
            
            // Remove highlight from all days
            document.querySelectorAll('.calendar-day').forEach(d => {
                if (!d.classList.contains('has-event')) {
                    d.classList.remove('highlight');
                }
            });
            
            filterEvents();
        });
        
        filterInfo.appendChild(clearButton);
        eventsContainer.insertBefore(filterInfo, eventsContainer.firstChild);
    }
    
    // Update filter info display
    function updateFilterInfo() {
        const filterInfo = document.querySelector('.filter-info');
        const clearButton = document.querySelector('.clear-filter-btn');
        
        if (!filterInfo || !clearButton) return;
        
        // Create or get text span
        let textSpan = filterInfo.querySelector('.filter-info-text');
        if (!textSpan) {
            textSpan = document.createElement('span');
            textSpan.className = 'filter-info-text';
            filterInfo.appendChild(textSpan);
        }
        
        if (selectedDay) {
            textSpan.textContent = `Showing events for: ${monthNames[currentMonth]} ${selectedDay}, ${currentYear}`;
            clearButton.style.display = 'inline';
            // Make sure button is in the DOM
            if (!filterInfo.contains(clearButton)) {
                filterInfo.appendChild(clearButton);
            }
        } else {
            textSpan.textContent = `Showing all events for: ${monthNames[currentMonth]} ${currentYear}`;
            clearButton.style.display = 'none';
        }
    }
    
    // Initialize the calendar
    function init() {
        updateMonthDisplay();
        updateCalendarGrid(); // Initialize calendar grid with current month
        
        // Apply event colors
        const eventDays = document.querySelectorAll('.event-day');
        eventDays.forEach(day => {
            day.style.color = plpYellow;
        });
        
        // Add filter info display
        addFilterInfoDisplay();
        
        // Initial filtering
        filterEvents();
    }
    
    // Initial setup
    init();
    
    // Initial active state - show only research office section by default
    if (sections && sections.length > 0) {
        sections.forEach(section => {
            if (section.id !== 'research-office') {
                section.style.display = 'none';
    } else {
                section.style.display = 'block';
                section.classList.add('active');
            }
        });
    }
    
    // If there's a hash in the URL, navigate to that section
    if (window.location.hash) {
        const targetId = window.location.hash.substring(1);
        const targetLink = document.querySelector(`.research-nav .nav-link[href="#${targetId}"]`);
        const targetSection = document.getElementById(targetId);
        
        if (targetLink && targetSection) {
            // Trigger click on the corresponding nav link
            setTimeout(() => {
                targetLink.click();
            }, 100);
        }
    }
});
