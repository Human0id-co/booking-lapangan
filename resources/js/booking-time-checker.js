document.addEventListener('DOMContentLoaded', function () {
    const bookingDate = document.getElementById('booking_date');
    const startTime = document.getElementById('start_time');
    const endTime = document.getElementById('end_time');

    if (!bookingDate || !startTime || !endTime) return;

    bookingDate.addEventListener('change', function () {
        const selectedDate = this.value;

        // Ambil semua waktu booking yang bentrok di tanggal tersebut
        const blockedTimes = existingBookings
            .filter(booking => booking.booking_date === selectedDate)
            .map(booking => ({
                start: booking.start_time,
                end: booking.end_time
            }));

        // Reset input time
        startTime.value = '';
        endTime.value = '';

        // Tampilkan warning jika ada waktu yang sudah ter-book
        if (blockedTimes.length > 0) {
            alert("Some time slots are already booked on this date. Please choose available hours.");
        }

        // Event listener untuk validasi saat user memilih waktu
        function validateTime(input) {
            input.addEventListener('change', function () {
                const inputTime = this.value;

                const isBlocked = blockedTimes.some(time => {
                    return inputTime >= time.start && inputTime < time.end;
                });

                if (isBlocked) {
                    alert("This time is already booked. Please choose another time.");
                    this.value = '';
                }
            });
        }

        validateTime(startTime);
        validateTime(endTime);
    });
});
