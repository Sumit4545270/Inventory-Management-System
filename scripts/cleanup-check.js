const fs = require('fs');
const path = require('path');

const DAYS_OLD = 365;
const now = Date.now();

function scan(dir) {
  let results = [];

  fs.readdirSync(dir).forEach(file => {
    if (file === 'node_modules' || file === '.git') return;

    const fullPath = path.join(dir, file);
    const stat = fs.statSync(fullPath);

    if (stat.isDirectory()) {
      results = results.concat(scan(fullPath));
    } else {
      const ageDays = (now - stat.mtimeMs) / (1000 * 60 * 60 * 24);

      if (ageDays > DAYS_OLD) {
        const lastUpdated = new Date(stat.mtimeMs).toISOString().split('T')[0];

        results.push({
          file: fullPath,
          lastUpdated,
          ageDays: Math.floor(ageDays),
          ageYears: (ageDays / 365).toFixed(1)
        });
      }
    }
  });

  return results;
}

const data = scan('./');

fs.writeFileSync('unused-files.json', JSON.stringify(data, null, 2));

console.log("Found:", data.length);
