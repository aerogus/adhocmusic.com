function change_planche(value){
    //alert(value);
    $.ajax({type:"POST",
            url:"gen_planche.php",
            data: document.getElementById(\"name\").value,
            xosuccess: function(data){
                document.getElementById("change").innerHTML = data;
            },
            error: function(xhr, textStatus, error){
                console.log(xhr.statusText);
                console.log(textStatus);
                console.log(error);
            }
           });
    return (false);
}

function toto(value)
{
    alert(value);
}