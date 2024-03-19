$.ajax({
    method: 'GET',
    url: `http://localhost/practice/userManagement/routes/web.php/admin`,
    success: function(result) {
        if (result.response.status == 200) {
            const image = document.getElementsByClassName("image")[0];
            image.setAttribute("src", `http://localhost/practice/userManagement/public/uploads/${result.admin[0].profile_picture}`)
        }
    }
})