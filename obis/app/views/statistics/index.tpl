<!doctype html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta name="author" content="Hîncean Bogdana-Ioana">
    <title>Obis</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <link rel="icon" type="image/ico" href="/obis/images/placeholders/logo.png" />
    <link href="https://fonts.googleapis.com/css?family=Frank+Ruhl+Libre&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300&display=swap" rel="stylesheet">
    <meta name="robots" content="noindex">
    <link rel="stylesheet" href="/obis/css/index.css">
    <script src="/obis/js/scripts.js"></script>
    <link rel="stylesheet" href="/obis/css/statistics.css">
 </head>


  <body>
    <header>
      <a href="/obis/home/index" ><img src="/obis/images/obis-logo.svg" alt="obis logo"></a>
      <nav>
          <ul class="nav-button-list">
              <li><a href="/obis/home/index" class="nav-button">Home</a></li>
              <li><a href="/obis/statistics/index" class="nav-button" style="color: #ffd524; font-weight: bolder">Statistics</a></li>
              <li><a href="/obis/home/aboutus" class="nav-button">About us</a></li>
              <li><a href="/obis/home/contact" class="nav-button">Contact</a></li>
          </ul>
          <button onclick="dropMenu()" class="nav-dropmenu"><img src="/obis/images/nav-dropmenu.svg" alt="navigation drop down menu button"></button>
      </nav>
<!--               php here-->
      <a href="/obis/account/register" class="auth">
          sign in
      </a>
  </header>
  <main>
    <article>
    <div class="content" id="PC">
    <h1>Statistics</h1>
    <div class="text"> 
      <p>Overweight and obesity are defined by the World Health Organisation as abnormal or excessive fat accumulation that may impair health. Body mass index or BMI is 
      commonly the best overweight indicator. BMI is computed by a person's weight in kilograms divided by the square of his height in meters (kg/m2). The body mass index
      is used for population-level measure of overweight and obesity because is computed in the same way for both sexes; Hovewer the body mass index may not correspond to 
      the same amount of fat in different individuals.</p>
      <p>Being overweight and especially obese enhances the chances of developing medical conditions as:</p>
      <ul class="ul-activ">
        <li>diabetes</li>
        <li>heart disease</li>
        <li>cancer</li>
        <li>musculoskeletal disorders</li>
      </ul>
      <p>For adults, World Health Organisation defines overweight and obesity as follows:</p>
        <ul class="ul-activ">
          <li>overweight as a BMI greater or equal to 25</li>
          <li>obesity as a BMI greater than or equal to 30</li>
        </ul>
    </div>
    <div class="graph" >
        <button class ="button" id ="button">US States</button>
        <button class ="button" id ="button2">Gender</button>
        <button class ="button" id ="button3">Period</button>
        <button class ="button" id ="button4">Format</button>
      </div>
    <img src="/obis/images/doughnut-&-Pie.png" alt="temporary-pie" >
    <div class = "popup" id = "p1">
      <div class="popup-content-countries">
          <div class="continetsContainer">
          <a class="countriesList" id ="List of States">List of States</a>
          </div>
          <br><br>
          <form method="get"> 
            <div class = "countries"  id="us states"></div>
            <input class="submit" type="submit" value="Submit">
          
          </form>
          <img src="/obis/images/close.png" alt="Close" class="close" id ="close">
        </div>
      </div>
     
     
      <div class = "popup" id = "p2">
        <div class="popup-content-gender">
            <div class="continetsContainer">
              <a class="moreOptions" id ="gender">Gender</a>
            </div>
            <br><br>
            <form method="get">
              <div class="gender-options">
                <input type="checkbox" name="male" value="male" id ="male">
                <label for="male">Male</label><br>
              </div>
              <div class="gender-options">
                <input type="checkbox" name="female" value="female" id="female">
                <label for="female"> Female</label><br>
              </div>
              <input class="submit" type="submit" value="Submit">
            </form>

            <img src="/obis/images/close.png" alt="Close" class="close" id ="close2">
          </div>
        </div>

       

        <div class = "popup" id = "p3">
          <div class="popup-content-period">
              <div class="continetsContainer">
                <a class="moreOptions" id ="period">Period</a>
              </div>
              <br><br>
              <form method="get">
              <p class="text">start date: <input type="date" name="date_start" id="date_start"></p>
              <p class="text">end date: <input type="date" name="date_end" id="date_end"></p>
              <input class="submit" type="submit" value="Submit">
              </form>
              <img src="/obis/images/close.png" alt="Close" class="close" id ="close3">
            </div>
          </div>

         

          <div class = "popup" id = "p4">
            <div class="popup-content-format" id="p4-content">
                <div class="continetsContainer">
                  <a class="moreOptions" id ="displayFormat">Display Format</a>
                </div>
                <br><br>

                <form method="get"> 
                  <div class="format-options">
                    <input type="checkbox" name="bar" value="bar" id="bar">
                    <label for="bar" >Bar</label><br>
                  </div>
                  <div class="format-options">
                    <input type="checkbox" name="line" value="line" id="line">
                    <label for="line" >Line</label><br>
                  </div>
                  <div class="format-options">
                    <input type="checkbox" name="radar" value="radar" id="radar">
                    <label for="radar" > Radar</label><br>
                  </div>
                  <div class="format-options">
                    <input type="checkbox" name="doughnut-&-Pie" value="doughnut-&-Pie" id="doughnut-&-Pie">
                    <label for="doughnut-&-Pie" >Doughnut & Pie</label><br>
                  </div>
                  <div class="format-options">
                    <input type="checkbox" name="polar-Area" value="polar-Area"  id="polar-Area">
                    <label for="polar-Area"> Polar Area</label><br>
                  </div>
                  <div class="format-options">
                    <input type="checkbox" name="bubble" value="bubble" id="bubble">
                    <label for="bubble" > Bubble</label><br>
                  </div>
                  <input class="submit" type="submit" value="Submit">
                </form>

                <img src="/obis/images/close.png" alt="Close" class="close" id ="close4">
              </div>
            </div>  
            <script src="/obis/js/statistics_scripts.js"></script>
            <script>
            var countryList = ['Alabama','Alaska','Arizona','Arkansas','California','Colorado',
              'Connecticut','Delaware','Florida','Georgia','Hawaii','Idaho','Illinois','Indiana',
              'Iowa','Kansas','Kentucky','Louisiana','Maine','Maryland','Massachusetts','Michigan',
              'Minnesota','Mississippi','Missouri','Montana','Nebraska','Nevada','New Hampshire','New Jersey',
              'New Mexico','New York','North Carolina','North Dakota','Ohio','Oklahoma','Oregon','Pennsylvania',
              'Rhode Island','South Carolina','South Dakota','Tennessee','Texas','Utah','Vermont','Virginia',
              'Washington','West Virginia','Wisconsin','Wyoming'];
              continent = "us states";
              countryList.forEach(createCountry);  
              document.getElementById("us states").style.display ="flex"; 
        </script> 
        </div>
      </article>
      <aside class="aside-container">
        </aside>  

      <article>
        <div class="content" id="iphone">
          <h1>Statistics</h1>
    <div class="text"> 
      <p>Overweight and obesity are defined by the World Health Organisation as abnormal or excessive fat accumulation that may impair health. Body mass index or BMI is 
      commonly the best overweight indicator. BMI is computed by a person's weight in kilograms divided by the square of his height in meters (kg/m2). The body mass index
      is used for population-level measure of overweight and obesity because is computed in the same way for both sexes; Hovewer the body mass index may not correspond to 
      the same amount of fat in different individuals.</p>
      <p>Being overweight and especially obese enhances the chances of developing medical conditions as:</p>
      <ul class="ul-activ">
        <li>diabetes</li>
        <li>heart disease</li>
        <li>cancer</li>
        <li>musculoskeletal disorders</li>
      </ul>
      <p>For adults, World Health Organisation defines overweight and obesity as follows:</p>
        <ul class="ul-activ">
          <li>overweight as a BMI greater or equal to 25</li>
          <li>obesity as a BMI greater than or equal to 30</li>
        </ul>
    </div>
    
    <div class="graph" >
      <form action="states.html">
        <button class ="button" id ="button">US States</button>
      </form>
        <form action="gender.html">
          <button class ="button" id ="button2">Gender</button>
      </form>
      <form action="period.html">
          <button class ="button" id ="button3">Period</button>
      </form>
      <form action="format.html">
        <button class ="button" id ="button4">Format</button>
      </form>
    </div>
        </div>
    
      </article>
      
</main>
<footer>
  <div class="logos">
      <a href="https://info.uaic.ro"><img class="logo" src="/obis/images/fii-logo.png"></a>
   </div>
   
   <div class="links-container">
       <ul class="links">
           <li class="icon"><a href="https://github.com/hristodormihai/Obis"><img src="/obis/images/github-white.svg"></a>
       </ul>
   </div>
   
   <div class="bottom-footer">
       <p class="copyright">Copyright © 2020 Crisan Mihai</p>
       <div class="select-language">
           <label for="language-select">Language:</label>
           <select name="language" id="language-select">
               <option value="romanian">Romanian</option>
               <option value="english">English</option>
               <option value="french">French</option>
           </select>
       </div>
   </div> 
</footer>
  </body>

  
</html>