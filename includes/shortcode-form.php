<?php

function wte_render_estimator_form() {
    ob_start(); ?>
    <form id="wte-estimator-form">
        <label>How many people?
            <p class="desc-text">Please enter the number of people attending the tasting event.</p>
            <input type="number" id="wte-people" min="1" required>
        </label>

       <label for="drinkType">Type of Drink:</label>
<p class="desc-text">Please select the type of drink you would like to taste.</p>
<select id="drinkType" name="drink_type">
    <option value="wine">Wine</option>
    <option value="champagne">Champagne</option>
</select>

        <label>Number of drinks to taste:
            <p class="desc-text">Please enter the number of drinks you would like to taste.</p>
            <input type="number" id="wte-drinks" min="1" required>
        </label>

        <label for="wte-reason">Event type:</label>
<p class="desc-text">Please select the reason for your tasting event.</p>
<select id="wte-reason" name="reason" required>
    <option value="">-- Select Reason --</option>
    <option value="corporate_event">Corporate Event</option>
    <option value="birthday">Birthday</option>
    <option value="team_building">Team Building</option>
    <option value="other">Other</option>
</select>

<label for="wte-location">Event Location</label>
<p class="desc-text">Please select your event location.</p>
<select id="wte-location" name="location" required>
  <option value="">-- Select Location --</option>
  <option value="london">London</option>
  <option value="canary_wharf">Canary Wharf</option>
  <option value="city">City of London</option>
  <option value="kent">Kent</option>
   <option value="other">Other</option>
</select>

<label for="wte-name">Full Name</label>
<p class="desc-text">Please enter your full name.</p>
<input type="text" id="wte-name" placeholder="Full name" name="name" required>

        <label>Your email:
            <p class="desc-text">Please enter your email address.</p>
            <input type="email" placeholder="Email"  id="wte-email" required>
        </label>

        <label class="consent-checkbox">
            <input type="checkbox" id="wte-consent" required>
            I consent to being contacted.
        </label>

        <button class="wte-btn btn" type="submit">Get Estimate</button>
         <p><span id="wte-cost">£0.00</span></p>
        <p id="wte-confirmation" style="color: green;"></p>
       
    </form>
    <?php
    return ob_get_clean();
}
