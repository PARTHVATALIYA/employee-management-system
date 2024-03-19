$(document).ready(function() {
    const id = window.location.search.slice(4);

    $.ajax({
        method: 'GET',
        url: `http://localhost/practice/userManagement/routes/web.php/showUser?id=${id}`,
        success: function(result) {
            if (result.response.status == 200) {
                document.getElementById("firstname").innerHTML = result.user[0].first_name.charAt(0).toUpperCase() + result.user[0].first_name.slice(1);
                document.getElementById("lastName").innerHTML = result.user[0].last_name.charAt(0).toUpperCase() + result.user[0].last_name.slice(1);
                document.getElementById("email").innerHTML = result.user[0].email;
                document.getElementById("userName").innerHTML = result.user[0].user_name;
                document.getElementById("grade").innerHTML = result.user[0].grade;
                document.getElementById("phoneNumber").innerHTML = result.user[0].phone_number;
                document.getElementById("gender").innerHTML = result.user[0].gender;
                document.getElementById("hobby").innerHTML = result.user[0].hobbies;
                document.getElementById("message").innerHTML = result.user[0].message;

                const image = document.createElement("img");
                document.getElementById("userProfilePicture").appendChild(image);
                image.setAttribute("src", `http://localhost/practice/userManagement/public/uploads/${result.user[0].profile_picture}`)
            }
        }
    });
})