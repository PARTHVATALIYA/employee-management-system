$(document).ready(function() {
    const submitButton = $("#login");
    submitButton.click(()=> {
        $("#loginForm").validate({
            rules: {
                userName: {
                    required: true,
                },
                password: {
                    required: true,
                }
            },
            messages: {
                userName: {
                    required: "User name required!"
                },
                password: {
                    required: "Password required!"
                }
            },
            submitHandler: function() {
                const form = document.getElementById("loginForm");
                const formData = new FormData(form);
                $.ajax({
                    method: 'POST',
                    url: `http://localhost/practice/userManagement/routes/web.php/login`,
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(result) {
                        if (result.response.status == 200) {
                            if (result.user[0].role == 'admin') {
                                window.location.replace("./../admin/dashboard.php");
                            } else {
                                const user = result.user[0];
                                if (user.is_verified == 1) {
                                    if (user.is_approved == 1) {
                                        if (user.status == 'active') {
                                            window.location.replace("./../students/dashboard.php");
                                        } else {
                                            notificationBox("You are de-active! Please contact admin!");
                                        }
                                    } else {
                                        notificationBox("You are not approved by admin!")
                                    }
                                }
                                else {
                                    notificationBox("Please verify your mail!")
                                }
                            }
                        } else {
                            notificationBox("Invalid user name or password");
                        }
                    }
                })
            }
        })        
    });

    // const loginWithGoogle = $(".btn");
    // loginWithGoogle.click(() => {
    //     console.log("object");
    // })
    
});

const notificationBox = (msg) => {
    Toastify({
        text: msg,
        close: true,
        stopOnFocus: true,
        style: {
            background: "#FF0000",
            color: "#ffffff"
          },
    }).showToast();
}