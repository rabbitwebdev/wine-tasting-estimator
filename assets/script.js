document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('wte-estimator-form');
    const peopleInput = form.querySelector('#wte-people');
    const drinksInput = form.querySelector('#wte-drinks');
    const typeInput = form.querySelector('#drinkType');
    const costDisplay = form.querySelector('#wte-cost');
    const emailInput = form.querySelector('#wte-email');
    const consentInput = form.querySelector('#wte-consent');
    const confirmation = form.querySelector('#wte-confirmation');

    const baseRate = parseFloat(wte_ajax.base_rate);
    const wineRate = parseFloat(wte_ajax.wine_rate);
    const champagneRate = parseFloat(wte_ajax.champagne_rate);

    function calculateCost() {
        const people = parseInt(peopleInput.value) || 0;
        const drinks = parseInt(drinksInput.value) || 0;
        const drinkType = typeInput.value;

        const drinkRate = (drinkType === 'champagne') ? champagneRate : wineRate;
        const total = (people * baseRate) + (drinks * drinkRate);

        costDisplay.textContent = '£' + total.toFixed(2);
    }

    peopleInput.addEventListener('input', calculateCost);
    drinksInput.addEventListener('input', calculateCost);
    typeInput.addEventListener('change', calculateCost);

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        if (!consentInput.checked) {
            alert("Consent required!");
            return;
        }

        const data = new FormData();
        data.append('action', 'wte_save_estimate');
        data.append('people', peopleInput.value);
        data.append('type', typeInput.value);
        data.append('drinks', drinksInput.value);
        data.append('email', emailInput.value);
        data.append('drink_type', typeInput.value); // ✅ send drink type

        fetch(wte_ajax.ajax_url, {
            method: 'POST',
            body: data
        })
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                confirmation.textContent = "Estimate sent to your email!";
                form.reset();
                calculateCost(); // Recalculate with cleared inputs
                setTimeout(() => confirmation.textContent = "", 5000);
            }
        });
    });
});
