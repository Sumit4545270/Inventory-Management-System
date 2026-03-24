const fs = require('fs');
const path = require('path');

const DAYS_OLD = 30; // 1 month
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
      const ageDays = (now - stat.birthtimeMs) / (1000 * 60 * 60 * 24);

      if (ageDays > DAYS_OLD) {
        const lastUpdated = new Date(stat.birthtimeMs).toISOString().split('T')[0];

        results.push({
          file: fullPath,
          lastUpdated,
          ageDays: Math.floor(ageDays),
          ageMonths: (ageDays / 30).toFixed(1)
        });
      }
    }
  });

  return results;
}

const data = scan('./');

fs.writeFileSync('unused-files.json', JSON.stringify(data, null, 2));

console.log("Found:", data.length);
