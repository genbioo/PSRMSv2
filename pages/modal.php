<style type="text/css">




.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0) !important; /* Fallback color */
    background-color: rgba(0,0,0,0.4) !important; /* Black w/ opacity */
    border-radius: 4px;
}

/* Modal Content */
.modal-content {
    position: relative;
    top: 0% !important;
    background-color: #fefefe;
    margin: auto;
    padding: 0;
    border: 1px solid #888;
    width: 100%;
    border-radius: 4px;

    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
    -webkit-animation-name: animatetop;
    -webkit-animation-duration: 1s;
    animation-name: animatetop;
    animation-duration: 1s
}

/* Add Animation */
@-webkit-keyframes animatetop {
    from {top:-300px; opacity:0} 
    to {top:30% !important; opacity:1}
}

@keyframes animatetop {
    from {top:-300px; opacity:0}
    to {top:30% !important; opacity:1}
}

/* The Close Button */
.close {
    color: white;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}

.modal-header {
    padding: 2px 16px;
    background-color: #9368E9;
    color: white;
}

.modal-body {padding: 2px 16px;}

.modal-footer {
    padding: 2px 16px;
    background-color: #9368E9;
    color: white;
}



</style>

<script type="text/javascript">
    

function show_modal(){


    displayDropdownAll();

    // Get the modal
    var modal = document.getElementById('myModal');

    // Get the button that opens the modal
    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close");
    //alert(span.length);
    // When the user clicks the button, open the modal 
    //btn.onclick = function() {
        modal.style.display = "block";


    // When the user clicks on <span> (x), close the modal

    window.onclick = function(event) {
        //alert("true");
        if (event.target == modal) {
            modal.style.display = "none";
        }


    }
}

</script>
