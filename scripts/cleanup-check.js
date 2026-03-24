const { execSync } = require('child_process');
const fs = require('fs');

const DAYS_OLD = 90;
const now = Date.now();

function getFiles() {
  return execSync('git ls-files').toString().split('\n');
}

function getLastCommitDate(file) {
  try {
    const output = execSync(`git log -1 --format=%ct -- "${file}"`).toString().trim();
    return parseInt(output) * 1000;
  } catch {
    return null;
  }
}

const files = getFiles();
let result = [];

files.forEach(file => {
  if (!file) return;

  const lastCommit = getLastCommitDate(file);
  if (!lastCommit) return;

  const ageDays = (now - lastCommit) / (1000 * 60 * 60 * 24);

  if (ageDays > DAYS_OLD) {
    const lastUpdated = new Date(lastCommit).toISOString().split('T')[0];

    result.push({
      file,
      lastUpdated,
      ageDays: Math.floor(ageDays),
      ageMonths: (ageDays / 30).toFixed(1)
    });
  }
});

fs.writeFileSync('unused-files.json', JSON.stringify(result, null, 2));

console.log("Found:", result.length);
