const fs = require('fs');
const path = require('path');

const DAYS_OLD = 180; // 6 months

function scan(dir) {
  let results = [];
  const now = Date.now();

  fs.readdirSync(dir).forEach(file => {
    if (file === 'node_modules' || file === '.git') return;

    const fullPath = path.join(dir, file);
    const stat = fs.statSync(fullPath);

    if (stat.isDirectory()) {
      results = results.concat(scan(fullPath));
    } else {
      const age = (now - stat.mtimeMs) / (1000 * 60 * 60 * 24);

      if (age > DAYS_OLD) {
        results.push({ file: fullPath, days: Math.floor(age) });
      }
    }
  });

  return results;
}

const data = scan('./');

fs.writeFileSync("unused-files.json", JSON.stringify(data, null, 2));

console.log("Done:", data.length);
