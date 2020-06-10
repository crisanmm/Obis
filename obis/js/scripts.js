// $(document).ready(function(){
// 	$('#nav-icon1,#nav-icon2,#nav-icon3,#nav-icon4').click(function(){
// 		$(this).toggleClass('open');
// 	});
// });

// document.addEventListener("DOMContentLoaded", function() {
// 	var navicon = document.getElementById('nav-icon')

// 	navicon.onclick(function() {
// 		this.classList.toggle('open');
// 	})
// })

function navIcon() {
	document.getElementById("nav-icon").classList.toggle("open");
}

function dropMenu() {
  document.getElementById("headDrop").classList.toggle("show");
}

// window.onclick = function(event) {
//   if (!event.target.matches('.nav-dropmenu')) {
//     var dropdowns = document.getElementsByClassName("nav-button-list");
//     var i;
//     for (i = 0; i < dropdowns.length; i++) {
//       var openDropdown = dropdowns[i];
//       if (openDropdown.classList.contains('show')) {
//         openDropdown.classList.remove('show');
//       }
//     }
//   }
// }

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
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