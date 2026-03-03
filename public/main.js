function init() {

    const input = document.getElementById('card_search_input');
    const tbody = document.getElementById('tbody');

    if (!input) return;

    input.addEventListener('input', async () => {

        const name = input.value;

        if (name.length < 2) {
            tbody.innerHTML = '';
            return;
        }

        const url = `https://api.scryfall.com/cards/search?q=${encodeURIComponent(name)}&include_multilingual=true`;    
        const response = await fetch(url);
        const json = await response.json();
        const cards = json.data;

        tbody.innerHTML = '';

        for (let i = 0; i < Math.min(5, cards.length); i++) {

            const tr = document.createElement('tr');

            const tdName = document.createElement('td');
            tdName.textContent = cards[i].name;

            const tdAction = document.createElement('td');
            const button = document.createElement('button');
            button.textContent = "Choisir";
            button.type = "button";

            button.addEventListener('click', () => {
                const selectedName = cards[i].name;
                window.location.href = `/card?name=${encodeURIComponent(selectedName)}`;
            });

            tdAction.appendChild(button);
            tr.appendChild(tdName);
            tr.appendChild(tdAction);
            tbody.appendChild(tr);
        }

    });
}

document.addEventListener('DOMContentLoaded', init);
document.addEventListener('turbo:load', init);