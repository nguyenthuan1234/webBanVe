const seatContainer = document.getElementById("seatContainer");
const selectedSeatsInput = document.getElementById("selectedSeats");
let selectedSeats = [];

const rows = 5;
const cols = 8;

function renderSeats() {
    seatContainer.innerHTML = "";
    for (let i = 0; i < rows; i++) {
        const row = document.createElement("div");
        row.className = "seat-row";
        for (let j = 0; j < cols; j++) {
            const seatNumber = `R${i + 1}S${j + 1}`;
            const seat = document.createElement("div");
            seat.className = "seat";
            seat.textContent = seatNumber;
            seat.onclick = () => toggleSeat(seat, seatNumber);
            row.appendChild(seat);
        }
        seatContainer.appendChild(row);
    }
}

function toggleSeat(element, seatNumber) {
    element.classList.toggle("selected");
    if (selectedSeats.includes(seatNumber)) {
        selectedSeats = selectedSeats.filter(s => s !== seatNumber);
    } else {
        selectedSeats.push(seatNumber);
    }
    selectedSeatsInput.value = selectedSeats.join(",");
}

const seatPrice = 50000; // Giá mỗi ghế
const total = selectedSeats.length * seatPrice;

document.getElementById("totalAmount").value = total;
document.getElementById("totalAmountDisplay").textContent = total.toLocaleString() + " VNĐ";

renderSeats();
