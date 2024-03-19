window.onload = () => {
    const id = window.location.search.slice(4);
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
    });
    
    $.ajax({
        method: 'GET',
        url: `http://localhost/practice/userManagement/routes/web.php/userData?id=${id}`,
        success: function(result) {
            if (result.response.status == 200) {
                $("#firstname").val(result.users[0].first_name);
                $("#lastName").val(result.users[0].last_name);
                $("#email").val(result.users[0].email);
                $("#phoneNumber").val(result.users[0].phone_number);
                $("#message").val(result.users[0].message);
                const userGrade = result.users[0].grade;
                const option = document.querySelectorAll("option");
                option.forEach((value) => {
                    const grade = value.getAttribute("id");
                    if (userGrade == grade) {
                        value.setAttribute("selected", "");
                        return;
                    }
                });
                const usergender = result.users[0].gender;
                const gender = document.querySelectorAll("input[type='radio']");
                gender.forEach((value) => {
                    const gender = value.getAttribute("value");
                    if (usergender == gender) {
                        value.setAttribute("checked", "");
                        return;
                    }
                });

                let hobbiesArr = [];
                result.users.forEach((user) => {
                    const hobby = user.name;
                    hobbiesArr.push(hobby);
                });
                const hobbies = document.querySelectorAll("input[type='checkbox']");
                hobbies.forEach((value) => {
                    const hobby = value.getAttribute("value");
                    if (hobbiesArr.includes(hobby)) {
                        value.setAttribute("checked", "");
                    }
                });
                const profileImage = document.createElement("img");
                document.getElementById("userProfilePicture").appendChild(profileImage);
                profileImage.setAttribute("src", `http://localhost/practice/userManagement/public/uploads/${result.users[0].profile_picture}`);

            }
        }
    });

    $("input[type='file']").change(function() {
        const numberOfImage = $(this)[0].files.length;
        if (numberOfImage) {
            document.getElementById("userProfilePicture").style.display = "none";
        }
    });
    
    const updateDataButton = $("#updateData");
    updateDataButton.click((event) => {
        $("#userUpdateForm").validate({
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
                event.preventDefault();
                const form = document.getElementById("userUpdateForm");
                const formData = new FormData(form);
                $.ajax({
                    method: 'POST',
                    url: `http://localhost/practice/userManagement/routes/web.php/updateUser?id=${id}`,
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(result) {
                        const response = JSON.parse(result);
                        if (response.status == 200) {
                            window.location.replace("index.php");
                        } else {
                            if (response.message.toLowerCase().includes("duplicate")) {
                                notificationBox("Email or phone is already registered");
                            } else {
                                notificationBox("Something went wrong");
                            }
                        }
                    }
                })
            }
        })
    });
    $.validator.addMethod( "positiveInteger", function( value, element ) {
        return this.optional( element ) || /^\d+$/.test( value );
    }, "A positive non-decimal number please!" );
    $.validator.addMethod( "string", function( value, element ) {
        return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
    }, "Only character consist!" );  
}

const alertBox = () => {
    Swal.fire({
        title: "Updated!",
        text: "User updated successfully!",
        icon: "success"
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.replace("index.php");
        }
    })
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
    }).showToast();
}