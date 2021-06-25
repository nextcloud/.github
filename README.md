# This repository contains Nextcloud's workflow templates

## Setup a new template on your repository

When creating a new workflow on your repository, you will see templates originating from here.
https://github.com/nextcloud/viewer/actions/new

![image](https://user-images.githubusercontent.com/14975046/123411522-d5a12400-d5b0-11eb-996a-5500d2e3de17.png)

## Auto-update repositories

For each template, you can propagate them on all the repos that use it.
1. Go into https://github.com/nextcloud/.github/actions/workflows/dispatch-workflow.yml
2. Enter the name of the workflow you want to dispatch

  ![image](https://user-images.githubusercontent.com/14975046/123411671-fc5f5a80-d5b0-11eb-9aa6-d66373a9515f.png)

3. Wait for the actions to finish and see the checkout the pull requests

