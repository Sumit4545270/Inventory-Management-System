const { execSync } = require('child_process');
const fs = require('fs');

const now = Date.now();

// ❌ Ignore unwanted folders
const IGNORE = ['assets', 'uploads', 'node_modules', '.github', 'scripts'];

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

// Build nested tree
function buildTree(files) {
  const root = {};

  files.forEach(file => {
    const parts = file.split('/');
    let current = root;

    parts.forEach((part, index) => {
      if (!current[part]) {
        current[part] = index === parts.length - 1 ? null : {};
      }
      current = current[part];
    });
  });

  return root;
}

// Print tree properly with indentation
function printTree(node, prefix = '') {
  let output = '';
  const keys = Object.keys(node);

  keys.forEach((key, index) => {
    const isLast = index === keys.length - 1;
    const connector = isLast ? '└── ' : '├── ';

    if (node[key] === null) {
      const lastCommit = getLastCommit(prefix + key);
      if (!lastCommit) return;

      const ageDays = Math.floor((now - lastCommit) / (1000 * 60 * 60 * 24));
      const lastUpdated = new Date(lastCommit).toISOString().split('T')[0];

      output += `${connector}📄 ${key} (📅 ${lastUpdated}, ⏳ ${ageDays}d)\n`;
    } else {
      output += `${connector}📁 ${key}/\n`;

      const nextPrefix = prefix + key + '/';
      const childIndent = isLast ? '    ' : '│   ';

      output += printTree(node[key], nextPrefix)
        .split('\n')
        .map(line => (line ? childIndent + line : line))
        .join('\n');
    }
  });

  return output;
}

const tree = buildTree(files);

const finalOutput = `
## 📂 Clean Repository Structure

\`\`\`
${printTree(tree)}
\`\`\`
`;

fs.writeFileSync('repo-tree.md', finalOutput);

console.log("✅ Proper tree generated");
