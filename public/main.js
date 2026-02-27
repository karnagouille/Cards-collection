

console.log('JS chargé');
// Prévisualisation d'image
function previewFile() {
    const preview = document.querySelector("img");
    const file = document.querySelector("input[type=file]").files[0];
    const reader = new FileReader();

    reader.addEventListener("load",() => {
      // on convertit l'image en une chaîne de caractères base64
    preview.src = reader.result;
    },
    false,
);

    if (file) {
    reader.readAsDataURL(file);
}
}



const input = document.getElementById('card_search_input');

input.addEventListener('change',async ()=>{    
    getData();
});



async function getData() {

    const name = input.value;
    const url = `https://api.scryfall.com/cards/search?q=${encodeURIComponent(name)}&include_multilingual=true`;    
    const response = await fetch(url);
    const json = await response.json();
    const card =json.data;


    const tbody = document.getElementById('tbody');
    tbody.innerHTML = '';
    for (let i = 0; i < Math.min(5, card.length); i++) {


        const tableau = document.createElement('tr');
        const td = document.createElement('td');

        tableau.appendChild(td);
        tbody.appendChild(tableau);
        td.textContent = card[i].name;
        
        td.addEventListener('click',()=>{
            console.log(card[i].image_uris.png)
            const img = document.getElementById('img');
        img.src = card[i].image_uris.png;
        const id = document.getElementById('add_cards_cardId');
        id.value = card[i].id;
        })

        
        
    }
    return card

}

































/*

const input = document.getElementById('card_search_input');

input.addEventListener('change', async () => {
    const cards = await searchCard();
    cards.forEach((card) => {
        addCardToList(card);
    });
});

async function searchCard() {
    if(!(input instanceof HTMLInputElement)) {
        return;
    }

    const cardName = input.value;
    const apiUrl = https://api.scryfall.com/cards/search?q=${encodeURI(cardName)};
    const response = await fetch(apiUrl);
    const json = await response.json();
    const cards = json.data;

    return cards;
}

function addCardToList() {
    const list = document.getElementById('card_list');

    console.log(json);

    list.innerHTML = '';

    cards.forEach((card) => {
        const option = document.createElement('option');
        option.value = card.name;
        list.appendChild(option);
    });
}
    */