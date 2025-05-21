<?php

function wte_render_estimator_form() {
    ob_start(); ?>
    <form id="wte-estimator-form">
        <label>How many people?
            <input type="number" id="wte-people" min="1" required>
        </label>

       <label for="drinkType">Type of Drink:</label>
<select id="drinkType" name="drink_type">
    <option value="wine">Wine</option>
    <option value="champagne">Champagne</option>
</select>

        <label>Number of drinks to taste:
            <input type="number" id="wte-drinks" min="1" required>
        </label>

        <label>Your email:
            <input type="email" id="wte-email" required>
        </label>

        <label>
            <input type="checkbox" id="wte-consent" required>
            I consent to being contacted about this estimate.
        </label>

        <p><strong>Estimated Cost:</strong> <span id="wte-cost">£0.00</span></p>

        <button type="submit">Get Estimate</button>
        <p id="wte-confirmation" style="color: green;"></p>
    </form>
    <?php
    return ob_get_clean();
}
