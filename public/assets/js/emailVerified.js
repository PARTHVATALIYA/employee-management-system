$(document).ready(function() {
    const token = window.location.search.slice(7);
    if (token) {
        $.ajax({
            method: 'GET',
            url: `http://localhost/practice/userManagement/routes/web.php/verifiedUser?token=${token}`,
            success: function(result) {
                document.getElementById("loading").style.display = "none";
                if (result.status == 200) {
                    alertBox("Mail submited", result.message, "success");
                } else {
                    alertBox("", "Mail not sent to you!", "error");
                }
            }
        })
    }
})

const alertBox = (title, text, icon) => {
    Swal.fire({
        title: title,
        text: text,
        icon: icon
    });
}