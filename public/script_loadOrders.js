document.addEventListener('DOMContentLoaded', function(){
    fetch('profile/getOrder').then(onResponse).then(creaTabellaOrd);
}, false);

function onResponse(response){
    console.log(response);
    return response.json();
}

function creaTabellaOrd(json){
    let tabArea = document.getElementById('cartTable');
    let idcli = document.getElementById('idcli');

    for(let i = 0; i<json.length; i++){
        let row = document.createElement('tr');
            let tdi = document.createElement('td');
            tdi.innerText = json[i].IDordine;
            row.appendChild(tdi);

            let tdn = document.createElement('td');
            tdn.innerText = json[i].nomeProdotto;
            row.appendChild(tdn);

            let tdq = document.createElement('td');
            tdq.innerText = json[i].quantitaRichiesta;
            row.appendChild(tdq);

            let tdd = document.createElement('td');
            tdd.innerText = json[i].dataOrdine;
            row.appendChild(tdd);

            let tdc = document.createElement('td');
            tdc.innerText = json[i].costoTot;
            row.appendChild(tdc);

            let tdp = document.createElement('td');
                let imgp = document.createElement('img');
                imgp.id = 'icon';
                if(json[i].pagato == 1){
                    imgp.src = 'https://i.imgur.com/agJPs4q.png';
                }else{
                    imgp.src = 'https://i.imgur.com/vtMUSVX.png';
                }
            tdp.appendChild(imgp);
            row.appendChild(tdp);

            if(idcli !=null){
                tdcli= document.createElement('td');
                tdcli.innerText = json[i].IDcliente;
                row.appendChild(tdcli);

                if(json[i].pagato==0){
                    let tdf = document.createElement('td');
                        let form = document.createElement('form');
                        form.id = 'formCart';
                        form.method = 'post';
                            let inputs = document.createElement('input');
                            inputs.type = 'submit';
                            inputs.id = 'btnOrder';
                            inputs.className = 'btn';
                            inputs.name = 'confPag';
                            inputs.value = 'Conferma pagamento';
                            form.appendChild(inputs);

                            let inputo = document.createElement('input');
                            inputo.type = 'hidden';
                            inputo.name = 'orderID';
                            inputo.value = json[i].IDordine;
                            form.appendChild(inputo);

                            let hdnToken = document.createElement('input');
                            hdnToken.type = 'hidden';
                            hdnToken.name = '_token';
                            hdnToken.value = document.getElementById('tkn').content;
                            form.appendChild(hdnToken);
                    tdf.appendChild(form);
                    row.appendChild(tdf);
                }
            }
    tabArea.appendChild(row);
    }
}