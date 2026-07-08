<!--
SPDX-FileCopyrightText: 2021-2024 Nextcloud GmbH and Nextcloud contributors
SPDX-License-Identifier: MIT
-->

# This repository contains Nextcloud's workflow templates

## Setup a new template on your repository

When creating a new workflow on your repository, you will see templates originating from here.
https://github.com/nextcloud/viewer/actions/new

![image](https://raw.githubusercontent.com/nextcloud/.github/master/screenshots/choose-a-workflow.png)

## Auto-update in a repository

There is a GitHub action for that as well. Simply install
https://github.com/nextcloud/.github/blob/master/workflow-templates/sync-workflow-templates.yml
into your repository and a cron job will update the workflows from the template every sunday morning.

> [!NOTE]
> GitHub does not allow pull request that touch workflows to be auto-approved and auto-merged to improve security.
> But it's at least much easier to be aware of the updates and you just need to approve and merge the PRs.

## Patching workflows

It's also possible to customise workflows by putting a `workflow.yml.patch` file right next to it.
The patch files should be one per workflow and made from the repository root:

Example:
1. Modify `.github/workflows/phpunit-mariadb.yml`
2. Save patch `git diff .github/workflows/phpunit-mariadb.yml > .github/workflows/phpunit-mariadb.yml.patch`

The `sync-workflow-templates.yml` action also supports this and reapplies the patches if possible.
If there was an error it will be outlined in the PR description.

## Update workflows manually

You can also run the following shell script on your machine to update all workflows of an app. It should be run inside the cloned repository of an app and requires rsync to be installed.

⚠️ Do not forget to check the diff for unwanted changes before committing, especially when updating the workflows on stable branches!

```sh
#!/bin/sh

# Update GitHub workflows from the Nextcloud template repository.
# This script is meant to be run from the root of the repository.

# Sanity check
[ ! -d ./.github/workflows/ ] && echo "Error: .github/workflows does not exist" && exit 1

# Clone template repository
temp="$(mktemp -d)"
git clone --depth=1 https://github.com/nextcloud/.github.git "$temp"

# Update workflows
rsync -vr \
    --existing \
    --include='*/' \
    --include='*.yml' \
    --exclude='*' \
    "$temp/workflow-templates/" \
    ./.github/workflows/

# Reapply patches
for patch in ./.github/workflows/*.yml.patch; do
    [ ! -f "$patch" ] && continue
    echo "🩹 Applying $patch"
    if ! patch -p1 < "$patch"; then
        echo "❌ Failed to apply $patch, please resolve manually"
    fi
done

# Cleanup
rm -rf "$temp"
```
