$(document).ready(function(){
    var par = new URLSearchParams(window.location.search);

    if(par == ''){
        loadAll();
    }
    if(par.has('authorInput')){
        searchByAuthor(par.get('authorInput'));
    }
    if(par.has('linkInput')){
        searchByCategory(par.get('linkInput'));
    }
    if(par.has('searchInput')){
        searchByInput(null, par.get('searchInput'));
    }
   $("#submit").click(searchByInput);
});

function loadAll(){
    var dataString = 'all=true';

    $.ajax({
        type: "POST",
        url: "search.php",
        data: dataString,
        cache: false,
        success: function(result){
            $("#result").html(result);
        }
    });
    return false;
}

function searchByAuthor(authorSearch){
    if(window.location.pathname.indexOf('product.php') != -1 || window.location.pathname.indexOf('contact.php') != -1){
        window.location.href = "index.php?authorInput=" + authorSearch;
    }

    var dataString = 'linkInput2=' + authorSearch;

    $.ajax({
        type: "POST",
        url: "search.php",
        data: dataString,
        cache: false,
        success: function(result){
            $("#result").html(result);
        }
    });
    return false;
}

function searchByCategory(categoryName){
    if(window.location.pathname.indexOf('product.php') != -1 || window.location.pathname.indexOf('contact.php') != -1){
        window.location.href = "index.php?linkInput=" + categoryName;
    }

    var dataString = 'linkInput1=' + categoryName;

    $.ajax({
        type: "POST",
        url: "search.php",
        data: dataString,
        cache: false,
        success: function(result){
            $("#result").html(result);
        }
    });
    return false;
}

function searchByInput(e=null, searchInput=null){ //the ajax call when a term is searched and search button is pressed.
    if(searchInput == null)
        searchInput = $("#searchInput").val();

    if(window.location.pathname.indexOf('product.php') != -1 || window.location.pathname.indexOf('contact.php') != -1){
        window.location.href = "index.php?searchInput=" + searchInput;
    }

    var dataString = 'searchInput1=' + searchInput;

    $.ajax({
        type: "POST",
        url: "search.php",
        data: dataString,
        cache: false, 
        success: function(result){
            $("#result").html(result);
            $('#searchForm')[0].reset();
        } 
    });
    return false;
}

setInterval(function(){
    $.ajax({
        type: "GET",
        url: "http://cosc499.ok.ubc.ca/currentTime.php",
        cache: false, 
        success: function(result){
            $("#time").html(result);
        } 
    });
}, 1000);