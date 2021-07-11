function openNav(){
    document.getElementById("MySidenav").style.width = "250px";
}

function closeNav(){
    document.getElementById("MySidenav").style.width = "0px";
}

function showDesc(id){
    var x = document.getElementById("descrizione"+id);
    if(x.style.display === ""){
        x.style.display = "block"; 
    }else{
        x.style.display = "";
    }
}

function search(){
    var input, filter, prodGrid, prod, h1, i, txtValue;
    input = document.getElementById('searchBar');
    filter = input.value.toUpperCase();
    prodGrid = document.getElementById('product-grid');
    prod = prodGrid.getElementsByClassName('product');

    for(i = 0; i<prod.length; i++){
        h1 = prod[i].getElementsByTagName('h1')[0];
        txtValue = h1.innerText;
        if(txtValue.toUpperCase().indexOf(filter) > -1) {
            prod[i].style.display = "";
        } else {
            prod[i].style.display = "none";
        }
    }
}

function addFav(id){
    var prefGrid, div, titolo, h1, img, btnimg;
    prefGrid = document.getElementById('prefProd');

    if(document.getElementById('h1F'+id)){
        var ogg = document.getElementById('h1F'+id);
    }

    if(ogg == undefined){
        div = document.createElement('div');
        div.className = 'product';
        div.id = 'prodottoF'+id;

            titolo = document.createElement('div');
            titolo.className = 'titolo';
                h1 = document.createElement('h1');
                h1.textContent = document.getElementById('h1'+id).textContent;
                h1.id = 'h1F'+id;
                titolo.appendChild(h1);

                btnimg = document.createElement('img');
                btnimg.id = 'iconF';
                btnimg.setAttribute('onclick', 'remFav('+id+')');
                btnimg.src = 'https://i.imgur.com/qQA5U21.png';
                titolo.appendChild(btnimg); 

            div.appendChild(titolo);

            img = document.createElement('img');
            img.id = 'imgFav';
            img.src = document.getElementById('img'+id).src;
            div.appendChild(img);

        prefGrid.appendChild(div);
    }
    if(document.getElementById('prefProd').childElementCount > 0){
        document.getElementById('favSection').style.display = 'initial';
    }
}

function remFav(id){
    var item = document.getElementById('prodottoF'+id);
    item.remove();

    if(document.getElementById('prefProd').childElementCount == 0){
        document.getElementById('favSection').style.display = 'none';
    }
}

function searchTable(){
    var input, filter, found, table, tr, td, i, j;
    input = document.getElementById("searchBar");
    filter = input.value.toUpperCase();
    table = document.getElementById("cartTable");
    tr = table.getElementsByTagName("tr");
    for(i = 0; i<tr.length; i++){
        td = tr[i].getElementsByTagName("td");
        for(j=0; j<td.length; j++){
            if(td[j].innerHTML.toUpperCase().indexOf(filter)>-1){
                found = true;
            }
        }
        if(found || tr[i].id =='tableHeader'){
            tr[i].style.display = '';
            found = false;
        }else{
            tr[i].style.display = 'none';
        }
    }
} 

function countDown(count){
    var timer = document.getElementById("timer");
    if(count>0){
        count--;
        timer.innerHTML = "Verrai reindirizzato alla home in "+count+" secondi";
        setTimeout("countDown("+count+")", 1000);
    }else{
        window.location.href = '../home';
    }
}
