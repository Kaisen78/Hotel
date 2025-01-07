const monthYearElement = document.getElementById('monthYear');
const calendarDaysElement = document.getElementById('calendarDays');
const selectedDateElement = document.getElementById('selectedDate');
const prevMonthButton = document.getElementById('prevMonth');
const nextMonthButton = document.getElementById('nextMonth');

let currentDate = new Date();
let selectedDate = null;

function rendarCalendar() {
    calendarDaysElement.innerHTML = '';

    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();

    monthYearElement.textContent = `${currentDate.toLocaleString('default', { month: 'long' })} ${year}`;

    const firstDay = new Date(year, month, 1).getDay();
    const lastDate = new Date(year, month + 1, 0).getDate();

    for (let i=0; i < firstDay; i++) {
        const emptyCell = document.createElement('div');
        emptyCell.classList.add('disabled');
        calendarDaysElement.appendChild(emptyCell);
    }

    for (let date=1; date <= lastDate; date++) {
        const datCell = document.createElement('div');
        dateCell.textContent = date;
        dateCell.dataset.date = new Date(year, month, date).toISOString();
        dateCell.addEventListener('click', () => selectDate(datCell));

        if (selectedDate === dateCell.dataset.date) {
            dateCell.classList.add('selected');
        }

        calendarDaysElement.appendChild(dateCell);
    }
}

function selectDate(cell) {
    const previouslySelected = calendarDaysElement.querySelector('.selected');
    if (previouslySelected) {
        previouslySelected.classList.remove('selected');
    }

    cell.classList.add('selected');
    selectedDate = cell.dataset.date;
    selectedDateElement.textContent = new Date(selectDate).toLocaleDateString();
}

prevMonthButton.addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    rendarCalendar();
});

nextMonthButton.addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    rendarCalendar();
});

rendarCalendar();