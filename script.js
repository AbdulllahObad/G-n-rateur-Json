function ajouterAttribut(nombre_attribut,element){

    nombre_attribut++;
    $(element).prepend("<div><input type='text' placeholder='attribut n°"+nombre_attribut+"' name='attribut[]'></div>");

    return nombre_attribut;

}

$(document).ready(function(){

    nombre_attribut=0;

    $(".but").click(function(){
        alert("jul");
        $("#gris").css("visibility","visible");
        $(".div_attribut").css("visibility","visible");

    });
    $("#gris").click(function(){

        $("#gris").css("visibility","hidden");
        $(".div_attribut").css("visibility","hidden");
        $(".attributperso").css("visibility","hidden");

    });
    $(".ajouter").click(function(){

        nombre_attribut=ajouterAttribut(nombre_attribut,".form_attribut");

    });
    $.getJSON("temp_fichier.json",function(data){

        $(".personnage").click(function(){
            alert('jul');
            $(".attributperso").empty();
            $("#gris").css("visibility","visible");
            $(".attributperso").css("visibility","visible");
            let id_perso = parseInt($(this).attr('id'));
            let perso = data['possibilites'][id_perso];
            let form = $("<form method='post'></form>");
            for (const [key, value] of Object.entries(perso)) {
                let input;
                if(key=='fichier'){

                    input = $("<div><label for='"+key+"'>'"+key+"' :</label><input type='file' id='"+key+"'name='"+key+"' data-default-file="+value+"></div>");

                }else{

                    input = $("<div><label for='"+key+"'>'"+key+"' :</label><input type='text' id='"+key+"'name='"+key+"' value="+value+"></div>");

                }
                console.log(perso);
                form.append(input);
              }
              form.append($("<input type='hidden' name='id' value='"+id_perso+"'>"))
              form.append($("<input type='submit' name='modif_attribut'>"));
              $(".attributperso").append(form);
    
        });
    

    });

});