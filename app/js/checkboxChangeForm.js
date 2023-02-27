let checkbox = document.getElementById("fahrplanCheckbox")
let datePicker = document.getElementById("fahrplanDate")
let div = document.getElementById("fahrplanOnlyForm")

function checkForCheckbox() {
    // Wenn Fahrplaninfo geklickt wurde
    if (checkbox.checked) {
        // Setzte Datumsfeld auf required & lasse die div anzeigen
        datePicker.setAttribute("required", "")
        div.style.display = "block"
    } else {
        datePicker.removeAttribute("required", "")
        div.style.display = "none"
    }
}