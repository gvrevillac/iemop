<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DSVR Report Downloader</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 800px;
            overflow: hidden;
        }

        .header {
            background: linear-gradient(to right, #4a6fa5, #2c3e50);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 28px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        .header h1 i {
            font-size: 32px;
        }

        .header p {
            opacity: 0.9;
            font-size: 16px;
        }

        .content {
            padding: 40px;
        }

        .date-selector-container {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            margin-bottom: 40px;
        }

        .date-option {
            flex: 1;
            min-width: 250px;
        }

        .date-option h3 {
            color: #2c3e50;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #4a6fa5;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .date-option h3 i {
            color: #4a6fa5;
        }

        /* Calendar Style */
        .calendar-container {
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            padding: 20px;
            background: #f9f9f9;
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .calendar-header button {
            background: #4a6fa5;
            color: white;
            border: none;
            border-radius: 5px;
            width: 30px;
            height: 30px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .calendar-header span {
            font-weight: 600;
            color: #2c3e50;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
        }

        .calendar-day {
            text-align: center;
            padding: 8px 5px;
            font-weight: 600;
            color: #7f8c8d;
            font-size: 14px;
        }

        .calendar-date {
            text-align: center;
            padding: 10px 5px;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .calendar-date:hover {
            background: #e8f4fc;
        }

        .calendar-date.selected {
            background: #4a6fa5;
            color: white;
        }

        .calendar-date.other-month {
            color: #bdc3c7;
        }

        .calendar-date.today {
            border: 2px solid #4a6fa5;
        }

        /* Quick Select */
        .quick-select {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .date-btn {
            padding: 15px;
            background: #f1f8ff;
            border: 2px solid #d1e3ff;
            border-radius: 10px;
            text-align: left;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .date-btn:hover {
            background: #e3f2fd;
            border-color: #4a6fa5;
            transform: translateY(-2px);
        }

        .date-btn i {
            font-size: 20px;
            color: #4a6fa5;
            width: 24px;
        }

        .date-btn .date-label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .date-btn .date-value {
            font-size: 14px;
            color: #7f8c8d;
        }

        /* Custom Date */
        .custom-date {
            background: #f9f9f9;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }

        .custom-date h4 {
            color: #2c3e50;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .custom-date h4 i {
            color: #4a6fa5;
        }

        .custom-date-inputs {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .input-group {
            flex: 1;
            min-width: 150px;
        }

        .input-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
        }

        .input-group input, .input-group select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        .input-group input:focus, .input-group select:focus {
            border-color: #4a6fa5;
            outline: none;
        }

        /* Download Section */
        .download-section {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .selected-date-display {
            background: #e8f4fc;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 15px;
        }

        .selected-date-display i {
            font-size: 24px;
            color: #4a6fa5;
        }

        .selected-date-display span {
            font-size: 18px;
            color: #2c3e50;
            font-weight: 600;
        }

        .download-btn {
            background: linear-gradient(to right, #4a6fa5, #2c3e50);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 18px 40px;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 5px 15px rgba(74, 111, 165, 0.4);
        }

        .download-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(74, 111, 165, 0.6);
        }

        .download-btn:active {
            transform: translateY(-1px);
        }

        .download-btn:disabled {
            background: #cccccc;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .loading {
            display: none;
        }

        .status-message {
            margin-top: 20px;
            padding: 15px;
            border-radius: 8px;
            font-weight: 500;
            display: none;
        }

        .status-message.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            display: block;
        }

        .status-message.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            display: block;
        }

        .footer {
            text-align: center;
            padding: 20px;
            color: #7f8c8d;
            font-size: 14px;
            border-top: 1px solid #eee;
            background: #f9f9f9;
        }

        @media (max-width: 768px) {
            .content {
                padding: 20px;
            }
            
            .date-selector-container {
                flex-direction: column;
            }
            
            .custom-date-inputs {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-file-download"></i> DSVR Report Downloader</h1>
            <p>Download Daily Significant Variations Reports for specific dates</p>
        </div>

        <div class="content">
            <div class="date-selector-container">
                <!-- Calendar Selector -->
                <div class="date-option">
                    <h3><i class="far fa-calendar-alt"></i> Select Date from Calendar</h3>
                    <div class="calendar-container">
                        <div class="calendar-header">
                            <button id="prevMonth"><i class="fas fa-chevron-left"></i></button>
                            <span id="currentMonthYear">May 2025</span>
                            <button id="nextMonth"><i class="fas fa-chevron-right"></i></button>
                        </div>
                        <div class="calendar-grid" id="calendarDays">
                            <!-- Calendar will be populated by JavaScript -->
                        </div>
                    </div>
                </div>

                <!-- Quick Date Selector -->
                <div class="date-option">
                    <h3><i class="fas fa-bolt"></i> Quick Select</h3>
                    <div class="quick-select">
                        <button class="date-btn" data-days="0">
                            <i class="far fa-calendar-check"></i>
                            <div>
                                <div class="date-label">Today</div>
                                <div class="date-value" id="todayDate">May 28, 2025</div>
                            </div>
                        </button>
                        <button class="date-btn" data-days="-1">
                            <i class="fas fa-calendar-day"></i>
                            <div>
                                <div class="date-label">Yesterday</div>
                                <div class="date-value" id="yesterdayDate">May 27, 2025</div>
                            </div>
                        </button>
                        <button class="date-btn" data-days="-7">
                            <i class="fas fa-calendar-week"></i>
                            <div>
                                <div class="date-label">Last Week</div>
                                <div class="date-value" id="lastWeekDate">May 21, 2025</div>
                            </div>
                        </button>
                        <button class="date-btn" data-days="-30">
                            <i class="far fa-calendar"></i>
                            <div>
                                <div class="date-label">Last Month</div>
                                <div class="date-value" id="lastMonthDate">Apr 28, 2025</div>
                            </div>
                        </button>
                    </div>

                    <!-- Custom Date Selector -->
                    <div class="custom-date">
                        <h4><i class="fas fa-calendar-plus"></i> Custom Date</h4>
                        <div class="custom-date-inputs">
                            <div class="input-group">
                                <label for="yearSelect">Year</label>
                                <select id="yearSelect">
                                    <!-- Years will be populated by JavaScript -->
                                </select>
                            </div>
                            <div class="input-group">
                                <label for="monthSelect">Month</label>
                                <select id="monthSelect">
                                    <option value="01">January</option>
                                    <option value="02">February</option>
                                    <option value="03">March</option>
                                    <option value="04">April</option>
                                    <option value="05">May</option>
                                    <option value="06">June</option>
                                    <option value="07">July</option>
                                    <option value="08">August</option>
                                    <option value="09">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                            </div>
                            <div class="input-group">
                                <label for="daySelect">Day</label>
                                <input type="number" id="daySelect" min="1" max="31" placeholder="DD" value="28">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Download Section -->
            <div class="download-section">
                <div class="selected-date-display">
                    <i class="far fa-calendar-check"></i>
                    <span>Selected Date: <span id="selectedDateDisplay">May 28, 2025</span></span>
                </div>

                <button id="downloadBtn" class="download-btn">
                    <i class="fas fa-download"></i>
                    <span>Download DSVR Report</span>
                    <i class="fas fa-spinner fa-spin loading" id="loadingSpinner"></i>
                </button>

                <div id="statusMessage" class="status-message"></div>
            </div>
        </div>

        <div class="footer">
            <p><i class="fas fa-info-circle"></i> Download Daily Significant Variations Reports from IEMOP</p>
            <p>Reports are available from January 2023 onwards</p>
        </div>
    </div>

    <script>
        // Initialize date variables
        let selectedDate = new Date();
        let currentMonth = selectedDate.getMonth();
        let currentYear = selectedDate.getFullYear();

        // DOM Elements
        const calendarDays = document.getElementById('calendarDays');
        const currentMonthYear = document.getElementById('currentMonthYear');
        const prevMonthBtn = document.getElementById('prevMonth');
        const nextMonthBtn = document.getElementById('nextMonth');
        const dateBtns = document.querySelectorAll('.date-btn');
        const yearSelect = document.getElementById('yearSelect');
        const monthSelect = document.getElementById('monthSelect');
        const daySelect = document.getElementById('daySelect');
        const selectedDateDisplay = document.getElementById('selectedDateDisplay');
        const downloadBtn = document.getElementById('downloadBtn');
        const loadingSpinner = document.getElementById('loadingSpinner');
        const statusMessage = document.getElementById('statusMessage');
        const todayDate = document.getElementById('todayDate');
        const yesterdayDate = document.getElementById('yesterdayDate');
        const lastWeekDate = document.getElementById('lastWeekDate');
        const lastMonthDate = document.getElementById('lastMonthDate');

        // Initialize the application
        function init() {
            // Set today's quick select dates
            updateQuickDates();
            
            // Initialize calendar
            renderCalendar();
            
            // Initialize year dropdown (current year + previous 2 years)
            populateYearSelect();
            
            // Set current month in dropdown
            monthSelect.value = (selectedDate.getMonth() + 1).toString().padStart(2, '0');
            daySelect.value = selectedDate.getDate().toString().padStart(2, '0');
            
            // Update selected date display
            updateSelectedDateDisplay();
            
            // Add event listeners
            prevMonthBtn.addEventListener('click', goToPrevMonth);
            nextMonthBtn.addEventListener('click', goToNextMonth);
            
            dateBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const days = parseInt(this.getAttribute('data-days'));
                    selectRelativeDate(days);
                });
            });
            
            yearSelect.addEventListener('change', updateCustomDate);
            monthSelect.addEventListener('change', updateCustomDate);
            daySelect.addEventListener('input', updateCustomDate);
            
            downloadBtn.addEventListener('click', downloadReport);
        }

        // Update quick date buttons
        function updateQuickDates() {
            const today = new Date();
            const yesterday = new Date(today);
            yesterday.setDate(yesterday.getDate() - 1);
            
            const lastWeek = new Date(today);
            lastWeek.setDate(lastWeek.getDate() - 7);
            
            const lastMonth = new Date(today);
            lastMonth.setMonth(lastMonth.getMonth() - 1);
            
            todayDate.textContent = formatDate(today);
            yesterdayDate.textContent = formatDate(yesterday);
            lastWeekDate.textContent = formatDate(lastWeek);
            lastMonthDate.textContent = formatDate(lastMonth);
        }

        // Format date as "Month DD, YYYY"
        function formatDate(date) {
            return date.toLocaleDateString('en-US', { 
                month: 'long', 
                day: 'numeric', 
                year: 'numeric' 
            });
        }

        // Format date as "YYYYMMDD" for filename
        function formatDateForFilename(date) {
            const year = date.getFullYear();
            const month = (date.getMonth() + 1).toString().padStart(2, '0');
            const day = date.getDate().toString().padStart(2, '0');
            return `${year}${month}${day}`;
        }

        // Populate year dropdown
        function populateYearSelect() {
            const currentYear = new Date().getFullYear();
            yearSelect.innerHTML = '';
            
            // Add years from current year down to 2023
            for (let year = currentYear; year >= 2023; year--) {
                const option = document.createElement('option');
                option.value = year;
                option.textContent = year;
                yearSelect.appendChild(option);
            }
            
            yearSelect.value = currentYear;
        }

        // Render calendar for current month/year
        function renderCalendar() {
            // Clear calendar
            calendarDays.innerHTML = '';
            
            // Update month/year display
            const monthNames = [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ];
            currentMonthYear.textContent = `${monthNames[currentMonth]} ${currentYear}`;
            
            // Add day headers
            const dayHeaders = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
            dayHeaders.forEach(day => {
                const dayElement = document.createElement('div');
                dayElement.className = 'calendar-day';
                dayElement.textContent = day;
                calendarDays.appendChild(dayElement);
            });
            
            // Get first day of month and total days
            const firstDay = new Date(currentYear, currentMonth, 1).getDay();
            const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
            const today = new Date();
            
            // Add empty cells for days before the first day of month
            for (let i = 0; i < firstDay; i++) {
                const emptyCell = document.createElement('div');
                emptyCell.className = 'calendar-date other-month';
                calendarDays.appendChild(emptyCell);
            }
            
            // Add days of the month
            for (let day = 1; day <= daysInMonth; day++) {
                const dateCell = document.createElement('div');
                dateCell.className = 'calendar-date';
                dateCell.textContent = day;
                
                // Check if this date is today
                const cellDate = new Date(currentYear, currentMonth, day);
                if (cellDate.toDateString() === today.toDateString()) {
                    dateCell.classList.add('today');
                }
                
                // Check if this date is selected
                if (cellDate.toDateString() === selectedDate.toDateString()) {
                    dateCell.classList.add('selected');
                }
                
                // Add click event
                dateCell.addEventListener('click', () => {
                    selectDate(new Date(currentYear, currentMonth, day));
                });
                
                calendarDays.appendChild(dateCell);
            }
        }

        // Navigate to previous month
        function goToPrevMonth() {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            renderCalendar();
        }

        // Navigate to next month
        function goToNextMonth() {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            renderCalendar();
        }

        // Select a specific date
        function selectDate(date) {
            selectedDate = date;
            updateSelectedDateDisplay();
            
            // Update dropdowns
            yearSelect.value = date.getFullYear();
            monthSelect.value = (date.getMonth() + 1).toString().padStart(2, '0');
            daySelect.value = date.getDate().toString().padStart(2, '0');
            
            // Update calendar if needed
            if (date.getMonth() !== currentMonth || date.getFullYear() !== currentYear) {
                currentMonth = date.getMonth();
                currentYear = date.getFullYear();
                renderCalendar();
            } else {
                // Just re-render calendar to update selection
                renderCalendar();
            }
        }

        // Select relative date (today, yesterday, etc.)
        function selectRelativeDate(daysOffset) {
            const newDate = new Date();
            newDate.setDate(newDate.getDate() + daysOffset);
            selectDate(newDate);
        }

        // Update custom date from dropdowns
        function updateCustomDate() {
            const year = parseInt(yearSelect.value);
            const month = parseInt(monthSelect.value) - 1;
            const day = parseInt(daySelect.value);
            
            // Validate day input
            if (day < 1) daySelect.value = 1;
            if (day > 31) daySelect.value = 31;
            
            const newDate = new Date(year, month, parseInt(daySelect.value));
            
            // Check if date is valid
            if (newDate.getFullYear() === year && 
                newDate.getMonth() === month && 
                newDate.getDate() === parseInt(daySelect.value)) {
                selectDate(newDate);
            }
        }

        // Update selected date display
        function updateSelectedDateDisplay() {
            selectedDateDisplay.textContent = formatDate(selectedDate);
        }

        // Download report function
        async function downloadReport() {
            // Validate date is not in the future
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            const selected = new Date(selectedDate);
            selected.setHours(0, 0, 0, 0);
            
            if (selected > today) {
                showStatus('Cannot download reports for future dates.', 'error');
                return;
            }
            
            // Validate date is after January 2023
            const minDate = new Date(2023, 0, 1); // Jan 1, 2023
            if (selected < minDate) {
                showStatus('Reports are only available from January 2023 onwards.', 'error');
                return;
            }
            
            // Show loading state
            downloadBtn.disabled = true;
            loadingSpinner.style.display = 'inline-block';
            statusMessage.className = 'status-message';
            statusMessage.style.display = 'none';
            
            try {
                // Get date in YYYYMMDD format
                const dateStr = formatDateForFilename(selectedDate);
                
                // Construct the file path
                const filePath = `/var/www/html/wp-content/uploads/downloads/reports/daily-significant-variations-report/DSVR_${dateStr}.pdf`;
                
                // Create base64 hash (encode to base64)
                const fileHash = btoa(filePath);
                
                // Construct the download URL
                const baseUrl = "https://www.iemop.ph/market-reports/daily-significant-variations-report/?md_file=";
                const downloadUrl = baseUrl + fileHash;
                
                // Log for debugging (remove in production)
                console.log('Download URL:', downloadUrl);
                
                // For security, we could validate the hash server-side
                // For now, we'll open the URL in a new tab
                const newWindow = window.open(downloadUrl, '_blank');
                
                if (!newWindow) {
                    throw new Error('Popup blocked. Please allow popups for this site.');
                }
                
                // Show success message
                showStatus(`Report for ${formatDate(selectedDate)} is downloading. Check your downloads folder.`, 'success');
                
            } catch (error) {
                console.error('Download error:', error);
                showStatus(`Error: ${error.message}`, 'error');
            } finally {
                // Reset button state
                setTimeout(() => {
                    downloadBtn.disabled = false;
                    loadingSpinner.style.display = 'none';
                }, 2000);
            }
        }

        // Show status message
        function showStatus(message, type) {
            statusMessage.textContent = message;
            statusMessage.className = `status-message ${type}`;
            statusMessage.style.display = 'block';
            
            // Auto-hide success messages after 5 seconds
            if (type === 'success') {
                setTimeout(() => {
                    statusMessage.style.display = 'none';
                }, 5000);
            }
        }

        // Initialize the app when DOM is loaded
        document.addEventListener('DOMContentLoaded', init);
    </script>
</body>
</html>