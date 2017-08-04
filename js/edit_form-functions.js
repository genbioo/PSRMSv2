
//------------------------------------VARIABLES----------------------------------->
//-------------------------------------------------------------------------------->
//array of ids of selected(checked) questions
var s_question_ids = [];
var temp_squestion_ids = []; //temporary value

//array of answertypes of selected questions
var s_a_type = [];
var temp_s_a_type = []; //temporary value

//length of s_questions_ids
var s_qid_len = 0;

//array of all ids of the questions
var question_ids = $("input[name='checkbox']").map(function (i) {
                        return $(this).val();
                    }).get();

//array of all answertypes of the questions. Values taken from hidden input #'n'-ans-type where 'n' = question ID
var a_type =    $("input[name='checkbox']").map(function (i) {
                    return $("#"+$(this).val()+"-ans-type").val();
                }).get();

//length of question_ids
var qid_len = question_ids.length;

//question_id, answer type 2d array
var qid_atype_2da = create2dArray(question_ids, a_type);

//total number of name="checkbox" checkboxes.
var checkbox_total = $('input[name="checkbox"]').length;

//--------------------------------------------------------------------------------->
//--------------------------------------------------------------------------------->

function preview_form(source) {
    if(source.value === "preview") {
        $('[name="preview-wrapper"]').show();
        $('#preview-form-button').prop('value', 'hide preview');
    } else {
        $('[name="preview-wrapper"]').hide();
        $('#preview-form-button').prop('value', 'preview');
    }
    
}

//<--edit_form.php => Edit answer field button click
//clicked_id is the button ID where button ID == QuestionsID in DB
function edit_ansf(clicked_id) {
    if($('#edit-answer-field-button-'+clicked_id).val() === "Edit answer field") {
        $('#edit-answer-field-button-'+clicked_id).prop('value', "cancel");
        $('#'+clicked_id).hide();
        $('#select-wrapper'+clicked_id).show();
    } else {
        $('#edit-answer-field-button-'+clicked_id).prop('value', 'Edit answer field');
        $('#'+clicked_id).show();
        $('#select-wrapper'+clicked_id).hide();
    }
}
//-->

//<--function for form preview
//setting content of "preview-wrapper" <td> with the selected html form, clicked_id is the button ID which is "set"+idnumber where idnumber == QuestionsID in DB <-> type === single or multiple
function display_form(clicked_id, atype, type) {
    var id;
    var form;
    var range;
    
    //if type is multiple, get dropdown value from universal #quantiDropdown and #quantiRangeDropdown
    //else get dropdown value from corresponding dropdowns
    if (type === 'multiple') {
        id = clicked_id;
        if(atype == '1') {
            form = $('#quantiDropdown').val();
            range = $('#quantiRangeDropdown').val();
        } else if (atype == '2') {
            form = $('#qualiDropdown').val();
        }
    } else if (type === 'single') {
        id = clicked_id.replace('set','');
        $('#edit-answer-field-button-'+id).prop('value', 'Edit answer field');
        $('#preview-wrapper'+id).show();
        if(atype == '1') {
            form = $('#formSelect'+id).val();
            range = $('#range'+id).val();
        } else if (atype == '2') {
            form = $('#formSelect'+id).val();
        }
    }

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
        
        //set dropdown values. Setting these values is needed for submit
        $('#formSelect'+id+' option[value='+form+']').prop('selected', true);
        $('#range'+id+' option[value='+range+']').prop('selected', true);
    } else if(form === 'checkbox') {
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
        
        //set dropdown values. Setting these values is needed for submit
        $('#formSelect'+id+' option[value='+form+']').prop('selected', true);
        $('#range'+id+' option[value='+range+']').prop('selected', true);
    } else if(form === 'text') {
        //textbox form template
        var myText = "<form>";
        myText += "<input class='form-control' id='inputdefault' type='text'>";
        myText += "</form>";
        $('#preview-wrapper'+id).html(myText);
        $('#edit-answer-field-button-'+id).show();
        
        //set dropdown values. Setting this value is needed for submit
        $('#formSelect'+id+' option[value='+form+']').prop('selected', true);
    } else if(form === 'textarea') {
        //textarea form template
        var myTextarea = "<form>";
        myTextarea += "<textarea class='form-control' rows='5' id='comment'></textarea>";
        myTextarea += "</form>";
        $('#preview-wrapper'+id).html(myTextarea);
        $('#edit-answer-field-button-'+id).show();
        
        //set dropdown values. Setting this value is needed for submit
        $('#formSelect'+id+' option[value='+form+']').prop('selected', true); 
    } else {
        //none
    }
    $('#select-wrapper'+id).hide();
    $('#preview-wrapper'+id).show();
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
    var sqidlength = s_question_ids.length;
    $('[name="preview-wrapper"]').show(); //set preview-wrapper to visible
    $('#preview-form-button').prop('value', 'hide preview'); //alter preview form button state
    for (var i = 0; i < sqidlength; i++) {
        $('.q-select-'+s_question_ids[i]).remove(); //remove checkbox\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
        checkbox_total = $('input[name="checkbox"]').length; //update checkbox total\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
        display_form(s_question_ids[i], s_a_type[i], 'multiple');
        if(!checkbox_total) {
            $('[name="toggleCheckbox"]').remove();
            $('#add-answer-field-button').remove();
        }
    }
    $("input[name='checkbox']").prop('checked', true);
    $("input[name='checkbox']").hide();
}
//-->

function add_and_save() {
    add_answer_field();
    document.getElementById('form-layout').submit();
}


//function to create 2d array from id array and answertype array
function create2dArray(ids_array, ansType_array) {
    var twoD_array = [];
    
    for(var i = 0; i < qid_len; i++) {
        twoD_array.push([ids_array[i], ansType_array[i]]);
    }
    
    return twoD_array;
}


//checkbox onclick function
function toggle(source) {
    if(source.id === "toggle") {
        
        //select all checkbox toggle for edit_forms.php
        checkboxes = document.getElementsByName('checkbox');
        for(var i=0, n=checkboxes.length;i<n;i++) {
            checkboxes[i].checked = source.checked;
        }

        //function to add checked ids to array
        addCheckedToArray();
        //alert(s_question_ids.toString());
        
        s_qid_len = s_question_ids.length;
        toggleState(s_qid_len);
        
    } else {
        
        //function to add checked ids to array
        addCheckedToArray();
        //alert(s_question_ids.toString());
        
        s_qid_len = s_question_ids.length;
        toggleState(s_qid_len);
    }
}
//-->

//<--adding checked checkboxes' id to s_question_ids array and answer types to s_a_type array. Array will be used to assign html forms on each question based on selection in #add_answer_fields_modal or #form-slect(n) dropdowns; n = questionID
function addCheckedToArray() {
    s_question_ids = $("input[name='checkbox']:checked").map(function (i) {
        return $(this).val();
    }).get();
    
    s_a_type = $("input[name='checkbox']:checked").map(function (i) {
                   return $("#"+$(this).val()+"-ans-type").val();
               }).get();
}
//-->

//<--toggle state of #add-answer-field-button and #toggle checkbox
function toggleState(qid_length) {
    
    //toggle #add-answer-field-button state and text depending on checkboxes' statuses
    if(qid_length) {
        $('#add-answer-field-button:button').attr("disabled", false);
        $('#add-answer-field-button:button').prop('value', 'Select answer field for selected questions');
    } else {
        $('#add-answer-field-button:button').attr("disabled", true);
        $('#add-answer-field-button:button').prop('value', 'Select questions first...');
    }
    
    //toggle #toggle checkbox state depending on checkboxes' statuses
    if(s_qid_len === checkbox_total) //if all questions are checked
    {
        $('#toggle').prop('checked', true); //check toggle checkbox
    } else {
        $('#toggle').prop('checked', false);//uncheck toggle checkbox
    }
}
//-->

//<--function to determine if the form has quanti, quali, or mixed questions
function hasForm(atypes) {
    var hasQuanti = false;
    var hasQuali = false;   
    
    //set hasQuanti/hasQuali truth value depending on atypes entries
    for(i = 0; i < atypes.length; i++) {
        if(atypes[i] === '1') hasQuanti = true;
        else if (atypes[i] === '2') hasQuali = true;
    }
    
    if(hasQuali && hasQuanti) return 3; //if atypes array has quali(2) and quanti(1), return 3
    else if(hasQuali) return 2;         //else if atypes array has quali(2) only, return 2
    else if(hasQuanti) return 1;        //else if atypes array has quanti(1) only, return 1
    else return null;
}

function displayDropdownAll() {
    $("input[name='checkbox']").show();
    $("input[name='checkbox']").prop('checked', true);
    addCheckedToArray();
    displayDropdown();
}

function displayDropdown() {
    var myQuantiDropdown = '<table><tr><h4>For quantitative questions</h4></tr><tr><td style="width:30%"><select class="form-control" id="quantiDropdown"><option value="radio" selected="selected">Radio Button</option><option value="checkbox">Check box</option></select></td><td style="width:15%"><select class="form-control" id="quantiRangeDropdown">';
    for(x=2;x<=9;x++) {
        myQuantiDropdown = myQuantiDropdown + '<option value="'+x+'">'+x+' options</option>';
    }
    myQuantiDropdown += '</select></td></tr></table>';
    
    var myQualiDropdown = '<table><tr><h4>For qualitative questions</h4></tr><tr><td style="width:30%"><select class="form-control" id="qualiDropdown"><option value="text" selected="selected">Text(single-line)</option><option value="textarea">Text(multi-line)</option></select></td></tr></table>'
    
    //display form template. (3)hasQuanti & hasQuali; (2) hasQuali; (1)hasQuanti
    var hasform = hasForm(s_a_type);
    if(hasform === 3) {
        $('#modal-dropdown-content').html(myQuantiDropdown+myQualiDropdown);
    } else if (hasform === 2) {
        $('#modal-dropdown-content').html(myQualiDropdown);
    } else if (hasform === 1) {
        $('#modal-dropdown-content').html(myQuantiDropdown);
    }
}

function modal_close() {
    $('[name="checkbox"]').hide();
}

function validate_forms() {
    if((checkbox_total && $('input[name="checkbox"]').not(':checked').length !== 0) || $('input[name="checkbox"]').not(':checked').length !== 0) { //if checkboxes [name='checkbox'] still exist or if there exists a checkbox that is not checked
        alert("To save layout, please provide answer fields to all questions or make sure that a checkbox before any question is not unchecked");
        return false;
    }
}

function click_debug() {
    //alert(s_question_ids.toString());
    //alert(a_type.toString());
    //alert('no debug');
    
    //alert(s_a_type.toString() + ' ; ' + s_question_ids.toString());
    //if(checkbox_total) {
    //    alert(true);
    //} else {
    //    alert(false);
    //}
    
    //for(var i = 0; i < s_qid_len; i++) {
    //    alert($('#formSelect'+s_question_ids[i]).val());
    //    alert($('#range'+s_question_ids[i]).val());
    //}
    
    //for(var z = 0; z < qid_atype_2da.length; z++) {
    //    console.log(qid_atype_2da[z].toString());
    //    alert(qid_atype_2da.length);
    //}
}