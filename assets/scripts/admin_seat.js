const routeJson = document.querySelector("#routeJson").value;
const routeData = JSON.parse(routeJson);
const seatDiagram = document.querySelector("#displaySeats");
let booked_seats = "";

if(seatDiagram)
{
    booked_seats = seatDiagram.dataset.seats;
}
if(booked_seats)
{
    // Color the taken seats as purple
    booked_seats = booked_seats.split(",");

    booked_seats.forEach(seatNo => {
        const seat = seatDiagram.querySelector(`#seat-${seatNo}`);
        seat.classList.add("notAvailable");
    });
}

const seatsBody = document.body;

seatsBody.addEventListener("click", listenforBusSearches);

function listenforBusSearches(evt){
    if(evt.target.className.includes("routeidInput"))
    {
        console.log("Fired");
        const searchInput = evt.target;
        const suggBox = searchInput.nextElementSibling;
        searchInput.addEventListener("input", showSuggestions);
        suggBox.addEventListener("click", selectSuggestion);
    }
}


function selectSuggestion(evt){
    if(evt.target.nodeName === "LI")
    {
        this.previousElementSibling.value = evt.target.innerText;
        this.innerText = "";
    }
}

function showSuggestions()
{
    const word = this.value;
    if(!word)
    {
        this.nextElementSibling.innerText = "";
        return;
    }

    const regex = new RegExp(word, "gi");

    let suggestions = routeData.filter(({route_id}) => {
        return route_id.match(regex);
    }).map(({route_id}) => {
        const bus_num = route_id.replace(regex, `<span class="hl">${this.value.toUpperCase()}</span>`);;
        return `<li>${bus_num}</li>`;
    }).join("");

    this.nextElementSibling.innerHTML = suggestions;
}
