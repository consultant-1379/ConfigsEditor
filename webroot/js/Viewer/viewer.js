var prev_viewer_data="";
var prev_data_was_full_log="no";
var stop_button;
var stopping="no";
var in_populate_viewer="no";
var $dialog = '';
var dialogShown = 'no';

$(document).ready(function() 
{
    $('#buttonDiv').find("button").button();
    $('#buttonDiv').find("button").button("option","disabled", true);
    stop_button=$( "#stop_button" );
    download_button=$("#download_button");
    
    $('#download_button').click(function()
    {
         window.open("/ViewerFiles/zip_folders.php?fileDir=" +  encodeURIComponent($('#selected_file').html()));
         $('#log_contents').empty();
    });

    $('#dateSelector').val('14400');
    populate_trees();
    setInterval(populate_trees,10000);
    
    $('#dateSelector').on('change', function()
    { 
        populate_trees();     
    });
    
    $dialog = $('<div id="logDialog"></div>').html('This file is very big would you like to:');

         $dialog.dialog(
                {
                    autoOpen: false,
                    closeOnEscape: false,
                    modal: true,
                    show: "blind",
                    buttons:
                    {
                        Show_Log_Tail: function()
                        {
                            $.ajax({
                                url: "/ViewerFiles/getlogtail.php?log=" + $('#selected_file').html() + "&tail=true",
                                cache: false,
                                success: function(data) 
                                {
                                    set_viewer_text(data);
                                }
                            });
                            $dialog.dialog("close");
                        },
                        Show_Full_Log: function()
                        {
                            $.ajax({
                                url: "/ViewerFiles/getlogtail.php?log=" + $('#selected_file').html() + "&tail=false",
                                cache: false,
                                success: function(data) 
                                {
                                    set_viewer_text(data);
                                }
                            });
                            alert('This file is very big so there could be some load time.')
                            $dialog.dialog("close");
                        },
                        Download_File: function()
                        {
                            window.open("/ViewerFiles/zip_folders.php?fileDir=" +  encodeURIComponent($('#selected_file').html()));
                            $('#log_contents').empty();
                            $dialog.dialog("close");
                        }
                    },
                    hide: "explode",
                    resizable: true,
                    minWidth: 500,
                    maxWidth: 800,
                    width: 400,
                    height: 150,
                    open: function()
                    {
                        $(".ui-dialog-titlebar-close").hide();
                        $(".ui-dialog-buttonpane button:contains('Show_Log_Tail') span").text("Show Log Tail");
                        $(".ui-dialog-buttonpane button:contains('Show_Full_Log') span").text("Show Full Log");
                        $(".ui-dialog-buttonpane button:contains('Download_File') span").text("Download File");
                        dialogShown = "yes";
                    }
                
                })
    //populate_files();
    //setInterval(populate_files,10000);
    // Refresh button needed
    //populate_viewer(2);
    setInterval("populate_viewer('timer')",1000);

    //populate_viewer('timer');
   
    populate_stop_button();
    
});

function stop_install(server,pid)
{
    stopping="yes";
    stop_button.button("option","disabled", true);
    stop_button.button("option","label", "Stopping..");
    //alert("OK, stopping pid " + pid + " on " + server);

    $.ajax({
        url:"/ViewerFiles/kill_pid.php?server=" + server + "&pid=" + pid,
        cache: false,
        complete: function(data){
            populate_viewer();
            stop_button.button("option","disabled", false);
            stop_button.button("option","label", "Stop");
            stopping="no";
        },
        error: function(xhr, status)
        {
            alert('Error' + ' ' + xhr + ' ' + status);
        }
    });
}
function populate_stop_button ()
{
    if (stopping=="yes")
    {
        setTimeout("populate_stop_button()",1000);
        return;
    }
    var rootdir=$('#selected_dir').html();
    //alert(rootdir);
    if (rootdir=="")
    {
        setTimeout("populate_stop_button()",1000);
    }
    else
    {          
        //alert(rootdir);
        $.ajax({
            url:"/ViewerFiles/getrunningpid.php?dir=" + rootdir,
            cache: false,
            success: function(data){
                var datasplit=data.split(" ");
                var server=datasplit[0];
                var pid=datasplit[1];
                if (server!= "" && pid !="")
                {
                    stop_button.button("option","disabled", false);
                    
                    stop_button.unbind('click');
                    stop_button.click(function() {
                        stop_install(server,pid);
                    });
                    
                }
                else
                {
                    stop_button.button("option","disabled", true);
                }
                setTimeout("populate_stop_button()",1000);
            }
        });
    } 
}

function populate_trees ()
{ 
    $('#running_log_file_tree').fileTree({
        root: '/export/scripts/CLOUD/logs/web/',
        pdir: directory,
        script: '/ViewerFiles/list_log_dirs.php?type=running',
        expandSpeed: 0,
        collapseSpeed: 0,
        multiFolder: false
    }, function(file) {
        //alert(file);
        download_button.button("option","disabled", true);
        }, function(dire) {
            //alert(dire);
            download_button.button("option","disabled", true);
            clicked_log_dir(dire);
            
        });
    //alert(JSON.stringify(directory));
    $('#completed_log_file_tree').fileTree({
        root: '/export/scripts/CLOUD/logs/web/',
        pdir: directory,
        script: '/ViewerFiles/list_log_dirs.php?type=completed&date=' + $('#dateSelector').val(),
        expandSpeed: 0,
        collapseSpeed: 0,
        multiFolder: false
        }, 
        function(file){download_button.button("option","disabled", true);},
        function(dire) 
        {
            download_button.button("option","disabled", true);
            clicked_log_dir(dire);
        });
        
//setTimeout(populate_trees(),10000);
}
    
    
function clicked_log_dir(dire)
{
    reset_viewer();
    $('#selected_dir').html(dire);
    var finalPath = dire.split('logs/web/');    
    var arrLength = finalPath.length;      
    var dirname = finalPath[arrLength - 1];    
    dirnamesplit = dirname.split("/");
    dirname = dirnamesplit[0];
    $('#selected_dir_info').html("<h3>Logs for " + dirnamesplit[0] +"-->" +dirnamesplit[1] + "</h3>");
    populate_files();
    populate_stop_button();
}

function populate_files()
{
    var rootdir=$('#selected_dir').html();
    if (rootdir!="")
    {
        $('#sub_tree').fileTree({
            root: rootdir,
            script: '/ViewerFiles/list_log_dir_contents.php',
            expandSpeed: 0,
            collapseSpeed: 0,
            multiFolder: true
        }, function(file) 
        {
            download_button.button("option","disabled", false);
            if(file != $('#selected_file').html())
                {
                    in_populate_viewer="no";
                    dialogShown = "no";
                    $('#selected_file').html(file);
                    var finalPath = file.split('/');
                    var filename = finalPath[finalPath.length - 1];

                    $('#selected_file_info').html("<h3>Viewing log " + filename + "</h3>");
                    set_viewer_text("Loading....");
                    populate_viewer();
                }

       
        }, function(dire)
        {
            download_button.button("option","disabled", true);
        });
        
            
    }
}
function reset_viewer()
{
    $('#selected_file').html("");
    populate_viewer();
    $('#selected_file_info').html("");
      
}

function populate_viewer(timer)
{
    if (in_populate_viewer=="yes")
    {
        //console.log ("Already in here, exiting");
        //in_populate_viewer="no";
        return;
    }
    in_populate_viewer="yes";
    //console.log("Populating viewer");
    var file=$('#selected_file').html();
    
    if (file!="")
    {        
        if (timer==='timer' && prev_data_was_full_log=="yes")
        {
        //console.log("Not getting again as full log");
        }
        else
        {  
            $.ajax({
                url:"/ViewerFiles/getlogtail.php?log=" + file + "&tail=false",
                cache: false,
                success: function(data)
                {
                    if(data.split('\n').length > 500)
                        {
                            if(dialogShown == 'no')
                                {
                                    $dialog.dialog("open");
                                }
                        }
                    else
                        {
                            set_viewer_text(data);
                        }
                    in_populate_viewer="no";
                }
            });
            return;
        }
    }
    else
    {
        set_viewer_text("");
    }
    
    in_populate_viewer="no";
}

function set_viewer_text(data)
{
    var log_contents_div = $('#log_contents');
    if (data!=prev_viewer_data)
    {
        if (data.indexOf("FULLLOG") != -1)
        {
            prev_data_was_full_log="yes";
            data = data.replace("FULLLOG","");
        }
        else
        {
            prev_data_was_full_log="no";
        }
        prev_viewer_data=data;
        if (data=="")
        {
            log_contents_div.empty();
        }
        else 
        {
            log_contents_div.html(data);
            log_contents_div.scrollTop(log_contents_div[0].scrollHeight);
        }
        
    }
    
}
