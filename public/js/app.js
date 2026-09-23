const levels = ['continent', 'country', 'county', 'ward', 'village'];

const urls = {
    continent: '/api/continents.php',
    country: id => id ? `/api/countries.php?continent_id=${id}` : '/api/countries.php',
    county: id => id ? `/api/counties.php?country_id=${id}` : '/api/counties.php',
    ward: id => id ? `/api/wards.php?county_id=${id}` : '/api/wards.php',
    village: id => id ? `/api/villages.php?ward_id=${id}` : '/api/villages.php'
};

const getSelects = prefix => Object.fromEntries(
    levels.map(level => [level, document.getElementById(`${prefix}-${level}`)])
);

const loadOptions = async (select, url, selected = '') => {
    const label = select.id.split('-').pop();
    select.innerHTML = `<option value="">Select ${label}</option>`;

    const data = await fetch(url).then(response => response.json());
    data.forEach(item => select.add(new Option(item.name, item.id)));
    select.value = selected || '';
};

const loadAll = selects => Promise.all(levels.map(level =>
    loadOptions(selects[level], level === 'continent' ? urls[level] : urls[level]())
));

const updateResult = (selects, result, order) => {
    const names = order
        .map(level => selects[level].value && selects[level].selectedOptions[0]?.text)
        .filter(Boolean);

    result.textContent = names.length ? names.join(' → ') : 'No location selected';
};

const loadBelow = async (selects, level) => {
    const start = levels.indexOf(level) + 1;

    for (const child of levels.slice(start)) {
        await loadOptions(selects[child], urls[child]());
    }
};

const setupCascade = () => {
    const selects = getSelects('cascade');
    const result = document.getElementById('cascade-result');

    selects.continent.onchange = async () => {
        await loadOptions(selects.country, urls.country(selects.continent.value));
        await loadBelow(selects, 'country');
        updateResult(selects, result, levels);
    };

    for (const level of levels.slice(1)) {
        selects[level].onchange = async () => {
            const child = levels[levels.indexOf(level) + 1];

            if (child) {
                await loadOptions(selects[child], urls[child](selects[level].value));
                await loadBelow(selects, child);
            }

            updateResult(selects, result, levels);
        };
    }

    return loadAll(selects).then(() => updateResult(selects, result, levels));
};

const resolveParents = async (selects, type, id) => {
    const location = await fetch(
        `/api/location.php?type=${type}&id=${encodeURIComponent(id)}`
    ).then(response => response.json());

    selects.continent.value = location.continent_id;
    await loadOptions(selects.country, urls.country(location.continent_id), location.country_id);
    await loadOptions(selects.county, urls.county(location.country_id), location.county_id);
    await loadOptions(selects.ward, urls.ward(location.county_id), location.ward_id);
    await loadOptions(selects.village, urls.village(location.ward_id), location.village_id);
};

const setupReverseCascade = () => {
    const selects = getSelects('reverse');
    const result = document.getElementById('reverse-result');
    const reverseLevels = [...levels].reverse();

    selects.continent.onchange = async () => {
        await loadOptions(selects.country, urls.country(selects.continent.value));
        await loadBelow(selects, 'country');
        updateResult(selects, result, reverseLevels);
    };

    for (const level of levels.slice(1)) {
        selects[level].onchange = async () => {
            if (selects[level].value) {
                await resolveParents(selects, level, selects[level].value);
            } else {
                await loadBelow(selects, level);
            }

            updateResult(selects, result, reverseLevels);
        };
    }

    return loadAll(selects).then(() => updateResult(selects, result, reverseLevels));
};

Promise.all([setupCascade(), setupReverseCascade()]);
