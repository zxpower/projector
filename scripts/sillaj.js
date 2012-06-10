// Dynamic change of the task list based on the project selected
function frmEvent_intProjectId_onchange(s) {
    var xmlhttp=false;
    
    /*@cc_on @*/
    /*@if (@_jscript_version >= 5)
    // JScript gives us Conditional compilation, we can cope with old IE versions.
    // and security blocked creation of the objects.
    try {
        xmlhttp = new ActiveXObject('Msxml2.XMLHTTP');
    }
    catch(e) {
        try {
            xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
        } 
        catch(E) {
            xmlhttp = false;
        }
    }
    @end @*/    
    
    if (!xmlhttp && typeof XMLHttpRequest != 'undefined') {
        xmlhttp = new XMLHttpRequest();
    }

    var element = document.getElementById('intTaskId');

    xmlhttp.open('GET', 'getTask_xmlhttp.php?intProjectId=' + s.options[s.selectedIndex].value);
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {  
            eval(xmlhttp.responseText);
            element.options.length = 0;
            for (i=0;i<arrXmlhttp.length;i++) {
                o = new Option(arrXmlhttp[i][1], arrXmlhttp[i][0]);
                element.options[element.options.length] = o;
            }
        }
    }
    xmlhttp.send(null);    
}

// Check event input before submitting
function frmEvent_onsubmit(f) {

    // check project
    if (f.intProjectId.selectedIndex == '0') {
        f.intProjectId.focus();
        alert(noProjectSelected);
        return false;
    }  
    
    // check task
    if (f.intTaskId[f.intTaskId.selectedIndex].value == '0') {
        f.intTaskId.focus();
        alert(noTaskSelected);
        return false;
    }  
    
    // clean time input
    var d = trim(f.timDuration.value);
    var s = trim(f.timStart.value);
    var e = trim(f.timEnd.value);
    
    // check time
    if (    
        ((d == '') && (s == '') && (e == ''))
        || ((s == '') && (e != ''))
        || ((s != '') && (e == ''))                 
       ) {
        f.timDuration.focus();
        alert(noTimeInput);
        return false;
    }   
    
    // if a start time input is h:mm and end time is hh:mm, it will trigger an 
    // error (because of string comparison)
    // so we add a 0 before single digit hours
    var splitStr = /[-:,; ]/g;
    var stmp = s.split(splitStr);
    if (stmp[0].length == 1) {
        s = '0' + s;
        //f.timStart.value = s;
    }

    var stmp = e.split(splitStr);
    if (stmp[0].length == 1) {
        e = '0' + e;
        //f.timEnd.value = e;
    }

    // check if start time is before end time
    // except if we have +d in the end date (it means it's the next day)
    if ((d == '') && (e < s) && (e.indexOf('+d') == -1)) {
        f.timStart.focus();
        alert(e +' < '+ s +' : '+ badTimeInterval);
        f.timEnd.focus();
        return false;
    }
}

// Check if an event is selected before submitting for deleting or editing
function frmEvents_onsubmit(f) {
    var intEventId;  
    if (f.intEventId.length == undefined)  { // only one event in the form
        var booChecked = f.intEventId.checked
        intEventId = f.intEventId.id;
    }
    else {                                   // several events in the form
        var booChecked = false;
        for (i=0;i<f.intEventId.length;i++){
            if (f.intEventId[i].checked) {
                booChecked = true;
                intEventId = f.intEventId[i].id;
                break;
            }
        }
    }
      
    if (!booChecked) {
        // rollback button innerHTML and un-disable the buttons (see assignSubmitButton()) 
        document.getElementById('inpEdit').value = strIniEdit;
        document.getElementById('inpDelete').value = strIniDelete;
        document.getElementById('inpEdit').disabled = false;
        document.getElementById('inpDelete').disabled = false;
        
        alert(noEventSelected);
        return false;
    }
    
    // Confirm delete. Get the full name of the project and task of the radio
    if (f.submitButton == 'inpDelete') {
        eventName = document.getElementById(intEventId.replace('event','project')).innerHTML;
        if (document.getElementById(intEventId.replace('event','task'))) {
            eventName += ' / ' + document.getElementById(intEventId.replace('event','task')).innerHTML;
        }
        
        if (confirm(confirmDeleteEvent +'\n'+ eventName)) {
            return true;
        }
        else {
            // rollback button innerHTML and un-disable the buttons (see assignSubmitButton()) 
            document.getElementById('inpEdit').value = strIniEdit;
            document.getElementById('inpDelete').value = strIniDelete;
            document.getElementById('inpEdit').disabled = false;
            document.getElementById('inpDelete').disabled = false;   
            return false;
        }	               
    }
}

// Pass the name of the input button that is submitting the form - cf. above
// workaround for IE which submits the innerHTML value and submits all buttons (not just the successful one)
function assignSubmitButton(b) {
    if (!b) {
       //alert('no object found'); 
       return; 
    }
    if (!b.type) { 
       //alert('no type attribute'); 
       return; 
    }
    if (b.type != 'submit') {
        //alert('no submit button'); 
        return; 
    }
    if (!b.form) {
        //alert('parentless button (no form)');
        return; 
    }
    
    var formElements = b.form.elements;
    for (var i=0;i<formElements.length;i++) {
        //leave the pressed button as is...
        if (formElements[i] == b) {
            continue;
        }
        
        //disable all other submit buttons
        if(formElements[i].type == 'submit') {
            formElements[i].disabled = true;
        }
    }
    b.form.submitButton = b.name;
    return true;
}
				

// Project
function frmProject_onsubmit(f) {
    p = trim(f.strProject.value);
    if (p == '') {
        f.strProject.focus();
        alert(noProjectName);
        return false;
    }  
}

function frmDeleteProject_onsubmit() {
    return confirm(confirmDeleteProject +'\n'+ document.getElementById('strProject').value);	   
}

// Task
function frmTask_onsubmit(f) {
    t = trim(f.strTask.value);
    if (t == '') {
        f.strTask.focus();
        alert(noTaskName);
        return false;
    }  
}

function frmDeleteTask_onsubmit() {
    return confirm(confirmDeleteTask +'\n'+ document.getElementById('strTask').value);	   
}

// Login
function frmLogin_onsubmit(f) {
    u = trim(f.strUserId.value);
    p = trim(f.strPassword.value);
    
    if (u == '') {
        f.strUserId.focus();
        alert(noLogin);
        return false;
    }  
    if (p == '') {
        f.strPassword.focus();
        alert(noPassword);
        return false;
    }
    
    // Avoid to send the pasword in clear text : encrypt with MD5 and clear the password field
    f.strResponse.value = MD5(MD5(p) + f.strNonce.value + u);
    f.strPassword.value = '';
    f.strNonce.value = '';
}

// User
function frmUser_onsubmit(f, booEdit) {
    u = trim(f.strUserId.value);
    p = trim(f.strPassword.value);
    m = trim(f.strEmail.value);
    
    if (u == '') {
        f.strUserId.focus();
        alert(noLogin);
        return false;
    }  
    if (!booEdit) {
        if (p == '') {
            f.strPassword.focus();
            alert(noPassword);
            return false;
        } 
    }
    if (m == '') {
        f.strEmail.focus();
        alert(noEmail);
        return false;
    }  
    
    // Check email (pattern from http://regexlib.com/RETester.aspx?regexp_id=608)
    var strPattern = /^((?:(?:(?:[a-zA-Z0-9][\.\-\+_]?)*)[a-zA-Z0-9])+)\@((?:(?:(?:[a-zA-Z0-9][\.\-_]?){0,62})[a-zA-Z0-9])+)\.([a-zA-Z0-9]{2,6})$/
    if (strPattern.exec(m) == null) {
        f.strEmail.focus();
        alert(badEmail);
        return false;
    }
}

// mail
function frmMail_onsubmit(f) {
    m = trim(f.strEmail.value);
    
    if (m == '') {
        f.strEmail.focus();
        alert(noEmail);
        return false;
    }  
}

// Project
function frmSearch_onsubmit(f) {
    k = trim(f.strKeyword.value);
    if (k == '') {
        f.strKeyword.focus();
        alert(noKeyword);
        return false;
    }  
}


// Report
function frmReport_onsubmit(f) {
    datStart = trim(f.datStart.value);
    datEnd = trim(f.datEnd.value);

    if (datStart == '') {
        f.datStart.focus();
        alert(noDatStart);
        return false;
    }  
    if (datEnd == '') {
        f.datEnd.focus();
        alert(noDatEnd);
        return false;
    }  
}

// update date fields in report form
function frmReport_updateDates(datStart, datEnd) {
    document.getElementById('datStart').value = datStart;
    document.getElementById('datEnd').value = datEnd;
}

/* toggle visibility of details in reports */
function report_toggleDetail(obj) { 
    detail = getElementsByClass('detail');      
     
    for(i=0;i<=detail.length-1;i++) {
        if (obj.checked) {
            // bad kludge for identifying IE
            detail[i].style.display = (navigator.appVersion.indexOf('MSIE') != -1) ? 'inline' : 'table-row';
        }
        else { 
            detail[i].style.display = 'none';
        }    
    }
}

/* Return all elements of class strClass 
used in report_toggleDetail() to find all detail elements
*/    
function getElementsByClass(strClass) {  
    var arrOut = new Array();
    var arrTmp = new Array();
    arrTmp = document.getElementsByTagName('*');
    var j=0;
    for (i=0; i<arrTmp.length; i++) {
        if (arrTmp[i].className == strClass) {  
            arrOut[j]=arrTmp[i];
            j++;
        }  
    }    
    return arrOut;
} 

// gantt.tpl
// autosubmit the form
function frmGanttNav_intSpan_onchange(obj) {
    obj.form.submit();
}

/* functions used in index.tpl and other forms
==============================================================================*/

function trim(chaine){
    if (chaine.length < 1) {
        return '';
    }
    chaine = rtrim(chaine);
    chaine = ltrim(chaine);
    if (chaine == '') {
        return '';
    }
    else {
        return chaine;
    }
}

function rtrim(chaine) {
    var w_space = String.fromCharCode(32);
    var v_length = chaine.length;
    var strTemp = '';
    if (v_length < 0) {
        return '';
    }
    var iTemp = v_length - 1;
    
    while(iTemp > -1) {
        if (chaine.charAt(iTemp) != w_space) {       
            strTemp = chaine.substring(0, iTemp + 1);
            break;
        }
    iTemp = iTemp - 1;    
    }
        
    return strTemp;
}

function ltrim(chaine){
    var w_space = String.fromCharCode(32);
    
    if (v_length < 1) {
        return '';
    }
    
    var v_length = chaine.length;
    var strTemp = '';    
    var iTemp = 0;
    
    while(iTemp < v_length) {
        if (chaine.charAt(iTemp) != w_space) {
            strTemp = chaine.substring(iTemp, v_length);
            break;
        }
        iTemp = iTemp + 1;
    }
    
    return strTemp;
}
