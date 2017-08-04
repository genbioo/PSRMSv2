<?php
require_once("dbcontroller.php");
$db_handle = new DBController();

?>

<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>

        <a class="navbar-brand" href="dashboard.php">PSRMS Admin<sup>(forms beta)</sup></a>
        

        
    </div>
    <!-- /.navbar-top-links -->
    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                
        <?php
        $links = array('Evacuees', 'Forms', 'IDP' );
        foreach ($links as $key => $link) {
        ?>
                <li id="sectionlink<?php echo $key; ?>">
                        <a href = "#" onclick="change<?php echo $key; ?>()"><?php echo ucfirst($link); ?></a>
                </li>
                
        <?php } ?> 
                <li>
                    <a href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
     </div>
</nav>