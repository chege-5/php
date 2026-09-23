<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Location Selector</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <main class="container">
        <header class="page-header">
            <h1>Location Selector</h1>
            <p>Hierarchical location selection</p>
        </header>

        <section class="selector-section" aria-labelledby="cascade-title">
            <h2 id="cascade-title">Cascade</h2>
            <p class="section-description">Select from top to bottom to filter each location level.</p>
            <div class="selector-row">
                <div class="field"><label for="cascade-continent">Continent</label><select id="cascade-continent"></select></div>
                <span class="arrow" aria-hidden="true">→</span>
                <div class="field"><label for="cascade-country">Country</label><select id="cascade-country"></select></div>
                <span class="arrow" aria-hidden="true">→</span>
                <div class="field"><label for="cascade-county">County</label><select id="cascade-county"></select></div>
                <span class="arrow" aria-hidden="true">→</span>
                <div class="field"><label for="cascade-ward">Ward</label><select id="cascade-ward"></select></div>
                <span class="arrow" aria-hidden="true">→</span>
                <div class="field"><label for="cascade-village">Village</label><select id="cascade-village"></select></div>
            </div>
            <div class="result" aria-live="polite">
                <span class="result-label">Selected location</span>
                <p id="cascade-result">No location selected</p>
            </div>
        </section>

        <section class="selector-section" aria-labelledby="reverse-title">
            <h2 id="reverse-title">Reverse Cascade</h2>
            <p class="section-description">Select any location level and its parent locations are automatically resolved.</p>
            <div class="selector-row">
                <div class="field"><label for="reverse-continent">Continent</label><select id="reverse-continent"></select></div>
                <div class="field"><label for="reverse-country">Country</label><select id="reverse-country"></select></div>
                <div class="field"><label for="reverse-county">County</label><select id="reverse-county"></select></div>
                <div class="field"><label for="reverse-ward">Ward</label><select id="reverse-ward"></select></div>
                <div class="field"><label for="reverse-village">Village</label><select id="reverse-village"></select></div>
            </div>
            <div class="result" aria-live="polite">
                <span class="result-label">Resolved hierarchy</span>
                <p id="reverse-result">No location selected</p>
            </div>
        </section>
    </main>
    <script src="js/app.js"></script>
</body>
</html>
