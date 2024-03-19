window.onload = () => {
    $.ajax({
        method: 'GET',
        url: 'http://localhost/practice/userManagement/routes/web.php/userData',
        success: function(result) {
            if (result.response.status == 200) {
                userListing(result.users);
                new DataTable('.table', {
                    columnDefs: [{ orderable: false, targets: [0, 10] }],
                    order: [[1, 'asc']],
                    scrollX: true
                });
            } else {
                document.getElementsByTagName("tbody")[0].innerHTML = "No user found!";
            }
        }
    });
}

const deleteUser = (id) => {
    $.ajax({
        method: 'DELETE',
        url: `http://localhost/practice/userManagement/routes/web.php/deleteUser?id=${id}`,
    })
}

const toggle = (id) => {
    $.ajax({
        method: 'POST',
        url: `http://localhost/practice/userManagement/routes/web.php/changeUserStatus?id=${id}`
    })
}

const approveUser = (id) => {
    $.ajax({
        method: 'POST',
        url: `http://localhost/practice/userManagement/routes/web.php/approveUser?id=${id}`,
        success: function(result) {
            if (result.status == 200) {
                Swal.fire({
                    title: 'Approved!',
                    text: 'User approved successfully!',
                    icon: 'success',
                }). then((result) => {
                    if (result.isConfirmed) {
                        window.location.reload("index.php");
                    }
                })
            }
        }
    })
}

const userListing = (users) => {
    users.forEach((user) => {
        const userRow = document.createElement("tr");
        document.getElementsByTagName("tbody")[0].appendChild(userRow);
        userRow.classList.add("userRow");

        const numberOfuserRowClass = document.getElementsByClassName("userRow").length;
        const userKeyArr = Object.keys(user);
        
        userKeyArr.forEach((key) => {
            if (key == 'id') {
                return;
            }
            const userData = document.createElement("td");
            document.getElementsByClassName("userRow")[numberOfuserRowClass - 1].appendChild(userData);
            userData.classList.add("userData", key);
            
            const numberOfStatusClass = document.getElementsByClassName("status").length;
            if (key == 'status') {
                const toggle = document.createElement("div");
                document.getElementsByClassName("status")[numberOfStatusClass - 1].appendChild(toggle);
                toggle.classList.add("toggle");

                const numberOfToggleClass = document.getElementsByClassName("toggle").length;
                const toggleButton = document.createElement("div");
                document.getElementsByClassName("toggle")[numberOfToggleClass - 1].appendChild(toggleButton);
                toggleButton.classList.add("toggleButton");
                toggleButton.setAttribute("id", `toggle_${user.id}`);

                if (user.status == 'active') {
                    toggle.setAttribute("id", `active_${user.id}`);
                    toggle.classList.add("active");
                } else {
                    toggle.setAttribute("id", `deActive_${user.id}`);
                    toggle.classList.add("deActive")
                }

                // const toggleButton = document.createElement("input");
                // document.getElementsByClassName("toggle")[numberOfToggleClass - 1].appendChild(toggleButton);
                // toggleButton.setAttribute("type", "checkbox");
                // toggleButton.setAttribute("data-toggle", "toggle");
                // toggleButton.setAttribute("data-on", "Active");
                // toggleButton.setAttribute("data-off", "Deactive");
                // toggleButton.setAttribute("data-onstyle", "success");
                // toggleButton.setAttribute("data-offstyle", "danger");

            // if (user.status == 'active') {
            //     // toggle.setAttribute("id", `active_${user.id}`);
            //     // toggle.classList.add("active");
            //     toggleButton.setAttribute("checked", "");
            // } else {
            //     toggleButton.removeAttribute("checked");
            //     // toggle.setAttribute("id", `deActive_${user.id}`);
            //     // toggle.classList.add("deActive")
            // }
                

            } else if (key == 'is_verified') {
                if (user[key] == 1) {
                    userData.innerHTML = "&#x2705;";
                } else {
                    userData.innerHTML = "&#x274C";
                }
            } else if (key == 'is_approved') {
                if (user[key] == "1") {
                    userData.innerHTML = "Approved";
                } else {
                    const numberOfApproveUserClass = document.getElementsByClassName("is_approved").length;
                    const approveUserButton = document.createElement("button");
                    document.getElementsByClassName("is_approved")[numberOfApproveUserClass - 1].appendChild(approveUserButton);
                    approveUserButton.classList.add("btn", "approveUserButton");
                    approveUserButton.setAttribute("id", `approve_${user.id}`);
            
                    approveUserButton.innerHTML = "Approve"
                }
            } else if (key == 'profile_picture') {
                const numberOfProfileClass = document.getElementsByClassName("profile_picture").length;

                const profileImage = document.createElement("img");
                document.getElementsByClassName("profile_picture")[numberOfProfileClass - 1].appendChild(profileImage);
                profileImage.setAttribute("src", `http://localhost/practice/userManagement/public/uploads/${user.profile_picture}`);
            }
             else {
                if (user[key] == "" || user[key] == null) {
                    userData.innerHTML = "NA";
                } else {
                    userData.innerHTML = user[key];
                }
            }
        });

        const actionOnUserData = document.createElement("td");
        document.getElementsByClassName("userRow")[numberOfuserRowClass - 1].appendChild(actionOnUserData);
        actionOnUserData.classList.add("actionOnUserData", "dropdown");

        const numberOfActionOnUserDataClass = document.getElementsByClassName("actionOnUserData").length;
        const actionButton = document.createElement("button");
        document.getElementsByClassName("actionOnUserData")[numberOfActionOnUserDataClass - 1].appendChild(actionButton);
        actionButton.classList.add("actionButton");
        actionButton.innerHTML = "Action"

        const dropdownButtons = document.createElement("div");
        document.getElementsByClassName("actionOnUserData")[numberOfActionOnUserDataClass - 1].appendChild(dropdownButtons);
        dropdownButtons.classList.add("dropdownButtons");

        const numberOfDropdownButtons = document.getElementsByClassName("dropdownButtons").length;
        const deleteButton = document.createElement("button");
        document.getElementsByClassName("dropdownButtons")[numberOfDropdownButtons - 1].appendChild(deleteButton);
        deleteButton.classList.add("btn", "btn-danger", "deleteButton");
        deleteButton.setAttribute("id", `delete_${user.id}`)
        deleteButton.innerHTML = "Delete"
        
        const updateButton = document.createElement("button");
        document.getElementsByClassName("dropdownButtons")[numberOfDropdownButtons - 1].appendChild(updateButton);
        updateButton.classList.add("btn", "btn-primary", "updateButton");

        const numberOfUpdateButtonClass = document.getElementsByClassName("updateButton").length;
        const updateUser = document.createElement("a");
        document.getElementsByClassName("updateButton")[numberOfUpdateButtonClass - 1].appendChild(updateUser);
        updateUser.classList.add("updateUser", "text-decoration-none", "text-light");
        updateUser.setAttribute("id", `update_${user.id}`);
        updateUser.setAttribute("href", `edit.php?id=${user.id}`);
        updateUser.innerHTML = "Update"

        const showButton = document.createElement("button");
        document.getElementsByClassName("dropdownButtons")[numberOfDropdownButtons - 1].appendChild(showButton);
        showButton.classList.add("btn", "showButton");

        const numberOfShowButtonClass = document.getElementsByClassName("showButton").length;
        const showUser = document.createElement("a");
        document.getElementsByClassName("showButton")[numberOfShowButtonClass - 1].appendChild(showUser);
        showUser.classList.add("showUser", "text-decoration-none", "text-light");
        showUser.setAttribute("id", `show_${user.id}`);
        showUser.setAttribute("href", `show.php?id=${user.id}`);
        showUser.innerHTML = "Show"
    })

    const deleteButton = document.querySelectorAll(".deleteButton");
    deleteButton.forEach((button) => {
        button.addEventListener("click", () => {
            const id = button.getAttribute("id").slice(7);
            Swal.fire({
                title: 'Are you sure to delete this user?',
                text: "You won't be able to retrive this user!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete!"
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteUser(id);
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'User deleted successfully!',
                        icon: 'success'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.reload();
                        }
                    });
                }
            })
        }) 
    })

    const approveUserButton = document.querySelectorAll(".approveUserButton");
    approveUserButton.forEach((button) => {
        button.addEventListener("click", () => {
            const id = button.getAttribute("id").slice(8);
            Swal.fire({
                title: 'Approve this user?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, approve!"
            }).then((result) => {
                if (result.isConfirmed) {
                    approveUser(id);
                }
            })
        })
    })

    const toggleButton = document.querySelectorAll(".toggle");
    toggleButton.forEach((button) => {
        button.addEventListener("click", () => {
            Swal.fire({
                title: "Are you sure",
                text: "You want to change the status of user",
                icon: "question",
                showCancelButton: true
            }). then((result) => {
                if (result.isConfirmed) {
                    if (button.getAttribute("class") == 'toggle active') {
                        const id = button.getAttribute("id").slice(7);
                        button.classList.remove('active');
                        button.classList.add("deActive");
                        toggle(id);
        
                    } else if (button.getAttribute("class") == 'toggle deActive') {
                        const id = button.getAttribute("id").slice(9);
                        button.classList.add("active");
                        button.classList.remove("deActive");
                        toggle(id);
        
                    }
                }
            })
            
        })
    })
}

const notification = (msg) => {
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