// Run in the browser on the isolated demo database before taking a screenshot.
// Identities are replaced before blur is applied, so the screenshot contains no original text.
(() => {
    if (window.authUser?.fullName !== 'Demo Admin') {
        throw new Error('Capture requires the synthetic Demo Admin session.');
    }
    const style = document.createElement('style');
    style.textContent = `
        .capture-redacted { filter: blur(5px); user-select: none; }
        .capture-portrait { filter: blur(8px); }
        body::after { content: 'DEMO DATA · IDENTITIES CONCEALED'; position: fixed;
            bottom: 18px; right: 24px; padding: 8px 12px; border-radius: 6px;
            background: #e7edf5; color: #53667b; font: 11px sans-serif; letter-spacing: 1px; z-index: 9999; }
    `;
    document.head.appendChild(style);
    document.querySelectorAll('.poplit a').forEach(element => {
        element.textContent = 'Protected identity';
        element.classList.add('capture-redacted');
    });
    let count = 0;
    document.querySelectorAll('table').forEach(table => {
        const headers = [...table.querySelectorAll('th')].map(th => th.textContent.trim().toLowerCase());
        table.querySelectorAll('tr').forEach(row => {
            [...row.querySelectorAll('td')].forEach((cell, index) => {
                if (/^(nom complet|email|d_naissance|releveur|acteur|s_num)$/.test(headers[index])) {
                    cell.textContent = 'Protected';
                    cell.classList.add('capture-redacted');
                    count++;
                }
            });
        });
    });
    document.querySelectorAll('img[src*="/uploads/"]').forEach(img => {
        img.src = '/uploads/demo-avatar.svg';
        img.classList.add('capture-portrait');
    });
    document.querySelectorAll('input[type=email], input[type=password]').forEach(input => input.value = '');
    return { redactedCells: count, syntheticSession: true };
})();
