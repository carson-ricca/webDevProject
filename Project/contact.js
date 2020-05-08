$(document).ready(function(){
    $("#contact").submit(function(e){
        e.preventDefault();
        var fName = $("#fName").val();
        var lName = $("#lName").val();
        var phone = $("#phone").val();
        var email = $("#email").val();
        var msg = $("#message").val();
        var dataString = 'fName1=' + fName + '&lName1=' + lName + '&phone1=' + phone + '&email1=' + email + '&msg1=' + msg;

        var submitReady = false; //used to see if ajax call can happen
        var count = 0; //used to determine if there are any errors in the form
       
        if(!email.includes("@") || !email.includes(".")){   //email must contain ('@' AND '.') to be valid
            $(".emailErr").html("Invalid Email Address");
            $("#email").addClass("red");
            submitReady = false;
            count++;
        }

        else{   //clear emailErr
            $(".emailErr").empty();
            $("#email").removeClass("red");
        }

        if(!(/^[a-zA-Z]+$/.test(fName))){   //first name must consist of only letters
            $(".fNameErr").html("Invalid First Name");
            $("#fName").addClass("red");
            submitReady = false;
            count++;
        }

        else{   //clear fNameErr
            $(".fNameErr").empty();
            $("#fName").removeClass("red");
        }

        if(!(/^[a-zA-Z]+$/.test(lName))){   //last name must consist of only letters
            $(".lNameErr").html("Invalid Last Name");
            $("#lName").addClass("red");
            submitReady = false;
            count++;
        }

        else{   //clear lNameErr
            $(".lNameErr").empty();
            $("#lName").removeClass("red");
        }

        if(!(/^\d+$/.test(phone))){     //phone number must contain only numbers
            $(".phoneErr").html("Invalid Phone Number");
            $("#phone").addClass("red");
            submitReady = false;
            count++;
        }

        else{   //clear phoneErr
            $(".phoneErr").empty();
            $("#phone").removeClass("red");
        }

        if(msg == ''){  //msg must not be empty
            $(".msgErr").html("Invalid Message");
            $("#message").addClass("red");
            submitReady = false;
            count++;
        }
        else{   //clear msgErr
            $(".msgErr").empty();
            $("#message").removeClass("red");
        }

        if((fName == '') || (lName == '') || (phone == '') || (email == '') || (msg == '')){ //all fields are required and must be filled out
            $("#contactForm").html("Please Fill Out All Required Fields");
            submitReady = false;
            count++;
            
        }

        else{   //clear 'fill out all fields' error
            $("#contactForm").empty();
        }

        if(count == 0){     //if no errors exist, form is ready for submission
            submitReady = true;
        }

        if(submitReady){    //submit form to processContact.php for processing
            $.ajax({
                type: "POST",
                url: "processContact.php",
                data: dataString,
                cache: false,
                success: function(result){
                    $("#contactForm").html(result);
                    $('#contact')[0].reset();
                }
            });  
        }

        count = 0; //reset count to check form again
        return false;
    });
});