!function myFunction() {
	var x = document.getElementById("myNavBar");
	if (x.className === "navbar") {
		x.className += " responsive";
	} else {
		x.className = "navbar";
	}
}

function copyToClipboard() {
	// Get the text field
	var link = "admin@westmigrationagency.us";

	// Select the text field
	copyText.select();
	copyText.setSelectionRange(0, 99999); // For mobile devices

	// Copy the text inside the text field
	navigator.clipboard.writeText(link);

	// Alert the copied text
	alert("Admin Email copied to clipboard");
}

function toggleForm() {
	var formPopup = document.getElementById("myForm");
	var isOpen = formPopup.classList.toggle("open");

	setTimeout(
		function () {
			formPopup.style.display = isOpen ? "block" : "none";
		},
		isOpen ? 300 : 300
	);
}
