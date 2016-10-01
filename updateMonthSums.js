//cg, cos, dcgar, dcgn, dcgng, dcgs, g3
function updateMonthSums(var cg, var cos, var dcgar, var dcgn, var dcgng, var dcgs, var g3)
{
	var xmlhttp = new XMLHttpRequest();
	
	xmlhttp.open("POST", "updateChart.php?cg=" + cg + "&cos=" + cos + "&dcgar=" + dcgar + "&dcgn=" + dcgn + "&dcgng=" + dcgng + "&dcgs=" + dcgs + "&g3=" + g3, true);
	
	xmlhttp.onreadystatechange = function()
	{
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
		{
			var response = JSON.parse(xmlhttp.responseText);
			document.getElementById('jan').innerText = response[0];
			alert(response);	
		}
		alert("here");
	}
	alert("here");
}