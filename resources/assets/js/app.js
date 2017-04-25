
require('./bootstrap');
window.Vue = require('vue');
require('select2');
require('sweetalert');
var moment = require('moment');
var flatpickr = require("flatpickr");

new Vue({
   el: '#root',
   data(){
       return {
           isActive: false,
       }
   },
   methods:{
        onPage(page){
            return page == location.pathname;
        }
   }
});

$(document).ready(function() {
    $(".race").select2();
    $("#dob").flatpickr({
        altInput: true,
        onChange: function(selectedDates, dateStr, instance){
            $("#age").val(getAge(dateStr));
       }
    });
    $("#date_of_admission").flatpickr({
        onChange: function(selectedDates, dateStr, instance){
            var date = new moment(dateStr);
            date.add(6, "M");
            console.log(date);

           $("#projected_date_of_discharge").val(date.format("Y-M-D")); 
        }
    });

    $("#projected_date_of_discharge").flatpickr({});

    $("#actual_date_of_discharge").flatpickr({});

    $("#employment_date").flatpickr({});

    $("#residentCreate").submit(function(e){
            e.preventDefault();
            $.ajaxPrefilter(function (options, originalOptions, xhr) { // this will run before each request
                var token = $('meta[name="csrf-token"]').attr('content'); // or _token, whichever you are using

                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token); // adds directly to the XmlHttpRequest Object
                }
            });

            var myurl = "/resident";
            $.ajax({
                type: "POST",
                url: myurl,
                data: $(this).serialize(),
                success: function (data) {
                    swal({
                      title:"Success!", 
                      text: "Resident Added!", 
                      type: "success",
                      timer: 1400,
                      showConfirmButton: false
                  });
                    $("#residentCreate").trigger("reset");
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    alert('There was an error processing your request. Please notify an administrator.');
                    console.log(xhr.status);
                    console.log(xhr.responseText);
                    console.log(thrownError);
                }
            })
    });
});

function getAge(dateStr){
    var today = new Date();
    var birthDate = new Date(dateStr);
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    return age;
}


