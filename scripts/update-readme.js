const fs = require('fs');

if (!fs.existsSync('repo-tree.md')) {
  console.log("No tree data");
  process.exit(0);
}

const tree = fs.readFileSync('repo-tree.md', 'utf-8');

let readme = fs.existsSync('README.md')
  ? fs.readFileSync('README.md', 'utf-8')
  : '';

const markerStart = "<!-- TREE_START -->";
const markerEnd = "<!-- TREE_END -->";

const newSection = `${markerStart}\n${tree}\n${markerEnd}`;

if (readme.includes(markerStart)) {
  readme = readme.replace(
    new RegExp(`${markerStart}[\\s\\S]*${markerEnd}`),
    newSection
  );
} else {
  readme += "\n\n" + newSection;
}

fs.writeFileSync('README.md', readme);

console.log("README updated");
