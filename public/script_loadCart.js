document.addEventListener('DOMContentLoaded', function(){
    fetch('cart/data').then(onResponse).then(creaTabella);
}, false);

function onResponse(response){
    console.log(response);
    return response.json();
}

function creaTabella(json){
    let tabArea = document.getElementById('tabArea');
    console.log(json);
    if(json.length > 0){
        let totale = 0;
        let cartTable = document.createElement('table');
        cartTable.id = 'cartTable';

        let tr1 = document.createElement('tr');
            let thN = document.createElement('th');
            thN.innerText = 'Nome Prodotto';
            tr1.appendChild(thN);
            let thQ = document.createElement('th');
            thQ.innerText = 'Quantità';
            tr1.appendChild(thQ);
            let thT = document.createElement('th');
            thT.innerText = 'Costo totale';
            tr1.appendChild(thT);
        cartTable.appendChild(tr1);

        for(let i = 0; i<json.length; i++){
            let trP = document.createElement('tr');
                let tdN = document.createElement('td');
                tdN.innerText = json[i][5];
                trP.appendChild(tdN);
                let tdQ = document.createElement('td');
                tdQ.innerText = json[i][2];
                trP.appendChild(tdQ);
                let tdT = document.createElement('td');
                tdT.innerText = json[i][4]*json[i][2];
                trP.appendChild(tdT);
                totale = totale + (json[i][4] * json[i][2]);
                let tdF = document.createElement('td');
                    let formRem = document.createElement('form');
                    formRem.method = 'post';
                    formRem.action = 'cart/remCart';
                    
                        let hdnToken = document.createElement('input');
                        hdnToken.type = 'hidden';
                        hdnToken.name = '_token';
                        hdnToken.value = document.getElementById('tkn').content;
                        formRem.appendChild(hdnToken);

                        let input = document.createElement('input');
                        input.type = 'submit'
                        input.id = 'btnOrder'
                        input.className = 'btn';
                        input.name = 'remCart';
                        input.value = 'Rimuovi';
                        formRem.appendChild(input);

                        let inputs = document.createElement('input');
                        inputs.type = 'hidden';
                        inputs.name = 'itemName';
                        inputs.value = i;
                        formRem.appendChild(inputs);
                    tdF.appendChild(formRem);
                trP.appendChild(tdF);
            cartTable.appendChild(trP);
        }
        tabArea.appendChild(cartTable);

        let h1 = document.createElement('h1');
        h1.textContent = 'Totale: '+totale+' €';
        tabArea.appendChild(h1);

        let formOrd = document.createElement('form');
        formOrd.method = 'post';
        formOrd.action = 'cart/pagaOrd';

            let inputo = document.createElement('input');
            inputo.type = 'submit';
            inputo.id = 'btnOrder';
            inputo.className = 'btn';
            inputo.name = 'paga';
            inputo.value = 'Paga adesso';
            formOrd.appendChild(inputo);

            let hdnToken = document.createElement('input');
            hdnToken.type = 'hidden';
            hdnToken.name = '_token';
            hdnToken.value = document.getElementById('tkn').content;
            formOrd.appendChild(hdnToken);

        tabArea.appendChild(formOrd);
    }else{
        let p = document.createElement('p');
        p.className = 'error';
        p.innerText = 'Il tuo carrello è vuoto';
        tabArea.appendChild(p);
    }
}