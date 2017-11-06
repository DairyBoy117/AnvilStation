=== File upload and download Manager Plugin ===
Contributors: nmedia
Tags: file upload, front end form, file submission
Donate link: http://www.najeebmedia.com/donate
Requires at least: 3.5
Tested up to: 4.7.3
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html

WP Front end file upload and download manager plugin.

== Description ==

File Upload and Download is simply the best WordPress Front End plugin allow users, clients or members to upload and manage files of any type like PDF, Images, Docs, Sheets, Videos etc. There are bunch of options in under plugin settings allow admin to control Upload form like:

* Create Download Area (V 8.3+)
* Group file sharing (V 8.3+)
* Set File size quota Roles based
* Allow Public Users to Upload
* Set Filetype, File size, File Count Limits and much more

== Installation ==
1. Upload plugin directory to the `/wp-content/plugins/` directory
2. Activate the plugin through the `Plugins` menu in WordPress
3. After activation, you can set options from `FileManager` menu 


== Changelog ==
= 12.0 ----- =
* Featre Added: VC Addon created for File Manager
* Feature Added: Remove all intermediat image size using get_intermediate_image_sizes() wp function
* Bug fixed: Email notifications were not sent, it's fixed now
= 11.8 May 2, 2017 =
* Featre Added: Fixed home button heirarichy and added hide/show logout button in admin option
= 11.7 April 21, 2017 =
* Featre Added: Add option to limit files per user
= 11.6 April 15, 2017 =
* Featre Added: Drag files into Directory
* Bug fixed: Max files filter not working in new UI, it's fixed
= 11.5 March 25, 2017 =
* Featre Added: Amazon Secure by Time Limit in minutes
* Some warnings removed
* Tree view removed. Better UI is stable
* Some settings removed, lide hide upload, listing sections options
= 11.4 March 21, 2017 =
* Feature Added: Groups can now be added during File Uploader optionally.
* Bug fixed: Directory not created when BuddyPress group_id not found
* Some options deleted from admin, hide upload area, hide listing, tree style view etc.
= 11.3 March 7, 2017 =
* Fixed: Time zone issue on file detail page
* Fixed: Breadcrum not resetting when deleting director, now it is fixed
= 11.2 March 3, 2017 =
* Fixed angular compatibility issue with IE
= 11.1 February 14, 2017 =
* Featured: Now Files (custom post nm-usefiles) cannot be accessed publically and other authors.
* Bug fixed: BuddyPress warnings removed
* Bug fixed: File rename issue fixed. Only prefix.
= 11.0 November 29, 16 =
* Featured: Now File Groups can be set by users on Frontend
= 10.9.6 November 20, 16 =
* Bug fixed: Group file sharing issue fixed in new template
* Bug fixed: Amazon file uploading issue fixed in new version
* Featre: Translation ready for new design
= 10.9.5 November 3, 2016 =
* Feautre: File rename option added, timestamp can be added before/after real filename
* Feature: Admin option to Disable/Enable 'Send File' Option
= 10.9.4 October 23, 2016 =
* Bug fixed: Files were not shared in BP Groups, now ti's fixed
= 10.9.3 October 15, 2016 =
* Bug fixed: User can still create directory when disabled from backend
* Bug fixed: Edit File meta panel still shows when disabled from backend
* Bug fixed: Responsive and Design issues
= 10.9.2 October 11, 2016 =
* Bug fixed: Site opens in popup when deleting directory
= 10.9.1 October 8, 2016 =
* Bug fixed: Files were not uploaded when filetypes not correct or provided.
= 10.9 September 29, 2016 =
* Design: Old version file info popup design make better
= 10.8 September 29, 2016 =
* Bug fixed: Filename issue fixed
* Feature: filter added to change filename
= 10.7 September 27, 2016 =
* Bug fixed: Some security issues fixed.
= 10.6 September 23, 2016 =
* Bug fixed: filename was changing to 'blob', it's fixed now.
= 10.5 September 20, 2016 =
* Stablized Version: Now it's not Beta.
* Feature: Simplify upload process, when file is selected it auto uploaded
* Feautre: When file is deleted with Amazon Addon page is refreshed
= 10.4 July 26, 2016 =
* Bug fixed: Amazon uploaded files physically not deleting, now it's.
= 10.2 July 26, 2016 =
* Bug fixed: Filetypes other then images not working, it's fixed now
= 10.1 July 18, 2016 =
* Bug fixed: filename was changing to 'blob', it's fixed now.
= 10.0 (Beta) June 22, 2016 =
* New Awesome Frontend using AngularJS and Bootstrap
* Files searching, sorting and listing styles
* Recent files section
* Each file detail
* Amazon direct file upload to AWS 3
= 9.4 Mar 25, 2016 =
* Featured: Share files with add on from admin
* Bug fixed: Remove user's upload folder/subfolders and files on user delete.
* Bug fixed: Custom posts were not deleting on user delete. Fixed
* Bug fixed: On deleting directory, its child physical files were not deleting from server.
* Bug fixed: Other auto-generated sized images were not deleting.
= 9.3 Feb 16, 2016 =
* Featured: New option to upload files to users via FTP (v9.3+)
* Bug Fixed: Download area view fixed
= 9.2 January 24, 2016 =
* Bug Fixed: Removed all Notices and Warnings
* Bug Fixed: File extension security check fixed
* Featured: View file detail popup design improved (Next launched)
= 9.1 December 2, 2015 =
* BUG Fixed: Sub directory not loading files when Tree view enabled - Now it's fixed
= 9.0 November 18, 2015 =
* Feature: Better Tree View listing with skins option
* Feature: Directory Sharing feature added
* Updated: DataTables latest version added
* Bug fixed: some minor bugs are fixed
= 8.13 13/7/2015 =
* Featured: Now file meta box is replaced with inline editor
* Bug Fixed: Filesize issue fixed in TREE view template
= 8.12 25/6/2015 =
* Removed some warnings and notices
* How to section removed
= 8.11 17/6/2015 =
* Following hooks added to plugin:
* https://gist.github.com/nmedia82/2413afbc20bb7559de12
= 8.10 9/6/2015 =
* Bug Fixed: Buyddpress Tree view listing now showing the shared files, now it is.
= 8.9 24/5/2015 =
* Feature: Download area for public users
* Feature: Files download stats
* Feature: File share/unshare with users option
= 8.8 =
* Bug Fixed: Filesize not shown in shared enviroment
= 8.7 =
* Bug Fixed: 'From Email' user option added in plugin option
= 8.6 =
* Bug Fixed: email notification when file shared
* Feature: Admin can now see all user files under one page in Admin panel
= 8.5 18/3/2015 =
* BuddyPress Group File Share Integration
* A Bug releated to security breach is just removed
= 8.4 =
* A small development BUG is removed when saving the file.
= 8.3 19/01/2015 =
* Fixed: physical file deleted when file removed
* Fixed: broken download link fixed when shared a file in email
* Feature: Now file meta can be attached when file is uploaded
* Feature: File groups support added
* Feature: Admin can create Download Areas
= 8.2 21/12/2014 =
* File size quota with Roles
* Set more emails to receive upload alert
* Download link added into email for file
* Directory is now optional
* Fixed extra thumbs generation against each image
* Download large files in Chunks
* Fix download link in admin for non-images
= 8.1 28/11/2014 =
* Awesome font icons instead graphics
* Custom message if user not logged in option
* plupload new version 2.1.2
* Email sent notification fixed
* Fixed shared file boken link fixed
* Directory option added
* Tree view template added
