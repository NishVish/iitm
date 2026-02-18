import os
import sys

# The marker before which we insert the new block
TARGET_LINE = '<div class="content">'

# The block to insert
INSERT_BLOCK = """<?php
$segment1 = service('uri')->getSegment(1);

if ($segment1 == 'backend') : ?>
    <div class="submenu">
        <a href="<?= base_url('plan') ?>">Plan</a>
        <a href="<?= base_url('games') ?>">Play Games</a>
        <a href="<?= base_url('tv') ?>">TV</a>
        <a href="<?= base_url('company') ?>">View Companies</a>
        <a href="<?= base_url('company/add') ?>">Add Company</a>
    </div>
<?php endif; ?>

</div>
"""

def inject_submenu():
    target_dir = sys.argv[1] if len(sys.argv) > 1 else os.getcwd()

    print(f"Scanning directory: {target_dir}")
    files_updated = 0

    for root, dirs, files in os.walk(target_dir):
        for file in files:
            if file.endswith(".php"):
                file_path = os.path.join(root, file)

                with open(file_path, 'r', encoding='utf-8') as f:
                    content = f.read()

                # Skip if already inserted (safety check)
                if "class=\"submenu\"" in content:
                    continue

                if TARGET_LINE in content:
                    updated_content = content.replace(
                        TARGET_LINE,
                        INSERT_BLOCK + "\n" + TARGET_LINE
                    )

                    with open(file_path, 'w', encoding='utf-8') as f:
                        f.write(updated_content)

                    print(f"Successfully updated: {file}")
                    files_updated += 1

    print("\n--- Process Finished ---")
    print(f"Total PHP files modified: {files_updated}")

if __name__ == "__main__":
    inject_submenu()