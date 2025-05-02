Vue.component("step-navigation-step", {
  template: "#step-navigation-step-template",
  props: ["step", "currentstep"],
  computed: {
    indicatorclass() {
      return {
        active: this.step.id == this.currentstep,
        complete: this.currentstep > this.step.id
      };
    }
  }
});

Vue.component("step-navigation", {
  template: "#step-navigation-template",
  props: ["steps", "currentstep"]
});

Vue.component("step", {
  template: "#step-template",
  props: ["step", "stepcount", "currentstep"],
  computed: {
    active() {
      return this.step.id == this.currentstep;
    },
    firststep() {
      return this.currentstep == 1;
    },
    laststep() {
      return this.currentstep == this.stepcount;
    },
    stepWrapperClass() {
      return {
        active: this.active
      };
    }
  },
  methods: {
    nextStep() {
      this.$emit("step-change", this.currentstep + 1);
    },
    lastStep() {
      this.$emit("step-change", this.currentstep - 1);
    }
  }
});

new Vue({
  el: "#app",
  data: {
    currentstep: 1,
    steps: [
      { id: 1, title: ".Localisation de l'infraction", icon_class: "fi fi-sr-marker" },
      { id: 2, title: ".Informations Generales", icon_class: "fi fi-sr-guide-alt" },
      { id: 3, title: ".Le contrevenant", icon_class: "fa fa-users" },
      { id: 4, title: ".L'agent", icon_class: "fi fi-sr-member-list" }
    ]
  },
  methods: {
    stepChanged(step) {
      this.currentstep = step;
    }
  }
});

var map = L.map('map').setView([0, 0], 2);

// Add a tile layer to the map (you can choose different providers)
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

// Initialize a marker (without adding it to the map yet)
var marker;

// Function to update the marker position based on input values
function updateMarker() {
    var lat = parseFloat(document.getElementById('input-lat').value);
    var lng = parseFloat(document.getElementById('input-lng').value);

    if (isNaN(lat) || isNaN(lng)) {
        alert("Please enter valid coordinates.");
        return;
    }

    // If marker exists, update its position, otherwise create a new marker
    if (marker) {
        marker.setLatLng([lat, lng]);
    } else {
        marker = L.marker([lat, lng]).addTo(map);
    }
    map.setView([lat, lng], 13);
}

// Add event listeners to the input fields to update the marker on change
document.getElementById('input-lat').addEventListener('change', updateMarker);
document.getElementById('input-lng').addEventListener('change', updateMarker);

// Add event listener to the button to get current location
document.getElementById('btn-current-location').addEventListener('click', function() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var lat = position.coords.latitude;
            var lng = position.coords.longitude;

            // Update input fields
            document.getElementById('input-lat').value = lat;
            document.getElementById('input-lng').value = lng;

            // Update marker position
            updateMarker();
        }, function(error) {
            alert('Error obtaining location: ' + error.message);
        });
    } else {
        alert('Geolocation is not supported by this browser.');
    }
});

// // Initialize the map and set its view to a default location
// var map = L.map('map').setView([0, 0], 2);

// // Add a tile layer to the map (you can choose different providers)
// L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
//   attribution: '&copy; OpenStreetMap contributors'
// }).addTo(map);

// // Initialize a marker (without adding it to the map yet)
// var marker;

// // Function to update the marker position based on input values
// function updateMarker() {
//   var lat = parseFloat(document.getElementById('input-lat').value);
//   var lng = parseFloat(document.getElementById('input-lng').value);

 
//     // If marker exists, update its position, otherwise create a new marker
//     if (marker) {
//       marker.setLatLng([lat, lng]);
//     } else {
//       marker = L.marker([lat, lng]).addTo(map);
//     }
//     map.setView([lat, lng], 13);
  
// }

// // Add event listeners to the input fields to update the marker on change
// document.getElementById('input-lat').addEventListener('change', updateMarker);
// document.getElementById('input-lng').addEventListener('change', updateMarker);
