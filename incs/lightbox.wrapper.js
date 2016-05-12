/*
The MIT License (MIT)

Copyright (c) 2015 Robin Paul Wright

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
*/

window.onload = function appendLightBox() {  
// Fetch this scripts location so resources can be located
var scripts = document.getElementsByTagName('script');
var path = scripts[scripts.length-1].src.split('?')[0];
var mydir = path.split('/').slice(0, -1).join('/')+'/';

// Add the LightBox to the HTML body
var lightBox = document.createElement("div");
lightBox.id = 'lightBoxWrapper';
document.body.appendChild(lightBox);
document.getElementById('lightBoxWrapper').innerHTML = '<div id="grey" style="-webkit-transition: 0.5s; -moz-transition: 0.5s; transition: 0.5s;position:fixed; left:-5%; top:-5%; opacity:0.4; background:#000; width:110%; height:110%; display: none; visibility: hidden;" onclick="closewrapper();">&nbsp;</div><div id="lightBoxwrapper" style="-webkit-transition: 0.5s; -moz-transition: 0.5s; transition: 0.5s;background-color:rgba(255,255,255,0); border-radius: 0px; padding:0px; position: fixed; left: 50%; top: 50%; z-index: 999999; width:0px; height:0px; margin-left:0px; margin-top:0px; display: none; visibility: hidden;"><a href="javascript:void(0);" onclick="closewrapper();"><img id="lightBoxX" src="'+mydir+'X.png" style="-webkit-transition: 0.5s; -moz-transition: 0.5s; transition: 0.5s;position:relative; top:-0px; left:0px; border:0 none;"></a><div id="lightBoxBorder" style="-webkit-transition: 0.5s; -moz-transition: 0.5s; transition: 0.5s;background:#fff; border-radius:2px; margin-top:-10px; box-shadow:0px 0px 10px;"><iframe id="lightBox" style="-webkit-transition: 0.5s; -moz-transition: 0.5s; transition: 0.5s;border:1px solid #ddd; border-radius:2px; height:220px; width:100%;" border="0" frameborder="0"></lightBox></div></div>';

// Stop scroll event 'bubble' - requires jQuery
$('#lightBox').on('mousewheel DOMMouseScroll', function(ev) {
ev.preventDefault();
});
}

function openwrapper(url, x, y, border){
//set border
if(typeof border === 'number') {
document.getElementById("lightBoxBorder").style.border = border+"px solid #FFF";
}
else {
document.getElementById("lightBoxBorder").style.border = "none";
border = 0;
}

// Show popup elements
document.getElementById('grey').style.display='block';
document.getElementById('lightBoxwrapper').style.display='block'; 
document.getElementById('grey').style.visibility='visible';
document.getElementById('lightBoxwrapper').style.visibility='visible'; 

// Resize elements
document.getElementById('lightBoxwrapper').style.width=x + ((2 * border) + 2) + "px";
document.getElementById('lightBoxwrapper').style.height=y + (2 * border) + "px";
document.getElementById('lightBox').style.height=(y) + "px";
document.getElementById('lightBox').style.width=(x) + "px";

// Position elements
document.getElementById('lightBoxwrapper').style.marginLeft="-" + ((x + (2 * border)) / 2) + "px";
document.getElementById('lightBoxwrapper').style.marginTop="-" + ((y + (2 * border)) / 2) + "px";
document.getElementById('lightBoxX').style.left=(x - (10 - (border * 2))) + "px";

// Set Path on lightBox
document.getElementById('lightBox').src = url;
}

function closewrapper() { 
// hide popup elements
 document.getElementById('lightBox').src = 'about:blank';
document.getElementById('lightBoxwrapper').style.display='none'; 
document.getElementById('grey').style.display='none';
document.getElementById('grey').style.visibility='hidden';
document.getElementById('lightBoxwrapper').style.visibility='hidden'; 
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
