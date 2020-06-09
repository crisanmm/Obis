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

function leSizeCheck()
{
	var ul = document.getElementById("headDrop");

	if(window.innerWidth >= 769)
	{
		if(document.getElementById("tmp"))
		{
			var li = document.getElementById("tmp");
			ul.removeChild(li);
		}
	}else if (!document.getElementById("tmp"))
	{
		var li = document.createElement("li");
		
		li.setAttribute('id',"tmp");
		ul.appendChild(li);

		document.getElementById("tmp").innerHTML = `<a href="/obis/account/user" class="nav-button">
                        <?php echo isset($_SESSION['firstname']) ? $_SESSION['firstname'] : "LOG IN" ?>
                    </a>`;
	}
}

window.onload = function()
{
	leSizeCheck();
}