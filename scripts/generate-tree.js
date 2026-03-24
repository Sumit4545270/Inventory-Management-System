const { execSync } = require('child_process');
const fs = require('fs');

const now = Date.now();

// ❌ Ignore these folders (IMPORTANT)
const IGNORE = ['assets', 'node_modules', '.github', 'scripts'];

// Get files
const files = execSync('git ls-files')
  .toString()
  .split('\n')
  .filter(f => f && !IGNORE.some(i => f.startsWith(i)));

// Get last commit date
function getLastCommit(file) {
  try {
    const output = execSync(`git log -1 --format=%ct -- "${file}"`).toString().trim();
    return parseInt(output) * 1000;
  } catch {
    return null;
  }
}

// Build tree
function buildTree(files) {
  const tree = {};

  files.forEach(file => {
    const parts = file.split('/');
    let current = tree;

    parts.forEach((part, index) => {
      if (!current[part]) {
        current[part] = index === parts.length - 1 ? null : {};
      }
      current = current[part];
    });
  });

  return tree;
}

// Generate tree view
function printTree(obj, prefix = '') {
  let output = '';

  for (const key in obj) {
    if (obj[key] === null) {
      const lastCommit = getLastCommit(prefix + key);
      if (!lastCommit) continue;

      const ageDays = Math.floor((now - lastCommit) / (1000 * 60 * 60 * 24));
      const lastUpdated = new Date(lastCommit).toISOString().split('T')[0];

      output += `├── 📄 ${key} (📅 ${lastUpdated}, ⏳ ${ageDays}d)\n`;
    } else {
      output += `├── 📁 ${key}/\n`;
      output += printTree(obj[key], prefix + key + '/');
    }
  }

  return output;
}

const tree = buildTree(files);

const finalOutput = `
## 📂 Repository Structure

\`\`\`
${printTree(tree)}
\`\`\`
`;

fs.writeFileSync('repo-tree.md', finalOutput);

console.log("Clean tree generated ✅");
