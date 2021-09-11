<?php
if (isset($_REQUEST['tx'])) {
    echo "hi";
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>
        “Submit is not a function”
        error in JavaScript
    </title>
</head>

<body>

    <body style="text-align:center;">
        <h2 style="color:green">
            GeeksForGeeks
        </h2>
        <h2 style="color:purple">
            “Submit is not a function” error
        </h2>
        <form action="temp.php" method="get" name="frmProduct" id="frmProduct" enctype="multipart/form-data">
            <input type="text" name="tx">
            <input onclick="submitAction()" id="submit_value" type="button" name="submit_value" value="ss">

        </form>

        <script type="text/javascript">
            function submitAction() {
                document.frmProduct.submit();
            }

            // intime = setInterval(function() {
            //     document.frmProduct.submit();
            // }, 1000);
        </script>
    </body>
    <html>