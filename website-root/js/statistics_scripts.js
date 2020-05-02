 
        document.getElementById("button").addEventListener("click", function(){
          document.getElementById("p1").style.display = "flex";
        })
        document.querySelector(".close").addEventListener("click", function(){
            document.getElementById("p1").style.display = "none";
        })
        document.getElementById("button2").addEventListener("click", function(){
          document.getElementById("p2").style.display = "flex";
        })
        document.getElementById("close2").addEventListener("click", function(){
            document.getElementById("p2").style.display = "none";
        })
        document.getElementById("button3").addEventListener("click", function(){
          document.getElementById("p3").style.display = "flex";
        })
        document.getElementById("close3").addEventListener("click", function(){
            document.getElementById("p3").style.display = "none";
        })
        document.getElementById("button4").addEventListener("click", function(){
          document.getElementById("p4").style.display = "flex";
        })
        document.getElementById("close4").addEventListener("click", function(){
            document.getElementById("p4").style.display = "none";
        })
          document.getElementById("year").addEventListener("mouseover", printYear);
          document.getElementById("year").addEventListener("mouseout", printYear);
          document.getElementById("year").addEventListener("click", printYear);
          document.getElementById("year2").addEventListener("mouseover", printYear);
          document.getElementById("year2").addEventListener("mouseout", printYear);
          document.getElementById("year2").addEventListener("click", printYear);
          function printYear() {
            document.getElementById("displayYear").innerHTML = "";
            document.getElementById("displayYear").innerHTML += this.value;
          }
    document.getElementById("bar").addEventListener("mouseover", printImage);
          document.getElementById("bar").addEventListener("mouseout", deleteImage);
          document.getElementById("line").addEventListener("mouseover", printImage);
          document.getElementById("line").addEventListener("mouseout", deleteImage);
          document.getElementById("doughnut-&-Pie").addEventListener("mouseover", printImage);
          document.getElementById("doughnut-&-Pie").addEventListener("mouseout", deleteImage);
          document.getElementById("radar").addEventListener("mouseover", printImage);
          document.getElementById("radar").addEventListener("mouseout", deleteImage);
          document.getElementById("polar-Area").addEventListener("mouseover", printImage);
          document.getElementById("polar-Area").addEventListener("mouseout", deleteImage);
          document.getElementById("bubble").addEventListener("mouseover", printImage);
          document.getElementById("bubble").addEventListener("mouseout", deleteImage);
          
          function printImage() {
            var image = document.createElement("div");
            image.id = "displayPicture";
            
            image.innerHTML += "<img src='images/" + this.id  + ".png' alt= " + this.id +" width='120px' height='100px' style='float:right'>";
            document.getElementById("p4-content").appendChild(image);
    
          }
          function deleteImage() {
            document.getElementById("displayPicture").remove();
          }
          var continent;
            
          function createCountry(value){
            if(document.getElementById(value) == null){
              var div = document.createElement('div');
              div.className = "country";
              div.id = value;
              var input = document.createElement('input');
              input.name = value;
              input.type = "checkbox";
              var label = document.createElement('label');
              label.htmlFor = value;
              var text = document.createElement('a');
              text.innerHTML = text.innerHTML + value;
              div.appendChild(input);
              div.appendChild(label);
              div.appendChild(text);
              document.getElementById(continent).appendChild(div);  
              }
          }
          