function check_empty() {
    var flag_radio = true;
    var flag_textarea = true;
    var flag_text = true;
    var flag_check = true;

    //check if a radio button is unticked
    $('input:radio').each(function () {
        name = $(this).attr('name');
        if (flag_radio && !$(':radio[name="' + name + '"]:checked').length) {
            flag_radio = false;
        }
    });

    $('input:checkbox').each(function () {
        name = $(this).attr('name');
        if (flag_check && !$(':checkbox[name="' + name + '"]:checked').length) {
            flag_check = false;
        }
    });

    $('input:text').each(function () {
        if (!$.trim($(this).val())) {
         flag_text = false; 
      }
    });

    //check if a textarea is empty
    $('textarea').each(function() {
      if (!$.trim($(this).val())) {
         flag_textarea = false; 
      }
    });

    //if nothing is empty
    if(flag_radio && flag_check && flag_textarea && flag_text) {
        return true;
    } else {
        alert("Please do not leave any field empty before submitting.");
        return false;
    }
}