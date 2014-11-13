var activeLanguages = {};
wpbs(document).ready(function(){
    wpbs("#receive_emails").change(function(){
        if(wpbs(this).val() == 'yes'){
            wpbs("#send_to_emails").slideToggle();
        } else {
            wpbs("#send_to_emails").slideToggle();
        }
    })

    wpbs("#add-field").click(function(e){
        e.preventDefault();
        wpbs(".wpbs-form-field.open").removeClass('open').find('.wpbs-field-options').hide();        
        wpbs_form_addNewField();
    })
    
    wpbs("#wpbs-form-container").on('click','.wpbs-form-delete',function(e){
        e.preventDefault()
        confirmation = confirm("Are you sure you want to delete this field?");
        if(confirmation){
            wpbs_delete_field(wpbs(this).parent().attr('data-order'));    
        }
               
    })
    
    wpbs("#wpbs-form-container").on('mousedown click','.wpbs-form-move',function(e){
        e.preventDefault();

        if(wpbs(this).parent().hasClass('open')){
            wpbs(this).parent().toggleClass('open');
            wpbs(this).parent().find('.wpbs-field-options').hide();  
        }

    })
    
    wpbs("#wpbs-form-container").on('click','span.wpbs-field-name, span.wpbs-field-type',function(e){
        e.preventDefault();
        wpbs(".wpbs-form-field.open .wpbs-field-options").slideToggle();  
        if(wpbs(this).parent().hasClass('open')){
            wpbs(".wpbs-form-field.open").removeClass("open");
        } else {
            wpbs(".wpbs-form-field.open").removeClass("open");
            wpbs(this).parent().addClass('open');
            wpbs(this).parent().find('.wpbs-field-options').slideToggle();    
        }
          
    })
    
    wpbs("#wpbs-form-container").on('change','.fieldType',function(e){
        e.preventDefault();
        if(wpbs(this).val() == 'dropdown' || wpbs(this).val() == 'radio' || wpbs(this).val() == 'checkbox'){
            wpbs(this).parent().parent().find(".fieldOptionsContainer").show();
        } else {
            wpbs(this).parent().parent().find(".fieldOptionsContainer").hide();
        }        
        wpbs(this).parent().parent().parent().find('span.wpbs-field-type').html(wpbs(this).find('option:selected').text());
        
        formJson = wpbs_form_getJson();
        fieldId = wpbs(this).parent().parent().parent().attr('data-order');
        formJson[fieldId]['fieldType'] = wpbs(this).val();
        wpbs_form_saveJson(formJson);
    })
    
    wpbs("#wpbs-form-container").on('keyup change','.fieldName',function(e){
        e.preventDefault();
        $val = wpbs(this).val();
        if($val == "") $val = "&nbsp;";        
        wpbs(this).parent().parent().parent().find('span.wpbs-field-name').html($val);        
        formJson = wpbs_form_getJson();
        fieldId = wpbs(this).parent().parent().parent().attr('data-order');
        formJson[fieldId]['fieldName'] = wpbs_htmlEscape(wpbs(this).val());
        wpbs_form_saveJson(formJson);
    })
    
    wpbs("#wpbs-form-container").on('keyup change','.fieldOptions',function(e){
        e.preventDefault();   
        formJson = wpbs_form_getJson();
        fieldId = wpbs(this).parent().parent().parent().attr('data-order');
        formJson[fieldId]['fieldOptions'] = wpbs_htmlEscape(wpbs(this).val());
        wpbs_form_saveJson(formJson);
    })
    
    wpbs("#wpbs-form-container").on('keyup change','.languageField',function(e){
        e.preventDefault();
   
        formJson = wpbs_form_getJson();
        fieldId = wpbs(this).parent().parent().parent().attr('data-order');
        formJson[fieldId]['fieldLanguages'][wpbs(this).attr('name')] = wpbs_htmlEscape(wpbs(this).val());
        wpbs_form_saveJson(formJson);
    })
    
    wpbs("#wpbs-form-container").on('change','.fieldRequired',function(e){
        e.preventDefault();
        $val = wpbs(this).prop('checked');        
        formJson = wpbs_form_getJson();
        fieldId = wpbs(this).parent().parent().parent().attr('data-order');
        formJson[fieldId]['fieldRequired'] = $val;
        wpbs_form_saveJson(formJson);
    })
    
    
    
    
    wpbs("#wpbs-form-container").sortable({
        axis: 'y',
        handle: '.wpbs-form-move',
        containment: "parent",
        stop: function(e, ui) {
            sorting = new Array();
            wpbs.map(wpbs(this).find('div.wpbs-form-field'), function(el) {    
                 sorting[wpbs(el).attr('data-order')] = (wpbs(el).index() + 1);
            });
            wpbs_sort_forms(sorting);
        }
    });
})    

function wpbs_delete_field(dataId){
    formJson = wpbs_form_getJson();   
        
        wpbs('.wpbs-form-field').each(function(){
            fieldId = wpbs(this).attr('data-order');
            if(fieldId == dataId){
                wpbs(this).remove();
                delete(formJson[dataId]);
            }
            if(fieldId > dataId){
                formJson[wpbs(this).attr('data-order')-1] = formJson[wpbs(this).attr('data-order')];
                delete(formJson[wpbs(this).attr('data-order')]);
                wpbs(this).attr('data-order',wpbs(this).attr('data-order')-1);
                
            }
        })       
    
    wpbs_form_saveJson(formJson);
}


function wpbs_sort_forms(sortOrder){
    tempFormJson = {};
    currFormJson = wpbs_form_getJson();    
    for (var j in sortOrder){
        tempFormJson[sortOrder[j]] = currFormJson[j];
    }
    wpbs_form_saveJson(tempFormJson);
    x = 1;
    wpbs('.wpbs-form-field').each(function(){
        wpbs(this).attr('data-order',x);
        x++;
    })   
}




function wpbs_form_addNewField(){
    var field = '';
    i = (wpbs(".wpbs-form-field").length + 1);
    
    fieldId = 0; 
    wpbs('.wpbs-form-field').each(function(){
        if( parseInt(fieldId) < parseInt(wpbs(this).attr('id').replace('wpbs-form-field-','')))
            fieldId = parseInt(wpbs(this).attr('id').replace('wpbs-form-field-',''));            
    })   
    fieldId++;
    
    
    field += '<div class="wpbs-form-field wpbs-form-field-'+ fieldId +'" data-order="'+ i +'" id="wpbs-form-field-'+ fieldId +'">';
    field +=    '<a href="#" class="wpbs-form-move" title="Move"><!-- --></a>';
    field +=    '<a href="#" class="wpbs-form-delete" title="Delete"><!-- --></a>';    
    field +=    '<span class="wpbs-field-name">New Field</span><span class="wpbs-field-type">Text</span>';    
    field +=    '<div class="wpbs-field-options" style="display:none;">';
    field +=        '<p><label>Title</label><input type="text" name="fieldName" class="fieldName"></p>';
    field +=        '<p><label>Type</label><select class="fieldType" name="fieldType"><option value="text">Text</option><option value="email">Email</option><option value="textarea">Textarea</option><option value="checkbox">Checkboxes</option><option value="radio">Radio Buttons</option><option value="dropdown">Dropdown</option></select></p>';
    field +=        '<p style="display:none;" class="fieldOptionsContainer"><label>Options</label><input type="text" name="fieldOptions" class="fieldOptions"><small><em>Separate values with an | (eg. Option 1|Option 2|Option 3)</em></small></p>';
    field +=        '<p><label>Required</label><input type="checkbox" name="fieldRequired" class="fieldRequired"></p>';
    field +=        '<div class="wpbs-form-line"><!-- --></div>';
    for (var j in activeLanguages) {
    field +=        '<p><label>'+activeLanguages[j]+'</label><input type="text" name="'+j+'" class="languageField languageField-'+j+'"></p>';
    }
    field +=    '</div>';
    field += '</div>';
    wpbs("#wpbs-form-container").append(field);
    
    formJson = wpbs_form_getJson();
        formJson[i] = {};
        formJson[i]['fieldId'] = fieldId;
        formJson[i]['fieldName'] = '';
        formJson[i]['fieldType'] = 'text';
        formJson[i]['fieldOptions'] = ''; 
        formJson[i]['fieldRequired'] = 'false'; 
        formJson[i]['fieldLanguages'] = {};
        for (var j in activeLanguages) {
            formJson[i]['fieldLanguages'][j] = '';
        }
    wpbs_form_saveJson(formJson);  
    
    wpbs('#wpbs-form-field-'+ fieldId +' .wpbs-field-name').click();
}


function wpbs_form_getJson(){
    return JSON.parse(wpbs("#wpbs-form-json").val());
}

function wpbs_form_saveJson(obj){
    // DEBUG //wpbs("#json").html(JSON.stringify(obj)) 
    wpbs("#wpbs-form-json").val(JSON.stringify(obj));
}
