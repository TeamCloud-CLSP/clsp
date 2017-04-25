# CLSP 2.0.0 (2017-04-24)

### New Features
- All existing features have been rewritten, and we've reached feature parity with the current CLSP site.
- Added 4 Tier registration system with the 4 different roles (Admin, Designer, Professor, Student). A user from a higher tier can create a registration code that can be used be a user on the next tier down. For example, an Admin can invite a Designer, a Designer can invite a Professor, and a Professor can invite a Student.
- All large text input fields (the kind where you would enter more than a single line of text) now have a rich text editor (CKeditor).
- Enhanced security 1 - it is no longer possible to perform a SQL injection attack, as all database accesses using user provided parameters use parameterized SQL queries.
- Enhanced security 2 -Passwords are not stored in plaintext, they're hashed with bcrypt before they're entered into the database.
- Frontend UI is now responsive (using Bootstrap 3).
- Added forgot password functionality. If you forget your password, you can send yourself a password reset link that allows you to reset it.
- UI now incorporates Georgia Tech branding
- Added HTML tags to increase accessiblity for users using screenreaders (feature is incorporated into Bootstrap).
- Upgraded supported PHP version to 7.1. If the site is run using latest PHP version, performance will be significantly better than the old site (which only ran on PHP 5.3).
- Frontend has been transformed into a Single Page Application (spa), which decreases load times on all pages.
- Enhanced UI with Bootrap 3, so the site looks less dated.
- Added multiple admin and designer account support, and made it easier to change the password, so the admin panel password no longer has to be shared.
- Upgraded site to use newer web frameworks (Symfony 3.2 and Angular 4), so the backend and frontend are more secure, faster, and will be well supported well into the future.
- Switched authentication method from cookie authentication to JSON Web Token (JWT) auth, which makes the site more secure.
- Separated the backend and frontend of components of the website to make it easier to change the frontend UI.
- Added support for uploading more than one file at one time.

### Bug Fixes
- Fixed SQL injection attack vectors in the administrator section of the site.
- Fixed error where pressing the back button on certain pages would lead to cause an error.
- Fixed issue where site paramaters were being passed in plaintext via GET parameters/
- Fixed broken media file upload system, so uploading a file to the server works (instead of just providing a broken link).
- Fixed UI so screen real estate would be better utilized.
- Fixed database schema so that it's normalized to at least first normal form.
- Fixed database schema so text is stored as text, making it easier to edit on the backend.
- Fixed database schema so relationships are properly used to manage entities.

### Known Issues
- Georgia Tech Modern Languages header image is not responsive, and doesn't scale properly when the screen is resized.
- Large images in an annotation will not scale, and sometimes overflow the screen.
- Frontend will compiler with warnings when the ```ng build -prod``` flag is used.
- Navbar doesn't scale properly on smaller windows, and sometimes dissappears.
- Clicking on some breadcrumb links will force a page load, when one isn't necessary. 
- Some pages should have the white space pre wrap style removed.
- Angular 4 project structure does not conform with accepted standard.
- Favicon looks ugly, especially when not used on a white background.

### Credits

- Jinsong Han [@jhan24] - Created basically the entire backend.
- Zakir Makda [@zak160] - Setup media uploading and linking.
- David Riazati [@driazati] - Created annotation system, setup rich text editor, added various admin/designer/professor/student views, made UI changes and bugfixes.
- Yuanhan Pan [@kevintasta] - Project Manager - Created quiz system, added various admin/designer/professor/student views, made UI changes and bugfixes, and ported a portion of the database from the old site.
- Patrick Tam [@pjztam] - Setup the frontend and backend projects, created authentication, login, registration, and forgot password system on front and back end, and created part of the schema. Also made misc. changes to the frontend UI and cleaned out project, and wrote documentation.

[@pjztam]:<https://github.com/pjztam>
[@driazati]:<https://github.com/driazati>
[@kevintasta]:<https://github.com/kevintasta>
[@zak160]:<https://github.com/zak160>
[@jhan24]:<https://github.com/jhan24>



