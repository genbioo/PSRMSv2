//<--edit_forms.php => Edit answer field button click
//clicked_id is the button ID where button ID == QuestionsID in DB
function btn_add(clicked_id) 
{
    $('#'+clicked_id).hide()
    $('#select-wrapper'+clicked_id).show();
}
//-->

//<--function for form preview
//setting content of "preview-wrapper" <td> with the selected html form, clicked_id is the button ID which is "set"+idnumber where idnumber == QuestionsID in DB
function set_click(clicked_id)
{
    var id = clicked_id.replace("set","");
    var form = $('#formSelect'+id).val();   //get html form selected
    var range = $('#range'+id).val();       //get range selected
    $('#select-wrapper'+id).hide();         //hide div with select forms


    if(form === 'radio') {
        //radio form template
        var myRadio = "<form>";
        for(i=0; i < range; i++) {
            myRadio += "<label class=\'radio-inline\'><input type=\'radio\' name='opt-radio'>";
            myRadio += i;
            myRadio += "</label>";
        }
        myRadio += "</form>";
        $('#preview-wrapper'+id).html(myRadio);
        $('#edit-answer-field-button-'+id).show();
    }

    if(form === 'checkbox') {
        //checkbox form template
        var myCheckbox = "<form>";
        for(i=0; i < range; i++) {
            myCheckbox += "<label class=\'checkbox-inline\'><input type=\'checkbox\' name='opt-checkbox'>";
            myCheckbox += i;
            myCheckbox += "</label>";
        }
        myCheckbox += "</form>";
        $('#preview-wrapper'+id).html(myCheckbox);
        $('#edit-answer-field-button-'+id).show();
    }

    if(form === 'text') {
        //textbox form template
        var myText = "<form>";
        myText += "<input class='form-control' id='inputdefault' type='text'>";
        myText += "</form>";
        $('#preview-wrapper'+id).html(myText);
        $('#edit-answer-field-button-'+id).show();
    }

    if(form === 'textarea') {
        //textarea form template
        var myTextarea = "<form>";
        myTextarea += "<textarea class='form-control' rows='5' id='comment'></textarea>";
        myTextarea += "</form>";
        $('#preview-wrapper'+id).html(myTextarea);
        $('#edit-answer-field-button-'+id).show();
    }
}
//-->

//<--edit_forms.php => edit question button click
function show_edit_interface() {
    $('#edit-questions-button').hide();
    $('.btn.btn-warning.btn-xs').show();
    $('[name="toggleCheckbox"]').show();
    $('[name="checkbox"]').show();
    $('#add-answer-field-button').show();
}
//-->

//<--edit_forms.php => Add answer fields button click
function add_answer_field() {
    var yourArray = [];
    $("input:checkbox[name='checkbox']:checked").each(function(){
        yourArray.push($(this).val());
    });
    for (i=0; i<yourArray.length; i++) {
        $('#select-wrapper'+yourArray[i]).show();
        $('.q-select-'+yourArray[i]).remove();
    }
}
//-->

//<--select all toggle for edit_forms.php
function toggle(source) {
  checkboxes = document.getElementsByName('checkbox');
  for(var i=0, n=checkboxes.length;i<n;i++) {
    checkboxes[i].checked = source.checked;
  }
}

$('input:checkbox').change(function () {
    $('#add-answer-field-button:button').prop('disabled', $('input:checkbox:checked').length == 0)
})
//select all toggle for edit_forms.php-->