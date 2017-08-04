
    <div class="sidebar" data-color="blue">

    	<div class="sidebar-wrapper">
            <div class="logo">
                <a href="#" class="simple-text">
                   PSRMS
                </a>
            </div>

            <ul class="nav">
                <li class="<?php echo $ul_index; ?>" onClick = "activate()" id ="Summary">
                    <a href="dashboard.php">
                        <i class="pe-7s-graph"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li id = "m_idp" class="<?php echo $ul_list; ?>">
                    <a href="list.php" class="<?php echo $ul_idp; ?>"> 

                         <i class="pe-7s-user"></i>
                         <p> Manage IDPs  </p>

                          <span class="menu-arrow arrow_carrot-right"></span>
                      </a>
                  
                </li>
                <li class="<?php echo $ul_forms; ?>">
                    <a href="forms.php">
                        <i class="pe-7s-note2"></i>
                        <p>Forms/ Tools</p>
                    </a>
                </li>
                <li class="<?php echo $ul_assessment; ?>">
                    <a href="assessment.php">
                        <i class="pe-7s-news-paper"></i>
                        <p>Assessment</p>
                    </a>
                </li>
                <li class="<?php echo $ul_evac; ?>">
                    <a href="evacuation_center.php">
                        <i class="pe-7s-home"></i>
                        <p>Manage Evacuation Center</p>
                    </a>
                </li>
            </ul>
    	</div>
    </div>
                                

