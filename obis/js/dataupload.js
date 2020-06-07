function generateForm()
{
    var e = document.getElementById("table");
    var table = e.options[e.selectedIndex].value;

    e = document.getElementById("type");
    var type = e.options[e.selectedIndex].value; 

    var shaper = "formHere";

    var form1 = `<form action="#" id="leForm" onsubmit="executeRequest();return false">
                      <label for="locationabbr">Location</label>
                      <input type="text" id="locationabbr" name="locationabbr" placeholder="CA"><br>
                      <label for="year_value">Year</label>
                      <input type="text" id="year_value" name="year_value" placeholder="2018"><br>
                      <label for="sample_size">Sample Size</label>
                      <input type="text" id="sample_size" name="sample_size" placeholder="1002"><br>
                      <label for="data_value_percentage">Data Value Percentage</label>
                      <input type="text" id="data_value_percentage" name="data_value_percentage" placeholder="40.9"><br>
                      <label for="confidence_limit_low">Confidence Limit Low</label>
                      <input type="text" id="confidence_limit_low" name="confidence_limit_low" placeholder="39.1"><br>
                      <label for="confidence_limit_high">Confidence Limit High</label>
                      <input type="text" id="confidence_limit_high" name="confidence_limit_high" placeholder="42.6"><br>
                      <label for="response_id">Response ID</label>
                      <input type="text" id="response_id" name="response_id" placeholder="RESP040"><br>
                      <label for="break_out_id">Breakout ID</label>
                      <input type="text" id="break_out_id" name="break_out_id" placeholder="SEX1"><br>
                      <label for="break_out_category_id">Breakout Category ID</label>
                      <input type="text" id="break_out_category_id" name="break_out_category_id" placeholder="CAT2"><br>
                      <input type="submit" value="Submit">
                    </form>    `

    var form2 = `<form action="#" id="leForm" onsubmit="executeRequest();return false">
                      <label for="id">ID</label>
                      <input type="text" id="id" name="ID" placeholder="0"><br>
                      <label for="locationabbr">Location</label>
                      <input type="text" id="locationabbr" name="locationabbr" placeholder="CA"><br>
                      <label for="year_value">Year</label>
                      <input type="text" id="year_value" name="year_value" placeholder="2018"><br>
                      <label for="sample_size">Sample Size</label>
                      <input type="text" id="sample_size" name="sample_size" placeholder="1002"><br>
                      <label for="data_value_percentage">Data Value Percentage</label>
                      <input type="text" id="data_value_percentage" name="data_value_percentage" placeholder="40.9"><br>
                      <label for="confidence_limit_low">Confidence Limit Low</label>
                      <input type="text" id="confidence_limit_low" name="confidence_limit_low" placeholder="39.1"><br>
                      <label for="confidence_limit_high">Confidence Limit High</label>
                      <input type="text" id="confidence_limit_high" name="confidence_limit_high" placeholder="42.6"><br>
                      <label for="response_id">Response ID</label>
                      <input type="text" id="response_id" name="response_id" placeholder="RESP040"><br>
                      <label for="break_out_id">Breakout ID</label>
                      <input type="text" id="break_out_id" name="break_out_id" placeholder="SEX1"><br>
                      <label for="break_out_category_id">Breakout Category ID</label>
                      <input type="text" id="break_out_category_id" name="break_out_category_id" placeholder="CAT2"><br>
                      <input type="submit" value="Submit">
                    </form>`

    var form3 = `<form action="#" id="leForm" onsubmit="executeRequest();return false">
                      <label for="locationabbr">Location Abbreviation</label>
                      <input type="text" id="locationabbr" name="locationabbr" placeholder="CA"><br>
                      <label for="loaction_name">Location Name</label>
                      <input type="text" id="loaction_name" name="loaction_name" placeholder="California"><br>
                      <input type="submit" value="Submit">
                    </form>`
    var form4 = `<form action="#" id="leForm" onsubmit="executeRequest();return false">
                      <label for="response_id">Response ID</label>
                      <input type="text" id="response_id" name="response_id" placeholder="RESP039"><br>
                      <label for="response">Response</label>
                      <input type="text" id="response" name="response" placeholder="Obese (BMI 30.0 - 99.8)"><br>
                      <input type="submit" value="Submit">
                    </form>`
    var form5 = `<form action="#" id="leForm" onsubmit="executeRequest();return false">
                      <label for="break_out_id">Breakout ID</label>
                      <input type="text" id="break_out_id" name="break_out_id" placeholder="INCOME4"><br>
                      <label for="break_out">Breakout</label>
                      <input type="text" id="break_out" name="break_out" placeholder="$35,000-$49,999"><br>
                      <input type="submit" value="Submit">
                    </form>`

    var form6 = `<form action="#" id="leForm" onsubmit="executeRequest();return false">
                      <label for="break_out_category_id">Breakout Category ID</label>
                      <input type="text" id="break_out_category_id" name="break_out_category_id" placeholder="CAT6"><br>
                      <label for="break_out_category">Breakout Category</label>
                      <input type="text" id="break_out_category" name="break_out_category" placeholder="Household Income"><br>
                      <input type="submit" value="Submit">
                    </form>`

    var form7 = `<form action="#" id="leForm" onsubmit="executeRequest();return false">
                      <label for="id">ID</label>
                      <input type="text" id="id" name="ID" placeholder="0"><br>
                      <input type="submit" value="Submit">
                      </form>`

    var form8 = `<form action="#" id="leForm" onsubmit="executeRequest();return false">
					<label for="locationabbr">Location Abbreviation</label>
                    <input type="text" id="locationabbr" name="locationabbr" placeholder="CA"><br>
                    <input type="submit" value="Submit">
                    </form>`

    var form9 = `<form action="#" id="leForm" onsubmit="executeRequest();return false">
 					  <label for="response_id">Response ID</label>
                      <input type="text" id="response_id" name="response_id" placeholder="RESP039"><br>
                      <input type="submit" value="Submit">
                    </form>`

    var form10 = `<form action="#" id="leForm" onsubmit="executeRequest();return false">
 					  <label for="break_out_id">Breakout ID</label>
                      <input type="text" id="break_out_id" name="break_out_id" placeholder="INCOME4"><br>
                      <input type="submit" value="Submit">
                    </form>`

    var form11 = `<form action="#" id="leForm" onsubmit="executeRequest();return false">
					  <label for="break_out_category_id">Breakout Category ID</label>
                      <input type="text" id="break_out_category_id" name="break_out_category_id" placeholder="CAT6"><br>
                      <input type="submit" value="Submit">
                    </form>`

	switch (table) {
        case "answers":
        	if(type == "POST")
            	document.getElementById(shaper).innerHTML = form1;
            else if(type == "PUT")
            	document.getElementById(shaper).innerHTML = form2;
            else
            	document.getElementById(shaper).innerHTML = form7;
            break;
        case "locations":
        	if(type != "DELETE")
            	document.getElementById(shaper).innerHTML = form3;
            else
            	document.getElementById(shaper).innerHTML = form8;
            break;
        case "responses":
        	if(type != "DELETE")
            	document.getElementById(shaper).innerHTML = form4;
            else
            	document.getElementById(shaper).innerHTML = form9;
            break;
        case "breakouts":
        	if(type != "DELETE")
            	document.getElementById(shaper).innerHTML = form5;
            else
            	document.getElementById(shaper).innerHTML = form10;
            break;
        case "breakout_categories":
        	if(type != "DELETE")        
            	document.getElementById(shaper).innerHTML = form6;
            else
            	document.getElementById(shaper).innerHTML = form11;
            break;
    }
}

function executeRequest()
{    
    var elements = document.getElementById("leForm").elements;
    var obj ={};

    for(var i = 0 ; i < elements.length ; i++){
        var item = elements.item(i);
        if(item.value != "Submit")
        obj[item.name] = item.value;
    }

    console.log(obj);

    var e = document.getElementById("table");
    var table = e.options[e.selectedIndex].value;

    e = document.getElementById("type");
    var type = e.options[e.selectedIndex].value; 

    var queryParam = "";

    switch (table) {
        case "answers":
        	queryParam = obj["id"];
            break;
        case "locations":
        	queryParam = obj["locationabbr"];
            break;
        case "responses":
        	queryParam = obj["response_id"];
            break;
        case "breakouts":
        	queryParam = obj["break_out_id"];
            break;
        case "breakout_categories":
        	queryParam = obj["break_out_category_id"];
            break;
        }

    console.log(type,table)

    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function() {
    	// console.log(this.responseText);
    	handleStatus(this.status);
    }

    var tmp = window.location.href.split("\/").slice(0, 3).join("\/");

    if(type == "POST")
    {
	    xmlhttp.open(type, tmp + "/obis/api/"+ table, true);
	    xmlhttp.setRequestHeader("Authorization", "Bearer " + localStorage.getItem("JWT"));
	    xmlhttp.send(JSON.stringify(obj));
	}else 
	{
		xmlhttp.open(type, tmp + "/obis/api/"+ table + '/' + queryParam, true);
	    xmlhttp.setRequestHeader("Authorization", "Bearer " + localStorage.getItem("JWT"));
	    xmlhttp.send(JSON.stringify(obj));
	}

    return false;
}

function handleStatus(status)
{
	console.log(status);
	if(status == 400 || status == 405)
	{
		document.getElementById("outcome").innerHTML = "not so gucci";
	}else
	{
		document.getElementById("outcome").innerHTML = "we gucci";
	}
}