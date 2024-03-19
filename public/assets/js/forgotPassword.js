$(document).ready(function() {
    const submitButton = document.getElementById("sendMail");
    submitButton.addEventListener("click", () => {
        $("#forgotPasswordForm").validate({
            rules: {
                email: {
                    required: true,
                    minlength: 5
                }
            },
            messages: {
                email: {
                    required: "Email is required!",
                    minlength: 'Enter valid email!'
                }
            },
            submitHandler: function() {
                document.getElementById("loading").style.display = "flex";
                document.getElementById("form").style.display = "none";
                $.ajax({
                    method: 'POST',
                    url: `http://localhost/practice/userManagement/routes/web.php/forgotPassword`,
                    data: {
                        email: document.getElementById("email").value
                    },
                    success: function(result) {
                        console.log(result);
                        document.getElementsByClassName("mailSend")[0].style.display = "block";
                        document.getElementById("text").innerHTML = "If the mail is associated with a personal user account then reset password link send to your mail address."
                        document.getElementById("loading").style.display = "none";
                        document.getElementById("form").style.display = "flex";
                    }
                });
            }
        });
    });
});