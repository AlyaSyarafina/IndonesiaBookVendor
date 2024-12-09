# How to Contribute to AdminPanel

[[_TOC_]]
### Did you find a bug?
 - Report by making an issue.
   - Please add ~security label if it is related with security bugs.

### Did you write a patch that fixes a bug?
 - Open new MR, mentioning the issue or if the issue is not made yet, please
   explain it on the MR.

 - Make sure you pass the test pipeline to make sure your changes didn't break
   other projects.

### Do you intend to add a new feature or change an existing one?

- Please fo to [Adding Features To Admin Panel: Globally, for Everyone](#globally-for-everyone) section. 

### Do you want to contribute to the documentation?

We do documentation on the header of the PHP function, this way we can have
documentation on:
- Intellisense feature on each IDE, if the IDE supports it.
- PHPDoc, should we want to generate a documentation later.
- Please use English whenever possible.

# Code Convention

We follow CI4's Code Convention. Our current working copy is not fully follow
this convention, but we're slowly update the codebase to comply with the
convention.

For now, please at least follow the `.editorconfig` settings.


# Adding Features To Admin Panel

We're currently still discussing how to extend the admin panel and currently
gathering more usecase and how to better make it faster with those use cases.

For now, if you need to add more functionality to the admin panel, you have to
choose how to implement those features. There are 2 scenarios:

- [Globally, for everyone.](#globally-for-everyone) \
  Useful if you want it to be implemented globally.
  Project that uses this pacakge will just need to `composer update` and
  everything will be installed to the project :D

- [Specific only for your project.](#specific-only-for-your-project) \
  Useful if you have something like chart or custom controls only for this
  project. Other project don't have to know other project's business.

## Globally, for Everyone

In general cases, following requirement should be fulfilled:
- Light enough to be included, even for small project or company profile.
- Do not require additional computational power (e.g. heavy SQL Queries for
  every request)
- The usecase is quite typical. (e.g This feature should be included by default on every
  project because it is basic feature.)

If most or all of those requirements fulfilled, please do the following:
 - Create a new issue on this project
 - Add ~"type::experimental" label to the issue
 - Bring to your manager/supervisor's attention to discuss on this.
 - Optional but very, very reccomended: Create a MR.

If not all those requirements met, usually we suggest either:
- Implement it [specifically on your project](#specific-only-for-your-project).
- Create a new package and install it to your project. (exact way to do this is
  still on discussion)
## Specific, Only for Your Project

Here's things you need to override:
- Create `Controller/Admin.php` from this project's `Admin.php`.
  - I'd recommend to extend the class rather than copying the file. \
    There's some dependencies that need to be triggered when the controller is
    initialized, and it might change when we have better method to extend the
    functionality of this package.
  - Make sure you just override functions you need. \
    Some functions usually depends on other functions, unless there's specific
    use case, we'd recommend you to extend what's needed. We might update the
    implementation and it usually have butterfly effect to other dependecies.

- Add new routing to handle `/admin/panel` to use your newly made `Controller\Admin.php`.
  
- If you need to extend the view, you can copy the files and update the `view`
  on admin panel to use yours. \
  Since view file can't be extended, you can just copy the view file and
  customize to your need.
