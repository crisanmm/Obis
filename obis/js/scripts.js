function navIcon() {
	document.getElementById("nav-icon").classList.toggle("open");
}

function dropMenu() {
  document.getElementById("headDrop").classList.toggle("show");
}

function leSizeCheck() {
	var ul = document.getElementById("headDrop");

	if(window.innerWidth >= 769) {
		if(document.getElementById("tmp")) {
			var li = document.getElementById("tmp");
			ul.removeChild(li);
		}
	} else if (!document.getElementById("tmp")) {
		var a = document.createElement("a")
		a.setAttribute("href", "/obis/account/user")
		a.setAttribute("class", "nav-button")
		a.innerHTML = loginButtonName

		var currentPage = window.location.href.split('\/')
		var controller = currentPage[currentPage.findIndex(e => e == "obis") + 1]
		if(controller == "account")
			a.setAttribute("style", "color: #ffd524; font-weight: bolder")

		var li = document.createElement("li")
		li.setAttribute("id", "tmp")
		li.appendChild(a)
		ul.appendChild(li)
	}
}

window.onload = function() {
  leSizeCheck();
}