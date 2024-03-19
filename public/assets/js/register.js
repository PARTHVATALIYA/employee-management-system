$(document).ready(function() {

    const submitButton = document.getElementById("submitData");
    submitButton.addEventListener("click", () => {
        $("#studentForm").validate({
            rules: {
                firstname: {
                    required : true,
                    minlength : 2,
                    string : true
                },
                lastName: {
                    required : true,
                    minlength : 2,
                },
                email: {
                    required : true,
                    minlength : 5
                },
                phoneNumber: {
                    required : true,
                    minlength: 10,
                    maxlength: 10,
                    positiveInteger: true
                },
                gender: {
                    required : true
                },
                'hobby[]': {
                    required : true,
                },
                password: {
                    required : true,
                    minlength : 5
                },
                confirmPassword: {
                    required : true,
                    minlength : 5
                },
                message: {
                    required : true,
                    minlength : 5
                },
                'profilePicture[]': {
                    required: true
                }
            },
            messages : {
                firstname : {
                    required : "Plaese enter your first name",
                    minlength : "Your first name must consist of at least 2 character"
                },
                lastName : {
                    required : "Plaese enter your last name",
                    minlength : "Your last name must consist of at least 2 character",
                },
                email : {
                    required : "Plaese enter your email",
                    minlength : "Your email must consist of maximum 5 character",
                },
                phoneNumber : {
                    required : "Plaese enter your phone number",
                    minlength: "Your phone number must consist of maximum 10 digits",
                    maxlength: "Your phone number maximum consist of maximum 10 character"
                },
                gender : {
                    required : "Plaese select your gender",
                },
                'hobby[]' : {
                    required : "Plaese select your hobby",
                },
                password : {
                    required : "Plaese enter your password",
                    minlength : "Your password must consist of 5 character",
                },
                confirmPassword: {
                    required : "Plaese enter your confirm password",
                    minlength : "Your password must consist of 5 character",
                },
                message: {
                    required : "Plaese enter your message",
                    minlength : "Your message must consist of 5 character",
                },
                'profilePicture[]': {
                    required: "Please enter yout profile picture",
                }
            },
            errorPlacement: function(error, element) {
                var placement = $(element).data('error');
                if (placement) {
                  $(placement).append(error)
                } else {
                  error.insertAfter(element);
                }
            },
            submitHandler: function() {
                const password = document.getElementById("password").value;
                const confirmPassword = document.getElementById("confirmPassword").value;

                if (password === confirmPassword) {
                    const form = document.getElementById("studentForm");
                    const formData = new FormData(form);

                    document.getElementById("formLoader").style.display = "flex";
                    document.getElementById("registrationForm").style.display = "none";

                    $.ajax({
                        method: 'POST',
                        url: `http://localhost/practice/userManagement/routes/web.php/registration`,
                        data: formData,
                        contentType: false,
                        cache: false,
                        processData: false,
                        success: function(result) {
                            const response = JSON.parse(result);
                            document.getElementById("formLoader").style.display = "none";
                            if (response.status == 201) {
                                alertBox("Mail send", response.message, "success", "center", true, false, 0, false);
                            } else {
                                if (response.message.toLowerCase().includes("duplicate")) {
                                    notificationBox("Email or phone is already registered");
                                } else {
                                    notificationBox("Something went wrong!");
                                }
                            }

                        }
                    })
                } else {
                    document.getElementById("passwordError").innerHTML = "Password must be same";
                }
            }
        });
        $.validator.addMethod( "positiveInteger", function( value, element ) {
            return this.optional( element ) || /^\d+$/.test( value );
        }, "A positive non-decimal number please!" );
        $.validator.addMethod( "string", function( value, element ) {
            return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
        }, "Only character consist!" );        
    })

    $.ajax({
        method: 'GET',
        url: 'http://localhost/practice/userManagement/routes/web.php/grade',
        success: function(result) {
            result.grades.forEach((grade) => {
                const gradeOption = document.createElement("option");
                document.getElementsByClassName("grades")[0].appendChild(gradeOption);
                gradeOption.classList.add("grade");
                gradeOption.setAttribute("id", `${grade.grade}`);
                gradeOption.innerHTML = grade.grade;
            })
        }
    })
})

const alertBox = (title, text, icon, position, confirmButton, closeButton, timer, timerProgressBar) => {
    Swal.fire({
        position: position,
        title: title,
        text: text,
        icon: icon,
        showConfirmButton: confirmButton,
        showCloseButton: closeButton,
        timer: timer,
        timerProgressBar: timerProgressBar
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.replace("login.php");
        }
    });
}

const notificationBox = (msg) => {
    Toastify({
        text: msg,
        close: true,
        stopOnFocus: true,
        style: {
            background: "#FF0000",
            color: "#ffffff"
          },
        onClick: document.getElementById("registrationForm").style.display = "flex"
    }).showToast();
}