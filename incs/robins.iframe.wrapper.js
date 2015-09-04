function openwrapper(url, x, y){
// Show popup elements
document.getElementById('iframewrapper').style.display='block'; 
document.getElementById('grey').style.display='block';

// Resize elements
document.getElementById('iframewrapper').style.width=x + "px";
document.getElementById('iframewrapper').style.height=y + "px";
document.getElementById('Iframe').style.height=(y - 10) + "px";

// Position elements
document.getElementById('iframewrapper').style.marginLeft="-" + (x / 2) + "px";
document.getElementById('iframewrapper').style.marginTop="-" + (y / 2) + "px";
document.getElementById('iframeX').style.left=(x - 15) + "px";

// Stop scroll event 'bubble'
 document.getElementById('Iframe').src = url;
$('#Iframe').on('mousewheel DOMMouseScroll', function(ev) {
ev.preventDefault();
});
}

function closewrapper() { //will close the window without refreshing the page. 
// hide popup elements
document.getElementById('iframewrapper').style.display='none'; 
document.getElementById('grey').style.display='none';
}

function reloadparent() { //reloads parent window, for use from wrapper
location.reload();
}

function ShowHide(id) {
var element = document.getElementById(id);
if(element.style.display == "block") {
element.style.display = "none";
}
else {
element.style.display = "block";
}
}

function Hide(id) {
var element = document.getElementById(id);
element.style.display = "none";
}

function Show(id) {
var element = document.getElementById(id);
element.style.display = "Block";
}

window.onscroll = function(ev) 
	{
		var e = document.getElementById('tablescroll');
		
		if ((window.scrollY) > 10)
		{
		document.getElementById("menu").className = "menu";
						
			}
       else 
{	   
		document.getElementById("menu").className = "menuLocked";
	
			}
		
		
		if ((window.scrollY) > 165)
		{
			e.style.display = 'block';
						
			}
       else 
{	   
			e.style.display = 'none';
	
			}
		
	}

function popup(url){
var popup=window.open(url,"Stock Manager Popup","width=700,height=650,scrollbars=1,resizable=1,addressbar=0")
}

function highlightRow(row){
	var element = document.getElementById(row);
    if (element.style.background == "rgb(66, 111, 217)" || element.style.background == "rgb(66, 111, 218)" || element.style.background == "rgb(66, 111, 216)" || element.style.background == "rgb(66, 111, 219)") {
		if (element.style.background == "rgb(66, 111, 218)") {
			element.style.background = "#f75b68";
		}
		else if (element.style.background == "rgb(66, 111, 216)") {
			     element.style.background = "#12bb05";
		}
		else if (element.style.background == "rgb(66, 111, 219)") {
			     element.style.background = "#f8d804";
		}
		else {		
		element.style.background = "";
		}
		element.style.color = "black";
	}
	
	else {
		if (element.style.background == "#f75b68" || element.style.background == "rgb(247, 91, 104)") {
		element.style.background = "rgb(66, 111, 218)";
		}
		else if (element.style.background == "#f8d804" || element.style.background == "rgb(248, 216, 4)") {
		element.style.background = "rgb(66, 111, 219)";
		}
		else if (element.style.background == "#12bb05" || element.style.background == "rgb(18, 187, 5)") {
		element.style.background = "rgb(66, 111, 216)";
		}
		else {
		element.style.background = "rgb(66, 111, 217)";
		}
		element.style.color = "white";
	}
}

