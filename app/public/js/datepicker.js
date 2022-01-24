window.addEventListener('load', function () {
    const dateRangeElement = document.getElementById('date-range');

    if (dateRangeElement) {
        const disabledDates = JSON.parse(dateRangeElement.dataset.disabledDates);
        const rangePicker = new DateRangePicker(dateRangeElement, {
            buttonClass: 'btn',
            format: 'yyyy-mm-dd',
            minDate: 'today',
            datesDisabled: disabledDates
        });

        dateRangeElement.querySelectorAll('input').forEach(
            (input) => input.addEventListener('changeDate', function () {
                const begin = rangePicker.getDates()[0];
                const end = rangePicker.getDates()[1];
                const [, correctedEnd] = dateRangeCorrection(begin, end, disabledDates)

                if (end !== correctedEnd) {
                    rangePicker.setDates(begin, correctedEnd);
                }
                const reservationLengthInDays = Math.abs(begin - end) / (24 * 60 * 60 * 1000) + 1;
                setDaysAndPrice(reservationLengthInDays)
            }))
    }
})

function setDaysAndPrice(reservationLengthInDays) {
    const pricePerDayElement = document.getElementById('pricePerDay');
    const pricePerDay = Number.parseInt(pricePerDayElement.textContent);

    document.getElementById('priceCalculation').style.display = 'block';
    document.getElementById('days').textContent = reservationLengthInDays;
    document.getElementById('totalPrice').textContent = (reservationLengthInDays * pricePerDay).toString();
}

function dateRangeCorrection(beginDate, endDate, disabledDateStrings) {
    let date = beginDate;
    while (date <= endDate) {
        if (disabledDateStrings.find((dateString) => dateString === dateToString(date))) {
            return [beginDate, new Date(date.getTime() - 24 * 60 * 60 * 1000)]
        }
        date = new Date(date.getTime() + 24 * 60 * 60 * 1000)
    }
    return [beginDate, endDate];
}

function dateToString(date) {
    const offset = date.getTimezoneOffset()
    date = new Date(date.getTime() - (offset * 60 * 1000))
    return date.toISOString().split('T')[0]
}
