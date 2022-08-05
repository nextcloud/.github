# This repository contains Nextcloud's workflow templates

## Setup a new template on your repository

When creating a new workflow on your repository, you will see templates originating from here.
https://github.com/nextcloud/viewer/actions/new

![image](https://raw.githubusercontent.com/nextcloud/.github/master/screenshots/choose-a-workflow.png)

## Auto-update repositories

For each template, you can propagate them on all the repos that use it.
1. Go into https://github.com/nextcloud/.github/actions/workflows/dispatch-workflow.yml
2. Enter the name of the workflow you want to dispatch
3. Enter the page you want to execute (100 are done per page, so check the [number of repositories](https://github.com/orgs/nextcloud/repositories), current is 260 so run for page: 1, 2 and 3)

  ![image](https://raw.githubusercontent.com/nextcloud/.github/master/screenshots/dispatch-a-workflow.png)

4. Wait for the actions to finish and see the checkout the pull requests
