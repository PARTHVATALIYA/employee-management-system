window.onload = () => {
    $.ajax({
        method: 'GET',
        url: `http://localhost/practice/userManagement/routes/web.php/userProfile`,
        success: function(result) {
            console.log(result);
            if (result.response.status == 200) {
                const userName = document.createElement("h1");
                document.getElementsByClassName("user")[0].appendChild(userName);
                userName.innerHTML = `Hello ${result.userProfile[0].first_name.charAt(0).toUpperCase() + result.userProfile[0].first_name.slice(1)} ${result.userProfile[0].last_name}!`;

                const image = document.createElement("img");
                document.getElementsByClassName("image")[0].appendChild(image);
                image.setAttribute("src", `http://localhost/practice/userManagement/public/uploads/${result.userProfile[0].profile_picture}`)

                const profile = document.getElementsByClassName("profile")[0];
                profile.setAttribute("href", `profile.php?id=${result.userProfile[0].id}`)
            }
        }
    });
}