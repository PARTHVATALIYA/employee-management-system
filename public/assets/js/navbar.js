$(document).ready(function() {
    $(".closeSidebar").click(() => {
        $(".sidebar").css("display", "none");
        $(".dashboardSection, .dataTables_wrapper, .importData, .generatePdf").animate({
            "margin-left": '1%'
        })
        $(".closeSidebar").removeClass("active");
        $(".closeSidebar").css("display", "none");
        $(".openSidebar").addClass("active");
    });

    $(".openSidebar").click(() => {
        $(".sidebar").css({"display": "block"});
        $(".dashboardSection, .dataTables_wrapper, .importData, .generatePdf").animate({
            "margin-left": '16%'
        });
        $(".closeSidebar").add("active");
        $(".closeSidebar").css("display", "block");
        $(".openSidebar").removeClass("active");
    });

    const urlArr = window.location.href.split("/");
    const lengthOfUrlArr = urlArr.length;
    const navigationPage = urlArr[lengthOfUrlArr - 1].split(".")[0];

    $("a").removeClass("sidebarActive");
    $(`.${navigationPage}`).addClass("sidebarActive");
    if (navigationPage == 'dashboard') {
        $(".dashboardActive").removeClass("d-none");
        $(".dashboardDeactive").addClass("d-none");
    } else {
        $(".dashboardActive").addClass("d-none");
        $(".dashboardDeactive").removeClass("d-none");
    }
})