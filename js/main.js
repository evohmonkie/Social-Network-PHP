// Return element by id
function _(x) {
	return document.getElementById(x);
}

// Create new AJAX object
function ajax(meth, url) {
	var x = new XMLHttpRequest();
	x.open(meth, url, true);
	x.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	return x;
}
function ajaxReturn(x) {
	if(x.readyState == 4 && x.status == 200) {
		return true;
	}
}

// Add Event Listeners
// function addEvents() {
// 	_("elemID").addEventListener("click", func, false);
// }
// window.onload = addEvents();

// Application Functions


/********************** 
	Signup Functions
***********************/

// Restrict Input
function restrict(elem) {
	var e = _(elem);
	var r = new RegExp;
	if (elem == "email") {
		r = /[' "]/gi;
	} 
	else if (elem == "username") {
		r = /[^a-z0-9]/gi;
	}
}

// Empty Element
function emptyElement(e) {
	_(e).innerHTML = "";
}

// Check Username
function checkUsername() {
	var u = _("username").value;
	if (u != "") {
		_("username-status").innerHTML = "...checking";
		var a = ajax("POST", "signup.php");
		a.onreadystatechange = function(){
			if(ajaxReturn(a) == true) {
				_("username-status").innerHTML = a.responseText;
			}
		}
		a.send("usernamecheck="+u);
	}
}

// Sign Up
function signup(){
	var u = _("username").value;
	var e = _("email").value;
	var p1 = _("password1").value;
	var p2 = _("password2").value;
	var g = _("gender").value;
	var c = _("country").value
	var status = _("form-status");

	if(u == "" || e == "" || p1 == "" || p2 == "" || g == "" || c == "") {
		status.innerHTML = "Please fill out the entire form!!! <br />";
	}
	else if (p1 != p2) {
		status.innerHTML = "Your passwords do not match!";
	}
	else if (_("terms").style.display == "none") {
		status.innerHTML = "Please agree to terms";
	}
	else {
		_("signup-btn").style.display = "none";
		var a = ajax("POST", "signup.php");
		a.onreadystatechange = function() {
			if(ajaxReturn(a) == true) {
				if (a.responseText.trim() != "signup_success") {
					status.innerHTML = a.responseText;
				} else {
					window.scrollTo(0,0);
					_("signup-form").innerHTML = "Ok! Please check your email to activate your account!";
				}
			}
		}
		a.send("u="+u+"&e="+e+"&p="+p1+"&g="+g+"&c="+c);	
	}
}
