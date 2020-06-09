// ANSWERS
var POSTanswers =
    `<div class="labels">
        <label for="locationabbr">Location abbreviation</label>
        <label for="year_value">Year</label>
        <label for="sample_size">Sample Size</label>
        <label for="data_value_percentage">Data Value Percentage</label>
        <label for="confidence_limit_low">Confidence Limit Low</label>
        <label for="confidence_limit_high">Confidence Limit High</label>
        <label for="response_id">Response ID</label>
        <label for="break_out_id">Breakout ID</label>
        <label for="break_out_category_id">Breakout Category ID</label>
    </div>

    <form action="#" id="inputs" class="inputs" onsubmit="executeRequest(); return false">
        <input required type="text" id="locationabbr" name="locationabbr" placeholder="CA">
        <input required type="text" id="year_value" name="year_value" placeholder="2018">
        <input required type="text" id="sample_size" name="sample_size" placeholder="1002">
        <input required type="text" id="data_value_percentage" name="data_value_percentage" placeholder="40.9">
        <input required type="text" id="confidence_limit_low" name="confidence_limit_low" placeholder="39.1">
        <input required type="text" id="confidence_limit_high" name="confidence_limit_high" placeholder="42.6">
        <input required type="text" id="response_id" name="response_id" placeholder="RESP040">
        <input required type="text" id="break_out_id" name="break_out_id" placeholder="SEX1">
        <input required type="text" id="break_out_category_id" name="break_out_category_id" placeholder="CAT2">
    </form>`

var PUTanswers = 
    `<div class="labels">
        <label for="id">ID</label>
        <label for="locationabbr">Location abbreviation</label>
        <label for="year_value">Year</label>
        <label for="sample_size">Sample Size</label>
        <label for="data_value_percentage">Data Value Percentage</label>
        <label for="confidence_limit_low">Confidence Limit Low</label>
        <label for="confidence_limit_high">Confidence Limit High</label>
        <label for="response_id">Response ID</label>
        <label for="break_out_id">Breakout ID</label>
        <label for="break_out_category_id">Breakout Category ID</label>
    </div>

    <form action="#" id="inputs" class="inputs" onsubmit="executeRequest(); return false">
        <input required type="text" id="id" name="ID" placeholder="0">
        <input required type="text" id="locationabbr" name="locationabbr" placeholder="CA">
        <input required type="text" id="year_value" name="year_value" placeholder="2018">
        <input required type="text" id="sample_size" name="sample_size" placeholder="1002">
        <input required type="text" id="data_value_percentage" name="data_value_percentage" placeholder="40.9">
        <input required type="text" id="confidence_limit_low" name="confidence_limit_low" placeholder="39.1">
        <input required type="text" id="confidence_limit_high" name="confidence_limit_high" placeholder="42.6">
        <input required type="text" id="response_id" name="response_id" placeholder="RESP040">
        <input required type="text" id="break_out_id" name="break_out_id" placeholder="SEX1">
        <input required type="text" id="break_out_category_id" name="break_out_category_id" placeholder="CAT2">
    </form>`

var DELETEanswers =
    `<div class="labels">
        <label for="id">ID</label>
    </div>

    <form action="#" id="inputs" class="inputs" onsubmit="executeRequest(); return false">
        <input required type="text" id="id" name="ID" placeholder="0">
    </form>`
   
// LOCATIONS
var POSTlocations = 
    `<div class="labels">
        <label for="locationabbr">Location abbreviation</label>
        <label for="location_name">Location name</label>
    </div>

    <form action="#" id="inputs" class="inputs" onsubmit="executeRequest(); return false">
        <input required type="text" id="locationabbr" name="locationabbr" placeholder="CA">
        <input required type="text" id="location_name" name="location_name" placeholder="California">
    </form>`

var PUTlocations = POSTlocations
    
var DELETElocations =
    `<div class="labels">
        <label for="locationabbr">Location abbreviation</label>
    </div>

    <form action="#" id="inputs" class="inputs" onsubmit="executeRequest(); return false">
        <input required type="text" id="locationabbr" name="locationabbr" placeholder="CA">
    </form>`

// RESPONSES

var POSTresponses =
    `<div class="labels">
        <label for="response_id">Response ID</label>
        <label for="response">Response</label>
    </div>

    <form action="#" id="inputs" class="inputs" onsubmit="executeRequest(); return false">
        <input required type="text" id="response_id" name="response_id" placeholder="RESP039">
        <input required type="text" id="response" name="response" placeholder="Obese (BMI 30.0 - 99.8)">
    </form>`

var PUTresponses = POSTresponses

var DELETEresponses =
    `<div class="labels">
        <label for="response_id">Response ID</label>
    </div>

    <form action="#" id="inputs" class="inputs" onsubmit="executeRequest(); return false">
        <input required type="text" id="response_id" name="response_id" placeholder="RESP039">
    </form>`
    
// BREAKOUTS

var POSTbreakouts =
    `<div class="labels">
        <label for="break_out_id">Break out ID</label>
        <label for="break_out">Break out</label>
    </div>

    <form action="#" id="inputs" class="inputs" onsubmit="executeRequest(); return false">
        <input required type="text" id="break_out_id" name="break_out_id" placeholder="AGE01">
        <input required type="text" id="break_out" name="break_out" placeholder="18-24">
    </form>`


var PUTbreakouts = POSTbreakouts

var DELETEbreakouts =
    `<div class="labels">
        <label for="break_out_id">Break out ID</label>
    </div>

    <form action="#" id="inputs" class="inputs" onsubmit="executeRequest(); return false">
        <input required type="text" id="break_out_id" name="break_out_id" placeholder="AGE01">
    </form>`
    
// BREAKOUT_CATEGORIES
   
var POSTbreakout_categories =
    `<div class="labels">
        <label for="break_out_category_id">Break out category ID</label>
        <label for="break_out_category">Break out category</label>
    </div>

    <form action="#" id="inputs" class="inputs" onsubmit="executeRequest(); return false">
        <input required type="text" id="break_out_category_id" name="break_out_category_id" placeholder="CAT6">
        <input required type="text" id="break_out_category" name="break_out_category" placeholder="Household Income">
    </form>`

var PUTbreakout_categories = POSTbreakout_categories

var DELETEbreakout_categories =
    `<div class="labels">
        <label for="break_out_category_id">Break out category ID</label>
        <label for="break_out_category">Break out category</label>
    </div>

    <form action="#" id="inputs" class="inputs" onsubmit="executeRequest(); return false">
        <input required type="text" id="break_out_category_id" name="break_out_category_id" placeholder="CAT6">
        <input required type="text" id="break_out_category" name="break_out_category" placeholder="Household Income">
    </form>`
    
function generateForm() {
    var e = document.getElementById("method");
    var method = e.options[e.selectedIndex].value; 

    e = document.getElementById("collection");
    var collection = e.options[e.selectedIndex].value;
                      
    var form = method.toUpperCase() + collection.toLowerCase();
    document.getElementById("data").innerHTML = window[form];
}

function executeRequest() {
    var elements = document.getElementById("inputs").elements;
    var obj = {};

    for(var i = 0 ; i < elements.length ; i++){
        var item = elements[i];
        if(item.value != "Submit")
            obj[item.name] = item.value;
    }

    console.log(obj);

    var e = document.getElementById("collection");
    var collection = e.options[e.selectedIndex].value;

    e = document.getElementById("method");
    var method = e.options[e.selectedIndex].value; 

    var queryParam = "";

    switch (collection) {
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

    console.log(method, collection)
    console.log(JSON.stringify(obj, null, 2));
    
    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function() {
        if(xhr.readyState === XMLHttpRequest.DONE) {
            console.log(xhr.status)
            var outcome = ""
            if(xhr.status == 400 || xhr.status == 405) {
                outcome = "Failed"
            } else {
                outcome = "Successful"
            }
            alert(outcome + " " + method.toUpperCase() + " on " + collection.toLowerCase())
        }
    }

    var tmp = window.location.href.split("\/").slice(0, 3).join("\/");

    if(method == "POST") {
	    xhr.open(method, tmp + "/obis/api/"+ collection, true);
	    xhr.setRequestHeader("Authorization", "Bearer " + localStorage.getItem("JWT"));
	    xhr.send(JSON.stringify(obj));
	} else {
		xhr.open(method, tmp + "/obis/api/"+ collection + '/' + queryParam, true);
	    xhr.setRequestHeader("Authorization", "Bearer " + localStorage.getItem("JWT"));
	    xhr.send(JSON.stringify(obj));
	}

    return false;
}