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