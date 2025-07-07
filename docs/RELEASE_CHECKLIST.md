# Release Checklist - Howard Sidebar Menu Block

This checklist ensures a thorough and consistent release process for the Howard Sidebar Menu Block module. Follow this checklist for every release to maintain quality and reliability.

## Pre-Release Preparation

### Version Planning

- [ ] **Determine version number** following [Semantic Versioning](https://semver.org/)
  - MAJOR: Breaking changes (e.g., 11.0.0 → 12.0.0)
  - MINOR: New features, backward compatible (e.g., 11.0.0 → 11.1.0)
  - PATCH: Bug fixes, backward compatible (e.g., 11.0.0 → 11.0.1)

- [ ] **Review planned changes** against version type
  - Breaking changes require MAJOR version bump
  - New features require MINOR version bump
  - Bug fixes require PATCH version bump

### Code Quality Verification

- [ ] **Run coding standards check**
  ```bash
  vendor/bin/phpcs --standard=Drupal,DrupalPractice src/ howard_sidebar_menu_block.module
  ```

- [ ] **Fix any coding standards violations**
  ```bash
  vendor/bin/phpcbf --standard=Drupal src/ howard_sidebar_menu_block.module
  ```

- [ ] **Run static analysis**
  ```bash
  vendor/bin/phpstan analyse src/
  ```

- [ ] **Review code for security issues**
  - Check for XSS vulnerabilities
  - Verify proper access control
  - Review input validation
  - Check for SQL injection risks

### Testing

- [ ] **Run unit tests**
  ```bash
  vendor/bin/phpunit tests/src/Unit/
  ```

- [ ] **Run functional tests**
  ```bash
  vendor/bin/phpunit tests/src/Functional/
  ```

- [ ] **Manual testing checklist**
  - [ ] Block placement works correctly
  - [ ] Menu displays on various page types
  - [ ] Navigation functions properly
  - [ ] Cache invalidation works
  - [ ] Template overrides function
  - [ ] Accessibility features work
  - [ ] Responsive design functions

- [ ] **Cross-browser testing**
  - [ ] Chrome (latest)
  - [ ] Firefox (latest)
  - [ ] Safari (latest)
  - [ ] Edge (latest)
  - [ ] Mobile browsers (iOS Safari, Chrome Mobile)

- [ ] **Performance testing**
  - [ ] Page load times acceptable
  - [ ] Memory usage within limits
  - [ ] Database query count optimized
  - [ ] Cache hit ratio satisfactory

### Documentation

- [ ] **Update version numbers**
  - [ ] `howard_sidebar_menu_block.info.yml`
  - [ ] `composer.json`
  - [ ] Any version constants in code
  - [ ] Documentation references

- [ ] **Update CHANGELOG.md**
  - [ ] Move unreleased changes to new version section
  - [ ] Add release date
  - [ ] Ensure all changes are documented
  - [ ] Follow Keep a Changelog format

- [ ] **Review and update README.md**
  - [ ] Version references are current
  - [ ] Installation instructions are accurate
  - [ ] Feature list is complete
  - [ ] Links are working

- [ ] **Verify API documentation**
  - [ ] All public methods documented
  - [ ] Template variables documented
  - [ ] Hook implementations documented
  - [ ] Code examples are current

- [ ] **Update developer documentation**
  - [ ] Customization examples current
  - [ ] API changes documented
  - [ ] Migration notes if needed
  - [ ] Troubleshooting guide updated

## Release Execution

### Version Control

- [ ] **Ensure all changes are committed**
  ```bash
  git status  # Should show clean working directory
  ```

- [ ] **Create release commit**
  ```bash
  git add -A
  git commit -m "Release v[VERSION]: [BRIEF_DESCRIPTION]

  [DETAILED_DESCRIPTION_OF_CHANGES]"
  ```

- [ ] **Create and push release tag**
  ```bash
  git tag -a v[VERSION] -m "Release version [VERSION]

  [RELEASE_NOTES]"
  git push origin [BRANCH_NAME]
  git push origin v[VERSION]
  ```

### Package Verification

- [ ] **Verify package contents**
  - [ ] All necessary files included
  - [ ] No development files in release
  - [ ] File permissions correct
  - [ ] Documentation files present

- [ ] **Test installation from package**
  ```bash
  # Test Composer installation
  composer require howard/howard_sidebar_menu_block:^[VERSION]
  
  # Test manual installation
  # Download and extract package, verify installation
  ```

## Post-Release Tasks

### Release Announcement

- [ ] **Create GitHub release**
  - [ ] Use annotated tag as base
  - [ ] Include release notes from CHANGELOG.md
  - [ ] Attach any additional assets
  - [ ] Mark as latest release

- [ ] **Update Drupal.org project page** (if applicable)
  - [ ] Upload new release
  - [ ] Update project description
  - [ ] Update screenshots if needed
  - [ ] Post release announcement

- [ ] **Update project website** (if applicable)
  - [ ] Update version information
  - [ ] Refresh documentation
  - [ ] Update download links

### Communication

- [ ] **Notify stakeholders**
  - [ ] Send email to module maintainers
  - [ ] Post to relevant Slack channels
  - [ ] Update internal documentation

- [ ] **Social media announcement** (if major release)
  - [ ] Twitter/X announcement
  - [ ] LinkedIn post
  - [ ] Community forum posts

### Monitoring

- [ ] **Monitor for issues**
  - [ ] Check GitHub issues for new reports
  - [ ] Monitor Drupal.org issue queue
  - [ ] Review error logs for any problems
  - [ ] Monitor usage statistics

- [ ] **Prepare hotfix process**
  - [ ] Identify critical issue response team
  - [ ] Have rollback plan ready
  - [ ] Monitor for security vulnerabilities

### Next Release Planning

- [ ] **Create next version milestone**
  - [ ] Set up GitHub milestone for next version
  - [ ] Plan major features for next release
  - [ ] Update project roadmap

- [ ] **Update development environment**
  - [ ] Bump development version number
  - [ ] Update CHANGELOG.md unreleased section
  - [ ] Create development branch if needed

## Release Notes Template

Use this template for release notes:

```markdown
# Howard Sidebar Menu Block v[VERSION]

Released: [DATE]

## Overview

[Brief description of the release and its significance]

## New Features

- [Feature 1 description]
- [Feature 2 description]

## Improvements

- [Improvement 1 description]
- [Improvement 2 description]

## Bug Fixes

- [Bug fix 1 description]
- [Bug fix 2 description]

## Breaking Changes (if any)

- [Breaking change 1 with migration instructions]
- [Breaking change 2 with migration instructions]

## Upgrade Instructions

1. [Step 1]
2. [Step 2]
3. [Step 3]

## Known Issues

- [Known issue 1 with workaround]
- [Known issue 2 with workaround]

## Download

- **Composer**: `composer require howard/howard_sidebar_menu_block:^[VERSION]`
- **Direct Download**: [GitHub Release Page]
- **Git**: `git clone -b v[VERSION] https://github.com/howard-university-web-services/howard_sidebar_menu_block.git`

## Support

- **Issues**: [GitHub Issues](https://github.com/howard-university-web-services/howard_sidebar_menu_block/issues)
- **Documentation**: [Project Documentation](https://github.com/howard-university-web-services/howard_sidebar_menu_block/tree/main/docs)
- **Maintainer**: Dan Rogers ([Drupal.org](https://www.drupal.org/u/dan_rogers))
```

## Emergency Release Process

For critical security or bug fixes:

### Immediate Response

- [ ] **Assess severity**
  - Security vulnerability level
  - Impact on existing installations
  - Urgency of fix needed

- [ ] **Create hotfix branch**
  ```bash
  git checkout -b hotfix/v[VERSION]
  ```

- [ ] **Implement minimal fix**
  - Focus only on critical issue
  - Avoid scope creep
  - Test thoroughly

- [ ] **Expedited testing**
  - Core functionality testing
  - Security testing if applicable
  - Compatibility testing

### Expedited Release

- [ ] **Fast-track version bump**
  - Use PATCH version increment
  - Update critical documentation only
  - Minimal CHANGELOG.md update

- [ ] **Release immediately**
  ```bash
  git commit -m "Hotfix v[VERSION]: [CRITICAL_ISSUE]"
  git tag -a v[VERSION] -m "Hotfix release v[VERSION]"
  git push origin hotfix/v[VERSION]
  git push origin v[VERSION]
  ```

- [ ] **Emergency communication**
  - Immediate notification to users
  - Security advisory if needed
  - Clear upgrade instructions

## Quality Gates

Each release must pass these quality gates:

### Automated Gates

- [ ] All unit tests pass
- [ ] All functional tests pass
- [ ] Coding standards compliance
- [ ] Static analysis passes
- [ ] No critical security issues

### Manual Gates

- [ ] Manual testing completed
- [ ] Documentation reviewed
- [ ] Accessibility validated
- [ ] Performance acceptable
- [ ] Cross-browser compatibility confirmed

### Approval Gates

- [ ] Code review completed
- [ ] Security review passed (for security-related changes)
- [ ] Maintainer approval obtained
- [ ] Release notes approved

---

*This checklist should be followed for every release to ensure consistency and quality. Update this checklist as the release process evolves.*
