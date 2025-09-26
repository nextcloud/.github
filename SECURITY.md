<!--
SPDX-FileCopyrightText: 2021-2024 Nextcloud GmbH and Nextcloud contributors
SPDX-License-Identifier: MIT
-->

# Security Policy 

## 💡 TLDR: Report security issues at [hackerone.com/nextcloud](https://hackerone.com/nextcloud)

### Found a security bug in Nextcloud? Let's get it fixed!

If you believe you have found an issue that meets our 
[definition of a security vulnerability](https://nextcloud.com/security/threat-model), 
we encourage you to let us know right away. Please use the reporting process described below.

| If you are a...         | See section...                                                                        |
|-------------------------|---------------------------------------------------------------------------------------|
| Security Researcher     | [How to Report a Vulnerability](#how-to-report-a-vulnerability)                       |
| Nextcloud Admin or User | [Security Advisories](#security-advisories), [Supported Versions](#supported-versions) |

---

## How to Report a Vulnerability

**⚠️ Do _not_ report security vulnerabilities through public GitHub issues.**

Instead, please:
- Review our [responsible disclosure guidelines](https://nextcloud.com/security/)
- Submit your report via [HackerOne](https://hackerone.com/nextcloud)

Your report should include:
- Product version
- A clear description of the vulnerability
- Steps to reproduce the issue (clear, step-by-step instructions are greatly appreciated)
- Any other details that may assist our investigation

If you require encrypted communication, please request it in your initial message.

> **Note:** This process is for confidential reporting of software vulnerabilities only.  
> For general support or configuration help, see 
> [Nextcloud Support](https://nextcloud.com/support/).

## What to Expect After Reporting

In most cases, you should receive an initial response within 24 hours.

A member of our security team will:
- Confirm the vulnerability
- Assess its impact
- Follow up with any questions
- Coordinate the fix and public disclosure

We apply, test, and release fixes for all relevant, supported stable branches in the next 
security update. Vulnerabilities are publicly announced after the fix is released. As a thank 
you, we will add your name to our [Hall of Fame](https://hackerone.com/nextcloud/thanks).

If your report concerns an app not maintained by Nextcloud (e.g., community-maintained apps 
hosted by Nextcloud or hosted elsewhere), our security team will coordinate with the current 
maintainer to help resolve the issue in a similar fashion.

## Bug Bounties

If you are interested in a bug bounty, please note that complete, detailed reports can 
contribute to higher bounty awards. Details on past bounties are available at 
[HackerOne](https://hackerone.com/nextcloud).

## Security Advisories

Published advisories for Nextcloud Server, Clients, and Apps are available at the 
[Nextcloud Security Advisories](https://github.com/nextcloud/security-advisories/security/advisories) 
page.

## Supported Versions

Each major release of Nextcloud Server receives security updates for one year from its 
initial release date. The Nextcloud project typically supports at least the two most recent 
major releases.

To stay protected:
- Ensure your Nextcloud Server is always running a supported major release
- Promptly apply all maintenance releases (these include critical security and functionality 
  bug fixes)
- Monitor the end-of-life (EOL) date for your major release (after this date, no further 
  maintenance releases will be published. Upgrading to a newer major release is strongly 
  recommended.)

See the 
[Maintenance and Release Schedule](https://github.com/nextcloud/server/wiki/Maintenance-and-Release-Schedule) 
for details.

---

## Additional Information

- [Nextcloud Security Overview](https://nextcloud.com/security/)
- [Threat Model and Accepted Risks](https://nextcloud.com/security/threat-model)
- [Nextcloud Support](https://nextcloud.com/support/)
