function myFunction() {
	var x = document.getElementById("myNavBar");
	if (x.className === "navbar") {
		x.className += " responsive";
	} else {
		x.className = "navbar";
	}
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
