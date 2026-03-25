const { execSync } = require('child_process');
const fs = require('fs');

const now = Date.now();
const repo = process.env.GITHUB_REPOSITORY;

// Ignore heavy folders
const IGNORE = ['assets', 'uploads', 'node_modules', '.github', 'scripts'];

const files = execSync('git ls-files')
  .toString()
  .split('\n')
  .filter(f => f && !IGNORE.some(i => f.startsWith(i)));

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

// Print tree with delete links
function printTree(node, prefix = '', path = '') {
  let output = '';
  const keys = Object.keys(node);

  keys.forEach((key, index) => {
    const isLast = index === keys.length - 1;
    const connector = isLast ? '└── ' : '├── ';

    const currentPath = path ? `${path}/${key}` : key;

    if (node[key] === null) {
      const lastCommit = getLastCommit(currentPath);
      if (!lastCommit) return;

      const ageDays = Math.floor((now - lastCommit) / (1000 * 60 * 60 * 24));
      const lastUpdated = new Date(lastCommit).toISOString().split('T')[0];

      const deleteLink = `https://github.com/${repo}/blob/main/${currentPath}`;

      output += `${connector}📄 ${key} | 📅 ${lastUpdated} | ⏳ ${ageDays}d | 🗑 [Delete](${deleteLink})\n`;
    } else {
      output += `${connector}📁 ${key}/\n`;

      const childIndent = isLast ? '    ' : '│   ';

      output += printTree(node[key], prefix + key + '/', currentPath)
        .split('\n')
        .map(line => (line ? childIndent + line : line))
        .join('\n');
    }
  });

  return output;
}

const tree = buildTree(files);

const finalOutput = `
## 📂 Smart Repository Explorer

\`\`\`
${printTree(tree)}
\`\`\`
`;

fs.writeFileSync('repo-tree.md', finalOutput);

console.log("✅ Tree with delete links generated");
