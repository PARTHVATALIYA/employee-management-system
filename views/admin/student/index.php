<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
        <link rel="stylesheet" href="./../../../public/assets/css/index.css">
        <link rel="stylesheet" href="./../../../public/assets/css/navbar.css">
        <link rel="stylesheet" href="./../../../public/assets/css/sidebar.css">
        <title>Document</title>
    </head>
    <body>
    <?php
        session_start();

        if (isset($_SESSION['user']) && $_SESSION['user'] == 'admin') {
            require './../layout/navbar.php';
            require './../layout/sidebar.php';
    ?>
        <form action="./../../../Controllers/Admin/ExportCsv.php" class="exportData" method="post">
            <div>
                <button class="exportButton" name="export"><i class="fa-regular fa-file-excel me-2"></i>Export</button>
            </div>
        </form>
        <!-- <form action="./../../../Controllers/Admin/ImportCsv.php" class="importData" method="post">
            <div class="d-flex align-items-center">
                <input type="file">
                <div class="">
                    <button class="importButton" name="import">Import CSV</button>
                </div>
            </div>
        </form> -->
        <form action="./../../../Controllers/Admin/GeneratePdf.php" class="generatePdf" method="post">
            <div>
                <button class="generatePdfButton" name="export"><i class="fa-regular fa-file-pdf me-2"></i>Download PDF</button>
            </div>
        </form>
        <button class="backButton" onclick="history.go(-1);"><i class="fa-solid fa-arrow-left"></i></button>
        <table class="table" id="table">
            <thead>
                <th>Profile</th>
                <th>Name</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Phone number</th>
                <th>Grade</th>
                <th>Hobby</th>
                <th>Status</th>
                <th>Mail verified?</th>
                <th>Is approved?</th>
                <th>Action</th>
            </thead>
            <tbody class="allStudentList">

            </tbody>
        </table>
    <?php    
        } else {
            header("location: ./../../auth/login.php");
        }
    ?>
    </body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://kit.fontawesome.com/830d1515a6.js" crossorigin="anonymous"></script>
    <script src="./../../../public/assets/js/index.js"></script>
    <script src="./../../../public/assets/js/navbar.js"></script>
    <script src='./../../../public/assets/js/sidebar.js'></script>

    <?php
        if (isset($_SESSION['status']) && $_SESSION['status'] == 200) {
    ?>
        <script>
            notification("Updated");
        </script>
    <?php
        }
    ?>
</html>