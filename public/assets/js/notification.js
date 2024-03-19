$(document).ready(function() {
    $("#sendNotificationForms").validate({
        rules: {
            subject: {
                required: true,
            },
            'recipient[]': {
                required: true,
                maxlength: 5
            },
            description: {
                required: true
            }
        },
        messages: {
            subject: {
                required: "Subject is required",
            },
            'recipient[]': {
                required: "Recipient is required!",
                maxlength: "Maximum recipint selected is 5!"
            },
            description: {
                required: "Description is required!"
            }
        },
        errorPlacement: function (error, element) {
            var placement = $(element).data('error');
            if (placement) {
              $(placement).append(error)
            } else {
              error.insertAfter(element);
            }
        }
    });

    $("#sendNotification").click(function() {
        if ($("#sendNotificationForms").valid()) {
            const selectedUser = document.querySelectorAll(".select2-selection__choice");
            let recipient = "";
            selectedUser.forEach((user) => {
                recipient += user.getAttribute("title") + ",";
            })
            const subject = document.getElementById("subject-name").value;
            const description = document.getElementById("message-description").value;

            $.ajax({
                method: 'POST',
                url: `http://localhost/practice/userManagement/routes/web.php/sendNotification`,
                data: {
                    subject: subject,
                    recipient: recipient,
                    description: description
                },
                success: function(result) {
                    if (result.status == 200) {
                        window.location.reload();
                    }
                }
            })
        }
       
    });
    

    $.ajax({
        method: 'GET',
        url: `http://localhost/practice/userManagement/routes/web.php/userMail`,
        success: function(result) {
            if (result.response.status == 200) {
                result.usersMail.forEach((userMail) => {
                    const numberOfSeachMailsClass = document.getElementsByClassName("recipients").length;
                    const optionElement = document.createElement("option");
                    document.getElementsByClassName("recipients")[numberOfSeachMailsClass - 1].appendChild(optionElement);
                    optionElement.innerHTML = userMail.email;
                    optionElement.setAttribute("value", `${userMail.email}`);
                })
            }
        }
    });

    $("#recipientName").select2({
        // ajax: {
        //     method: 'GET',
        //     url: `http://localhost/practice/userManagement/routes/web.php/userMail`,
        //     processResults: function (result) {
        //         console.log(result.usersMail[0]);
        //         result = Object.assign({}, result.usersMail);
        //         console.log(result);
        //         return {
        //             results: $.map(result, function (item) {
        //                 return {
        //                     text: item.email,
        //                 }
        //             })
        //         }
        //     },
        //     data: function (term) {
        //         return {
        //             term: term
        //         };
        //     },
        // },
        dropdownParent: $('#model'),
        // maximumSelectionLength: 2
    });

    

    $.ajax({
        method: 'GET',
        url: `http://localhost/practice/userManagement/routes/web.php/getNotifications`,
        success: function(result) {
            if (result.response.status == 200) {
                notificationListing(result.notifications);
                $(".table").DataTable({
                    columnDefs: [{ orderable: false, targets: 2 }],
                    order: [[0, 'asc']]
                });
            }
        }
    });


});

const notificationListing = (notifications) => {
    notifications.forEach((notification) => {
        const notificationKeyArr = Object.keys(notification);
        const notificationRow = document.createElement("tr");
        document.getElementsByClassName("notifications")[0].appendChild(notificationRow);
        notificationRow.classList.add("notificationRow");
        
        const numberOfNotificationRowClass = document.getElementsByClassName("notificationRow").length;
        notificationKeyArr.forEach((key) => {
            if (key == 'id') {
                return;
            }
            const notificationData = document.createElement("td");
            document.getElementsByClassName("notificationRow")[numberOfNotificationRowClass - 1].appendChild(notificationData);
            notificationData.classList.add(key);
            notificationData.innerHTML = notification[key];
        });

        const showButton = document.createElement("td");
        document.getElementsByClassName("notificationRow")[numberOfNotificationRowClass - 1].appendChild(showButton);
        showButton.classList.add("showButton");

        const numberOfShowButtonClass = document.getElementsByClassName("showButton").length;
        const button = document.createElement("button");
        document.getElementsByClassName("showButton")[numberOfShowButtonClass - 1].appendChild(button);
        button.classList.add('btn', 'show');
        button.innerHTML = "Show";
        button.setAttribute("data-bs-toggle", "modal");
        button.setAttribute("data-bs-target", "#notificationDataModel");
        button.setAttribute("id", `${notification.id}`);

    });
    const showButton = document.querySelectorAll(".show");
    showButton.forEach((button) => {
        button.addEventListener("click", () => {
            const id = button.getAttribute("id");
            getNotificationData(id);
        })
    })
}

const getNotificationData = (id) => {
    $.ajax({
        method: 'GET',
        url: `http://localhost/practice/userManagement/routes/web.php/getNotificationData?id=${id}`,
        success: function(result) {
            if (result.response.status == 200) {
                document.getElementById("subject").innerHTML = result.notification[0].subject;
                document.getElementById("recipient").innerHTML = result.notification[0].recipient;
                document.getElementById("description").innerHTML = result.notification[0].description;
            }
        }
    })
}