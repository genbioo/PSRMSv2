<?php
include ('check_credentials.php');
?>
<html>
    <head>
        <?php include("css_include.php");
        ?>
    </head>
    <body>
        <table align="center" cellspacing="3" cellpadding="3" width="75%">
            <tr>
                <td><h2>Add Form</h2>
                  <p>This section is for adding a new form to the database.</p>
                </td>
            </tr>
            <form action="submit_add_form.php" method="post">
                <tr>
                    <td>
                        <br><label for="formType">Form name:</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="text"  class="form-control" name="formType" id="formType">
                        <input type="hidden" name="previous_page" value="<?php echo($_SERVER['HTTP_REFERER']); ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <br><label for="formInstructionse">Form Instructions:</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <textarea class="form-control" rows="5" name="formInstructions" id="formInstructions"></textarea>
                        <?php //<input type="text"  class="form-control" name="formInstructions" id="formInstructions"> ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <br><input type="submit" class="btn btn-info" value="Submit">
                    </td>
                </tr>
            </form>
        </table>
    </body>
</html>