// alle HTML-Elemente in einem Object abspeichern
let elements = {
    verbindung: {
        tab: document.getElementById("tab-verbindung"),
        section: document.getElementById("section-verbindung")
    },
    station: {
        tab: document.getElementById("tab-station"),
        section: document.getElementById("section-station")
    },
    projektinfo: {
        tab: document.getElementById("tab-projektinfo"),
        section: document.getElementById("section-projektinfo")
    }
}

function triggerTab(element) {
    // Geht alle Objekte durch
    for (const key in elements) {
        // Wenn es der gleiche key ist wie der parameter element(die seite die angezeigt werden soll)
        // dann wird der tab auf aktiv gesetzt und die sektion bekommt die hide klasse entfernts
        if (key == element) {
            elements[key]["tab"].classList.add("active")
            elements[key]["section"].classList.remove("hide")
        } else {
            elements[key]["tab"].classList.remove("active")
            elements[key]["section"].classList.add("hide")
        }
    }
}