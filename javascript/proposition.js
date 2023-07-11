let best_activity_button = document.getElementById("best_activity");
let best_location_button = document.getElementById("best_location");

let activityImages = document.getElementById("activityImages");
let locationImages = document.getElementById("locationImages");

best_activity_button.addEventListener("click", function() {
  activityImages.style.display = "flex";
  locationImages.style.display = "none";
    if (activityImages.style.display === "flex"){
        best_activity_button.style.color = "#9e0e40";
        best_location_button.style.color = "black";
    } else{
        best_activity_button.style.color = "black";
        best_location_button.style.color = "#9e0e40";
    }
});

best_location_button.addEventListener("click", function() {
  locationImages.style.display = "flex";
  activityImages.style.display = "none";
  if (locationImages.style.display === "flex"){
    best_location_button.style.color = "#9e0e40";
    best_activity_button.style.color = "black";
  }else{
    best_location_button.style.color = "black";
    best_activity_button.style.color = "#9e0e40";
  }
});
