google.charts.load('current', {
    'packages': ['corechart']
});
google.charts.load('current', {
    'packages': ['geochart'],
    'mapsApiKey': 'no'
});

google.charts.setOnLoadCallback(drawChart);
google.charts.setOnLoadCallback(drawColumn);
google.charts.setOnLoadCallback(drawMap);

var gPieChart;
var gPieChartData;
var gColumnChart;
var gColumnChartData;
var gMapChart;
var gMapChartData;

var jwt = localStorage.getItem("JWT");

function drawChart() {
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function () {
        var options;

        if (this.readyState == 4 && this.status == 200) {

            if (filterType == "byCAT") {
                var obj = JSON.parse(this.responseText);

                var arr = [];
                arr.push(['Test', 'Sample Size']);

                obj.forEach(parseJson);

                function parseJson(data) {
                    arr.push([data["response"]["response"], Number(data["sample_size"])]);
                }

                try {
                    var location = e.options[e.selectedIndex].value;
                    text = e.options[e.selectedIndex].text;
                } catch (err) {
                    text = "Alaska";
                }

                options = {
                    title: obj[0]["break_out_category"]["break_out_category"] + " : " + obj[0]["break_out"]["break_out"] + "\n" + year + " - " + text
                };
            }

            if (filterType == "byBMI") {
                var obj = JSON.parse(this.responseText);

                obj.sort(function (a, b) {
                    return a["break_out"]["break_out"].localeCompare(b["break_out"]["break_out"]);
                });

                var arr = [];
                arr.push(['Test', 'Sample Size']);

                obj.forEach(parseJson);

                function parseJson(data) {
                    arr.push([data["break_out"]["break_out"], Number(data["sample_size"])]);
                }

                try {
                    var location = e.options[e.selectedIndex].value;
                    text = e.options[e.selectedIndex].text;
                } catch (err) {
                    text = "Alaska";
                }


                options = {
                    title: obj[0]["response"]["response"] + " - " + obj[0]["break_out_category"]["break_out_category"] + "\n" + year + " - " + text
                };
            }

            var data = google.visualization.arrayToDataTable(arr);
            var chart = new google.visualization.PieChart(document.getElementById('piechart'));
            chart.draw(data, options);
            gPieChart = chart;
            gPieChartData = data;
        }
    };
    var e = document.getElementById("location");
    try {
        var location = e.options[e.selectedIndex].value;
    } catch (err) {
        var location = "AK";
    }
    var text = "Alaska";
    var filter;
    var choice;
    var year = "2011";
    var bmi = "RESP039"
    var breaks = "AGE01";
    var cat = "CAT3";
    var filterType = "byBMI";

    e = document.getElementById("year");
    year = e.options[e.selectedIndex].value;

    e = document.getElementById("bmi");
    bmi = e.options[e.selectedIndex].value;

    e = document.getElementById("breaks");
    breaks = e.options[e.selectedIndex].value;

    e = document.getElementById("cat");
    cat = e.options[e.selectedIndex].value;

    e = document.getElementById("filterType");
    filterType = e.options[e.selectedIndex].value;

    if (filterType == "byBMI") {
        filter = bmi;
        choice = "response_id";
    } else {
        filter = breaks;
        choice = "break_out_id";
    }

    var tmp = window.location.href.split("\/").slice(0, 3).join("\/");

    xmlhttp.open("GET", tmp + "/obis/api/answers/location/" + location + "/year/" + year + "?" + choice + "=" + filter + "&break_out_category_id=" + cat, true);
    // console.log(jwt);
    xmlhttp.setRequestHeader("Authorization", "Bearer " + jwt);
    xmlhttp.send();
}

function setCategory(category, id) {
    var shaper;
    var brk;
    var chrt;

    if (id == "cat") {
        shaper = "shape_shifter";
        brk = "breaks";
        chrt = "drawChart()";
    } else
    if (id == "cat2") {
        shaper = "shape_shifter2";
        brk = "breaks2";
        chrt = "drawColumn()";
    } else {
        shaper = "shape_shifter3";
        brk = "breaks3";
        chrt = "drawMap()";
    }

    var cat1 = '<select name="breakouts" id="' + brk + '" onchange="' + chrt + '">\n<option selected value="BO1">Overall</option>\n</select>';

    var cat2 = '<select name="breakouts" id="' + brk + '" onchange="' + chrt + '">\n<option selected value="SEX1">Male</option>\n<option value="SEX2">Female</option>\n</select>';

    var cat3 = '<select name="breakouts" id="' + brk + '" onchange="' + chrt + '">\n<option selected value="AGE01">18-24</option>\n<option value="AGE02">25-34</option>\n<option value="AGE03">35-44</option>\n<option value="AGE04">45-54</option>\n<option value="AGE05">55-64</option>\n<option value="AGE09">65+</option>\n</select>';

    var cat4 = '<select name="breakouts" id="' + brk + '" onchange="' + chrt + '">\n<option selected value="RACE01">White, non-Hispanic</option>\n<option value="RACE02">Black, non-Hispanic</option>\n<option value="RACE03">American Indian or Alaskan Native, non-Hispanic</option>\n<option value="RACE04">Asian, non-Hispanic</option>\n<option value="RACE05">Native Hawaiian or other Pacific Islander, non-Hispanic</option>\n<option value="RACE06">Other, non-Hispanic</option>\n<option value="RACE07">Multiracial, non-Hispanic</option>\n<option value="RACE08">Hispanic</option>\n</select>';

    var cat5 = '<select name="breakouts" id="' + brk + '" onchange="' + chrt + '">\n<option selected value="EDUCA1">Less than H.S.</option>\n<option value="EDUCA2">H.S. or G.E.D.</option>\n<option value="EDUCA3">Some post-H.S.</option>\n<option value="EDUCA4">College graduate</option>\n</select>';

    var cat6 = '<select name="breakouts" id="' + brk + '" onchange="' + chrt + '">\n<option selected value="INCOME1">Less than $15,000</option>\n<option value="INCOME2">$15,000-$24,999</option>\n<option value="INCOME3">$25,000-$34,999</option>\n<option value="INCOME4">$35,000-$49,999</option>\n<option value="INCOME5">$50,000+</option>\n</select>';

    switch (category) {
        case "CAT3":
            document.getElementById(shaper).innerHTML = cat3;
            break;
        case "CAT1":
            document.getElementById(shaper).innerHTML = cat1;
            break;
        case "CAT2":
            document.getElementById(shaper).innerHTML = cat2;
            break;
        case "CAT4":
            document.getElementById(shaper).innerHTML = cat4;
            break;
        case "CAT5":
            document.getElementById(shaper).innerHTML = cat5;
            break;
        case "CAT6":
            document.getElementById(shaper).innerHTML = cat6;
            break;
    }

    if (id == "cat")
        drawChart();
    else
    if (id == "cat2")
        drawColumn();
    else
        drawMap();
}

function drawColumn() {
    var e = document.getElementById("location2");
    try {
        var location = e.options[e.selectedIndex].value;
    } catch (err) {
        var location = "AK";
    }
    e = document.getElementById("location3");
    try {
        var location2 = e.options[e.selectedIndex].value;
    } catch (err) {
        var location2 = "AK";
    }

    var filter;
    var choice;

    e = document.getElementById("year2");
    var year = e.options[e.selectedIndex].value;

    e = document.getElementById("bmi2");
    var bmi = e.options[e.selectedIndex].value;

    e = document.getElementById("breaks2");
    var breaks = e.options[e.selectedIndex].value;

    e = document.getElementById("cat2");
    var cat = e.options[e.selectedIndex].value;

    e = document.getElementById("filterType2");
    var filterType = e.options[e.selectedIndex].value;

    if (filterType == "byBMI") {
        filter = bmi;
        choice = "response_id";
    } else {
        filter = breaks;
        choice = "break_out_id";
    }

    var tmp = window.location.href.split("\/").slice(0, 3).join("\/");

    var urls = [tmp + "/obis/api/answers/location/" + location + "/year/" + year + "?" + choice + "=" + filter + "&break_out_category_id=" + cat, tmp + "/obis/api/answers/location/" + location2 + "/year/" + year + "?" + choice + "=" + filter + "&break_out_category_id=" + cat];


    Promise.all(urls.map(url => fetch(url, {
        headers: {
            'Authorization': "Bearer " + jwt
        }
    }).then(response => response.json()))).then(function (results) {

        if (filterType == "byCAT") {
            var e = document.getElementById("location2");
            var text = e.options[e.selectedIndex].text;

            e = document.getElementById("location3");
            var text2 = e.options[e.selectedIndex].text;

            var arr = [];
            arr.push(['Test', text, text2]);

            results[0].forEach(parseJson);

            function parseJson(data, i) {
                arr.push([data["response"]["response"], Number(data["data_value_percentage"]) / 100, Number(results[1][i]["data_value_percentage"]) / 100]);
            }



            options = {
                title: results[0][0]["break_out_category"]["break_out_category"] + " : " + results[0][0]["break_out"]["break_out"] + "\n" + year + " - " + text + " vs " + text2,
                vAxis: {
                    format: 'percent',
                    title: "BMI Percentage"
                },
                hAxis: {
                    title: results[0][0]["break_out_category"]["break_out_category"] + " " + results[0][0]["break_out"]["break_out"]
                }
            };
        }

        if (filterType == "byBMI") {
            results[0].sort(function (a, b) {
                return a["break_out"]["break_out"].localeCompare(b["break_out"]["break_out"]);
            });
            results[1].sort(function (a, b) {
                return a["break_out"]["break_out"].localeCompare(b["break_out"]["break_out"]);
            });

            var e = document.getElementById("location2");
            var text = e.options[e.selectedIndex].text;

            e = document.getElementById("location3");
            var text2 = e.options[e.selectedIndex].text;

            var arr = [];
            arr.push(['Test', text, text2]);

            results[0].forEach(parseJson);

            function parseJson(data, i) {
                arr.push([data["break_out"]["break_out"], Number(data["data_value_percentage"]) / 100, Number(results[1][i]["data_value_percentage"]) / 100]);
            }

            options = {
                title: results[0][0]["response"]["response"] + " - " + results[0][0]["break_out_category"]["break_out_category"] + "\n" + year + " - " + text + " vs " + text2,
                vAxis: {
                    format: 'percent',
                    title: "BMI Percentage"
                },
                hAxis: {
                    title: results[0][0]["break_out_category"]["break_out_category"]
                }
            };
        }
        var data = google.visualization.arrayToDataTable(arr);
        var chart = new google.visualization.ColumnChart(document.getElementById('columnchart'));
        chart.draw(data, options);

        gColumnChart = chart;
        gColumnChartData = data;
    });
}

function drawMap() {
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function () {
        var options;

        if (this.readyState == 4 && this.status == 200) {
            var stateNames = {
                "AL": "Alabama",
                "AK": "Alaska",
                "AS": "American Samoa",
                "AZ": "Arizona",
                "AR": "Arkansas",
                "CA": "California",
                "CO": "Colorado",
                "CT": "Connecticut",
                "DE": "Delaware",
                "DC": "District Of Columbia",
                "FM": "Federated States Of Micronesia",
                "FL": "Florida",
                "GA": "Georgia",
                "GU": "Guam",
                "HI": "Hawaii",
                "ID": "Idaho",
                "IL": "Illinois",
                "IN": "Indiana",
                "IA": "Iowa",
                "KS": "Kansas",
                "KY": "Kentucky",
                "LA": "Louisiana",
                "ME": "Maine",
                "MH": "Marshall Islands",
                "MD": "Maryland",
                "MA": "Massachusetts",
                "MI": "Michigan",
                "MN": "Minnesota",
                "MS": "Mississippi",
                "MO": "Missouri",
                "MT": "Montana",
                "NE": "Nebraska",
                "NV": "Nevada",
                "NH": "New Hampshire",
                "NJ": "New Jersey",
                "NM": "New Mexico",
                "NY": "New York",
                "NC": "North Carolina",
                "ND": "North Dakota",
                "MP": "Northern Mariana Islands",
                "OH": "Ohio",
                "OK": "Oklahoma",
                "OR": "Oregon",
                "PW": "Palau",
                "PA": "Pennsylvania",
                "PR": "Puerto Rico",
                "RI": "Rhode Island",
                "SC": "South Carolina",
                "SD": "South Dakota",
                "TN": "Tennessee",
                "TX": "Texas",
                "UT": "Utah",
                "VT": "Vermont",
                "VI": "Virgin Islands",
                "VA": "Virginia",
                "WA": "Washington",
                "WV": "West Virginia",
                "WI": "Wisconsin",
                "WY": "Wyoming"
            }
            var obj = JSON.parse(this.responseText);

            var arr = [];
            arr.push(['State', 'Percentage']);

            obj.forEach(parseJson);

            function parseJson(data) {
                arr.push([stateNames[data["locationabbr"]], Number(data["data_value_percentage"])]);
            }

            var options = {
                region: 'US',
                displayMode: 'regions',
                resolution: 'provinces'
            };

            document.getElementById("mapTitle").innerHTML = obj[0]["response"]["response"] + " - " + obj[0]["break_out_category"]["break_out_category"] + "<br>" + "Year: " + year;

            var data = google.visualization.arrayToDataTable(arr);
            var chart = new google.visualization.GeoChart(document.getElementById('map'));
            chart.draw(data, options);

            gMapChart = chart;
            gMapChartData = data;
        }
    };

    var filter;
    var choice;

    e = document.getElementById("year3");
    var year = e.options[e.selectedIndex].value;

    e = document.getElementById("bmi3");
    var bmi = e.options[e.selectedIndex].value;

    e = document.getElementById("breaks3");
    var breaks = e.options[e.selectedIndex].value;

    e = document.getElementById("cat3");
    var cat = e.options[e.selectedIndex].value;


    filter = bmi;

    var tmp = window.location.href.split("\/").slice(0, 3).join("\/");


    xmlhttp.open("GET", tmp + "/obis/api/answers/year/" + year + "?" + "response_id" + "=" + filter + "&break_out_category_id=" + cat + "&break_out_id=" + breaks, true);
    xmlhttp.setRequestHeader("Authorization", "Bearer " + jwt);
    xmlhttp.send();
}

function exportData(id) {
    var elemID;
    var chartID;
    var chart;
    var chartData;

    if (id == "expBtn1") {
        elemID = "exp1";
        chartID = "piechart";
        chart = gPieChart;
        chartData = gPieChartData;
    } else if (id == "expBtn2") {
        elemID = "exp2";
        chartID = "columnchart";
        chart = gColumnChart;
        chartData = gColumnChartData;
    } else {
        elemID = "exp3";
        chartID = "map";
        chart = gMapChart;
        chartData = gMapChartData;
    }

    e = document.getElementById(elemID);
    var exp = e.options[e.selectedIndex].value;

    if (exp == "svg") {
        e = document.getElementById(chartID);
        var file = new Blob([e.getElementsByTagName('svg')[0].outerHTML], {
            type: "text/svg"
        });

        var lnk = document.createElement("a");
        lnk.download = "data.svg";
        lnk.href = URL.createObjectURL(file);
        lnk.click();
        lnk.remove();
    } else if (exp == "webp") {
        var lnk = document.createElement("a");
        lnk.download = "data.webp";
        lnk.href = chart.getImageURI();
        lnk.click();
        lnk.remove();
    } else {
        var file = new Blob([google.visualization.dataTableToCsv(chartData)], {
            type: "text/csv"
        });

        var lnk = document.createElement("a");
        lnk.download = "data.csv";
        lnk.href = URL.createObjectURL(file);
        lnk.click();
        lnk.remove();
    }
}

function hideOther(selected) {
    switch (selected) {
        case ("filterType"):
            document.getElementById("bmi").classList.toggle("show");
            document.getElementById("leBMIch1").classList.toggle("show");
            document.getElementById("shape_shifter").classList.toggle("show");
            document.getElementById("leBreakch1").classList.toggle("show");
            break;
        case ("filterType2"):
            document.getElementById("bmi2").classList.toggle("show");
            document.getElementById("leBMIch2").classList.toggle("show");
            document.getElementById("shape_shifter2").classList.toggle("show");
            document.getElementById("leBreakch2").classList.toggle("show");
            break;
    }
}
