<?php include_once 'ImportDB.php'; ?>
<!DOCTYPE html>
<html lang = "ru">
	<head>
		<title>LR5</title>
		<meta charset = "utf-8">
	</head>
	<body>
		<script>
			var ajax;
			InitAjax();
			function InitAjax(){
				try{ajax=new XMLHttpRequest();}
				catch(e){ajax=0;}
			}
		</script>
		<form name = 'form1' method = 'get'>	
			<select id='select1' name = "clients">
				<option value = ''>Оберіть клієнта</option>
				<?php 
					$sql = "SELECT ID_Client , name FROM client ";
					foreach ($dbh->query($sql) as $row) 
					{
						echo "<option value = '$row[ID_Client]'> $row[name] </option>";
					}
				?>
			</select>
		
			<input type = 'button' name = 'check_by_client' id = 'check_by_client' value = 'Вивести статистику' onclick='get1();'>
		</form>
		<script>
			function get1(){
				if(!ajax){alert("Ajax не ініційовано!");return;}
				var s1val = document.getElementById("select1").value;
				ajax.onreadystatechange=OutputStats1;
				var params = 'select1='+encodeURIComponent(s1val);
				ajax.open("GET","Check_By_Client.php?"+params,true);
				ajax.send(null);
			}
			function OutputStats1(){
				if(ajax.readyState==4){
					if(ajax.status==200){
						var output = document.getElementById("output");
						output.innerHTML=ajax.responseText;
					}
					else alert(ajax.status + " - " + ajax.statusText);
					ajax.abort();
				}
			}
		</script>
		<form name = 'form2' method = 'get'>	
			<input id = "date_in" name = "date_in" type="datetime-local">
			<input id = "date_out" name = "date_out" type="datetime-local">
			<input type = 'button' name = 'check_by_date' id = 'check_by_date' value = 'Вивести статистику' onclick='get2();'>
		</form>
		<script>
			function get2(){
				if(!ajax){alert("Ajax не ініційовано!");return;}
				var dinval = document.getElementById("date_in").value;
				var doutval = document.getElementById("date_out").value;
				ajax.onreadystatechange=OutputStats2;
				var params = 'date_in='+encodeURIComponent(dinval)+'&'+'date_out='+encodeURIComponent(doutval);
				ajax.open("GET","Check_By_Time.php?"+params,true);
				ajax.send(null);
			}
			function OutputStats2(){
				if(ajax.readyState==4){
					if(ajax.status==200){
						var output = document.getElementById('output');
						var rows = ajax.responseXML.getElementsByTagName("row");
						if(rows.length>0){
							var result="<table border = 1 align = 'center'> <tr> <th>Початок сеансу</th> <th>Кінець сеансу</th> <th>Вхідний трафік</th> <th>Вихідний трафік</th> <th>Номер Клієнта</th></tr>";
							for(var i = 0; i<rows.length; i++){
								result += "<tr>";
								result += "<td>" + rows[i].children[0].textContent + "</td>";
								result += "<td>" + rows[i].children[1].textContent + "</td>";
								result += "<td>" + rows[i].children[2].textContent + "</td>";
								result += "<td>" + rows[i].children[3].textContent + "</td>";
								result += "<td>" + rows[i].children[4].textContent + "</td>";
								result += "</tr>";
							}
						result+="</table>";
						output.innerHTML = result;
						}
						else output.innerHTML = "Оберіть проміжок часу";
					}
					else alert(ajax.status + " - " + ajax.statusText);
					ajax.abort();
				}
			}
		</script>
			
		<form name='form3' method = 'get'>	
			<input type = 'button' name = 'list_of_client' id = 'list_of_client' value = 'Вивести клієнтів з балансом менше ніж:' onclick='get3();'>
			<input type="number" id="balance" name="balance" min="-99999" max="99999">
		</form>
		<script>
			function get3(){
				if(!ajax){alert("Ajax не ініційовано!");return;}
				var balance = document.getElementById("balance").value;
				ajax.onreadystatechange=OutputStats3;
				var params = 'balance='+encodeURIComponent(balance);
				ajax.open("GET","List_of_client.php?"+params,true);
				ajax.send(null);
			}
			function OutputStats3(){
				if(ajax.readyState==4){
					if(ajax.status==200){
						var res = JSON.parse(ajax.response);
						var result = "<table border = 1 align = 'center'> <tr> <th>Номер клієнта</th> <th>Ім'я клієнта</th> <th>IP</th> <th>Баланс</th> </tr>";
						for(var i = 0;i<res.length;i++){
							result+="<tr> <th>"+res[i][0]+"</th> <th>"+res[i][1]+"</th> <th>"+res[i][2]+"</th> <th>"+res[i][3]+"</th></tr>";
						}
						result+="</table>";
						var output = document.getElementById("output");
						output.innerHTML=result;
					}
					else alert(ajax.status + " - " + ajax.statusText);
					ajax.abort();
				}
			}
		</script>
		<div id="output"></div>
	</body>
</html>