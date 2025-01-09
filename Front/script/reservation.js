const monthYearElement = document.getElementById('monthYear');
const calendarDaysElement = document.getElementById('calendarDays');
const selectedDatesElement = document.getElementById('selectedDates');
const totalCostElement = document.getElementById('totalCost');
const prevMonthButton = document.getElementById('prevMonth');
const nextMonthButton = document.getElementById('nextMonth');
const adultsInput = document.getElementById('adults');
const childrenInput = document.getElementById('children');
const roomTypeSelect = document.getElementById('roomType');
const confirmReservationButton = document.getElementById('confirmReservation');
const reservationDetailsElement = document.getElementById('reservationDetails');

let currentDate = new Date();
let selectedDates = new Set();
let selectionStart = null;

function renderCalendar() {
    calendarDaysElement.innerHTML = '';

    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();

    monthYearElement.textContent = `${currentDate.toLocaleString('default', { month: 'long' })} ${year}`;

    const firstDay = new Date(year, month, 1).getDay();
    const lastDate = new Date(year, month + 1, 0).getDate();

    for (let i = 0; i < firstDay; i++) {
        const emptyCell = document.createElement('div');
        emptyCell.classList.add('disabled');
        calendarDaysElement.appendChild(emptyCell);
    }

    for (let date = 1; date <= lastDate; date++) {
        const dateCell = document.createElement('div');
        dateCell.textContent = date;
        dateCell.dataset.date = new Date(year, month, date).toISOString();

        if (selectedDates.has(dateCell.dataset.date)) {
            dateCell.classList.add('selected');
        }

        dateCell.addEventListener('click', () => handleDateSelection(dateCell));
        calendarDaysElement.appendChild(dateCell);
    }
}

function handleDateSelection(cell) {
    const selectedDate = new Date(cell.dataset.date);

    if (!selectionStart) {
        // Début de la sélection
        selectionStart = selectedDate;
        selectedDates.add(cell.dataset.date);
    } else {
        // Fin de la sélection et remplissage de l'intervalle
        const selectionEnd = selectedDate;
        fillDateRange(selectionStart, selectionEnd);
        selectionStart = null; // Réinitialisation de la sélection
    }

    updateSelectedDatesDisplay();
    updateTotalCost();
    renderCalendar();
}

function fillDateRange(startDate, endDate) {
    // Réinitialisation des dates sélectionnées
    selectedDates.clear();

    const start = startDate < endDate ? startDate : endDate;
    const end = startDate < endDate ? endDate : startDate;

    let currentDate = new Date(start);

    while (currentDate <= end) {
        selectedDates.add(currentDate.toISOString());
        currentDate.setDate(currentDate.getDate() + 1);
    }
}

function updateSelectedDatesDisplay() {
    const selectedCount = selectedDates.size;

    if (selectedCount === 0) {
        selectedDatesElement.textContent = 'Aucune';
    } else {
        const formattedDates = Array.from(selectedDates)
            .map(date => new Date(date).toLocaleDateString())
            .join(', ');

        selectedDatesElement.textContent = `${selectedCount} nuit${selectedCount > 1 ? 's' : ''} : ${formattedDates}`;
    }
}

function updateTotalCost() {
    const pricePerNight = parseInt(roomTypeSelect.value, 10);
    const totalCost = selectedDates.size * pricePerNight;
    totalCostElement.textContent = `${totalCost} €`;
}

function confirmReservation() {
    const adults = parseInt(adultsInput.value, 10);
    const children = parseInt(childrenInput.value, 10);
    const totalGuests = adults + children;

    if (selectedDates.size === 0) {
        alert('Veuillez sélectionner au moins une date.');
        return;
    }

    if (adults < 1) {
        alert('Veuillez sélectionner au moins un adulte.');
        return;
    }

    const dates = Array.from(selectedDates)
        .map(date => new Date(date).toLocaleDateString())
        .join(', ');

    reservationDetailsElement.textContent = `Vous avez réservé pour ${totalGuests} personne${totalGuests > 1 ? 's' : ''} (${adults} adulte${adults > 1 ? 's' : ''} et ${children} enfant${children > 1 ? 's' : ''}) aux dates suivantes : ${dates}. Coût total : ${selectedDates.size * parseInt(roomTypeSelect.value, 10)} €`;
}

prevMonthButton.addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    renderCalendar();
});

nextMonthButton.addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    renderCalendar();
});

roomTypeSelect.addEventListener('change', () => {
    updateTotalCost();
});

confirmReservationButton.addEventListener('click', confirmReservation);

renderCalendar();
updateSelectedDatesDisplay();
updateTotalCost();
