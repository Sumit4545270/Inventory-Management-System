const { execSync } = require('child_process');
const fs = require('fs');

const now = Date.now();

// Get all tracked files
const files = execSync('git ls-files')
  .toString()
  .split('\n')
  .filter(f => f && !f.includes('.github') && !f.includes('scripts'));

// Get last commit date
function getLastCommit(file) {
  try {
    const output = execSync(`git log -1 --format=%ct -- "${file}"`).toString().trim();
    return parseInt(output) * 1000;
  } catch {
    return null;
  }
}

// Generate output
let output = `## 📂 Repository File Explorer\n\n`;

files.forEach(file => {
  const lastCommit = getLastCommit(file);
  if (!lastCommit) return;

  const ageDays = Math.floor((now - lastCommit) / (1000 * 60 * 60 * 24));
  const lastUpdated = new Date(lastCommit).toISOString().split('T')[0];

  output += `- 📄 ${file} (📅 ${lastUpdated}, ⏳ ${ageDays} days)\n`;
});

// Save result
fs.writeFileSync('repo-tree.md', output);

console.log("Tree generated successfully");
