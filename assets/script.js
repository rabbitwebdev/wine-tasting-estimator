document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('wte-estimator-form');
    const peopleInput = form.querySelector('#wte-people');
    const drinksInput = form.querySelector('#wte-drinks');
    const typeInput = form.querySelector('#wte-type');
    const costDisplay = form.querySelector('#wte-cost');
    const emailInput = form.querySelector('#wte-email');
    const consentInput = form.querySelector('#wte-consent');
    const confirmation = form.querySelector('#wte-confirmation');

    function calculateCost() {
        const people = parseInt(peopleInput.value) || 0;
        const drinks = parseInt(drinksInput.value) || 0;

        const baseRate = 25;
        const drinkRate = 10;

        const total = (people * baseRate) + (drinks * drinkRate);
        costDisplay.textContent = '£' + total.toFixed(2);
    }

    peopleInput.addEventListener('input', calculateCost);
    drinksInput.addEventListener('input', calculateCost);

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        if (!consentInput.checked) return alert("Consent required!");

        const data = new FormData();
        data.append('action', 'wte_save_estimate');
        data.append('people', peopleInput.value);
        data.append('type', typeInput.value);
        data.append('drinks', drinksInput.value);
        data.append('email', emailInput.value);

        fetch(wte_ajax.ajax_url, {
            method: 'POST',
            body: data
        })
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                confirmation.textContent = "Estimate sent to your email!";
            }
        });
    });
});
