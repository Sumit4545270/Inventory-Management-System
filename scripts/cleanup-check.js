const { execSync } = require('child_process');
const fs = require('fs');

const DAYS_OLD = 30;
const now = Date.now();

function getFiles() {
  return execSync('git ls-files').toString().split('\n');
}

// ✅ Get FIRST commit date (file creation in git)
function getFirstCommitDate(file) {
  try {
    const output = execSync(`git log --diff-filter=A --follow --format=%ct -- "${file}" | tail -1`)
      .toString()
      .trim();

    return output ? parseInt(output) * 1000 : null;
  } catch {
    return null;
  }
}

const files = getFiles();
let result = [];

files.forEach(file => {
  if (!file) return;

  const firstCommit = getFirstCommitDate(file);
  if (!firstCommit) return;

  const ageDays = (now - firstCommit) / (1000 * 60 * 60 * 24);

  if (ageDays > DAYS_OLD) {
    const lastUpdated = new Date(firstCommit).toISOString().split('T')[0];

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
