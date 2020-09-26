
$(function (){
    //define variables
    let activeNote = 0;
    let editMode = false;

    //load notes on page load: Ajax call to loadNotes.php
    $.ajax({
        url: "loadNotes.php",
        success: data => {
            $("#notes").html(data);
            clickOnNotes();
            clickonDelete();
        },
        error: function (){
            $("#alertMessage").text("There was an error on ajax call, please try again later");
            $(".alert").fadeIn();
        }
    })

    //add a note: Ajax call to createNotes.php
    $("#addNote").on('click', function (){
        $.ajax({
            url: 'createNotes.php',
            success: data => {
                if (data == 'error'){
                    $("#alertMessage").text("There was an issue inserting the new note into Database");
                    $(".alert").fadeIn();
                }else{
                    //update active note to id of new note from data
                    activeNote = data;

                    //Delete textarea content
                    $("textarea").text("");

                    //we use CKEDITOR API to change text editor interface also get focus inside of text area
                    CKEDITOR.replace('textarea',{
                            on :
                                {
                                    instanceReady : function( ev )
                                    {
                                        this.focus();

                                    }
                                }
                        });

                    //show and hide elements
                    showHide(["#allnote", "#notePad"], ["#notes","#addNote", "#edit", "#done"]);


                }
            },
            error: function (){
                $("#alertMessage").text("There was an error on ajax call, please try again later");
                $(".alert").fadeIn();
            }
        })
    })


    //On type a note: Ajax call to updateNotes.php
    CKEDITOR.on('instanceCreated', function (e) {
        e.editor.on('key', function (event) {

            //getting data from textarea (CK Editor local function)
            let note = CKEDITOR.instances.textarea.getData();
            $.ajax({
                url: "updateNotes.php",
                type: "POST",
                //we need to send Current note with his id (activeNote) to updateNotes.php file
                data: {note: note, id: activeNote},
                success: data => {
                    if (data === 'error') {
                        $("#alertMessage").text("There is an Issue updating notes on database");
                        $(".alert").fadeIn();
                    }
                },

                error: function () {
                    $("#alertMessage").text("There was an error on ajax call, please try again later");
                    $(".alert").fadeIn();
                }
            })
        })
    });

    //buttons functionality
        //Click on all notes button
    $("#allnote").on('click', function (){

        //Deleting instance of 'textarea' on ckeditor to open it again with add note button
        CKEDITOR.instances['textarea'].destroy(true);

        $.ajax({
            url: "loadNotes.php",
            success: data => {
                $("#notes").html(data);
                clickOnNotes();
                clickonDelete();
                showHide(["#addNote","#edit","#notes"],["#allnote", "#done", "#notePad"])
            },
            error: function (){
                $("#alertMessage").text("There was an error on ajax call, please try again later");
                $(".alert").fadeIn();
            }
        })
    })

        //Click on done button after editing: Load notes again
        $("#done").on('click', function () {
            editMode = false;
            //show and hide elements
            showHide(["#addNote","#edit","#notes"],[".deleteBTN",".remindBTN",this]);
        })

        //Click on edit button: go to edit mode and (show delete button ....)
        $("#edit").on('click', function (){
            //switch to edit mode
            editMode = true;
            //show hide elements
            showHide(["#done",".deleteBTN",".remindBTN"],["#addNote", this]);
        })


    //Functions
        //Click on note!
        function clickOnNotes(){
            $(".noteDiv").on('click',function (){
                if (!editMode){
                    //update activeNote variable to id of Note
                    activeNote = $(this).attr("id");
                    // fill text area
                    let value = $(this).find('.noteText').text()

                    CKEDITOR.replace('textarea',{
                        on :
                            {
                                instanceReady : function( ev )
                                {
                                    this.focus();

                                }
                            }
                    });


                    CKEDITOR.instances['textarea'].setData(value);

                    //show and hide elements
                    showHide(["#allnote", "#notePad"], ["#notes","#addNote", "#edit", "#done"]);
                }
            })
        }
        //Click on delete button
        function clickonDelete(){
            $(".deleteBTN").on('click', function (){
                //get id of Note that we want to delete
                let id = $(this).next().attr('id');
                $.ajax({
                    url: "deleteNotes.php",
                    type: "POST",
                    //we send id to delete element
                    data: {id:id},
                    success: data => {
                        if (data === 'error') {
                            $("#alertMessage").text("There is an Issue Deleting note on database");
                            $(".alert").fadeIn();
                        }else{
                            //Remove Note container Html from Page
                            $(this).parent().remove();
                        }
                    },

                    error: function () {
                        $("#alertMessage").text("There was an error on ajax call, please try again later");
                        $(".alert").fadeIn();
                    }
                })
            })
        }

        //Click on remind


    function showHide(array1, array2){
        array1.forEach(element => $(element).show());
        array2.forEach(element => $(element).hide());
    }


})