const monthYearElement = document.getElementById('monthYear');
const calendarDaysElement = document.getElementById('calendarDays');
const selectedDatesElement = document.getElementById('selectedDates');
const totalCostElement = document.getElementById('totalCost');
const prevMonthButton = document.getElementById('prevMonth');
const nextMonthButton = document.getElementById('nextMonth');
const adultsInput = document.getElementById('adults');
const childrenInput = document.getElementById('children');
const confirmReservationButton = document.getElementById('confirmReservation');
const reservationDetailsElement = document.getElementById('reservationDetails');

let currentDate = new Date();
let selectedDates = new Set();
const pricePerNight = 281;

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

        dateCell.addEventListener('click', () => toggleDateSelection(dateCell));
        calendarDaysElement.appendChild(dateCell);
    }
}

function toggleDateSelection(cell) {
    const date = cell.dataset.date;

    if (selectedDates.has(date)) {
        selectedDates.delete(date);
        cell.classList.remove('selected');
    } else {
        selectedDates.add(date);
        cell.classList.add('selected');
    }

    updateSelectedDatesDisplay();
    updateTotalCost();
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

    reservationDetailsElement.textContent = `Vous avez réservé pour ${totalGuests} personne${totalGuests > 1 ? 's' : ''} (${adults} adulte${adults > 1 ? 's' : ''} et ${children} enfant${children > 1 ? 's' : ''}) aux dates suivantes : ${dates}. Coût total : ${selectedDates.size * pricePerNight} €`;
}

prevMonthButton.addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    renderCalendar();
});

nextMonthButton.addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    renderCalendar();
});

confirmReservationButton.addEventListener('click', confirmReservation);

renderCalendar();
updateSelectedDatesDisplay();
updateTotalCost();