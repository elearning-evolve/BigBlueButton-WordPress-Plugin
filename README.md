# Virtual Classroom - Video Conferencing & Online Meeting with BigBlueButton #

Contributors: blindsidenetworks, jfederico, yfngdu, elearningevolve, adeelraza_786@hotmail.com  
Donate link: https://elearningevolve.com/products/donate/  
Tags: virtual classroom, video conference, BigBlueButton, BBB, online meeting, web conferencing, online teaching, learning management system, LMS, online session, live training, video conferencing, video conference, meetings, virtual meetings
Requires at least: 5.1  
Tested up to: 6.9.1  
Requires PHP: 7.2  
Stable tag: 2.5.3  
License: GPLv2 or later  
License URI: http://www.gnu.org/licenses/gpl-2.0.html  

This plugin allows teachers to manage their live virtual classrooms, video conference and online meeting right from WordPress. As an educator, this stands out as one of the top choices for online meetings.

## Description ##

[Virtual Classroom for WordPress](https://wordpress.org/plugins/video-conferencing-with-bbb) integrates [BigBlueButton](https://bigbluebutton.org/) into WordPress through which teachers can manage their virtual classrooms/video conferences right from the WP dashboard.

BBB stands as an open-source video conferencing solution crafted with the motto **"Built For Teachers"**. Equipped with all the essential features typical of a web conferencing platform, it goes beyond by facilitating active collaboration to enhance virtual classroom engagement. As an educator, BBB stands out as one of the top choices for online meetings. Explore all its features [here](https://support.blindsidenetworks.com/hc/en-us/articles/360052738972-What-are-the-features-in-BigBlueButton-).

### Virtual Classroom for WordPress Features ###
Virtual Classroom for WordPress enables the user to create BBB rooms right from the WordPress dashboard. Once the room is created it can be added to any WordPress page through a simple shortcode. There is also a possibility to enter multiple rooms in the shortcode to let the user choose the room that they want to join.

The student can simply click Join from the page where the shortcode is added and enter the BBB room where the teacher can initiate a virtual classroom session.

After the session is over the plugin can also display the recording of the session on the same page so that the students can take the keynotes from the session later on.

### Free Plugin Limitations ###
* Add New option for BBB Rooms on backend is limited to only a maximum of 2 Rooms
* Join room on the same page is not available. Only join in a new full screen window is supported

### REQUIRED: Separate BigBlueButton Server ###
**BBB software requires a separate hosting server that should be connected to our plugin. Please refer to our [hosting guide](https://elearningevolve.com/blog/hosting-virtual-classroom-for-wordpress/) for setup.**

**This free plugin uses a BigBlueButton server provided by Blindside Networks for testing purposes only, is available "AS IS" without any warranty. It's publicly accessible, and sessions and recordings may be open to anyone. Recordings on this testing server are not accessible and will be removed after 7 days, so do not rely on them.**

### Pro Version Features ###
There is also a Pro version available with this plugin that offers the below features:
* Moderators frontend Room management area
* Embed BigBlueButton Room on WordPress i.e join room on the same WP page
* Set a Countdown/Schedule for Room
* Fully White-label Virtual Classroom
* Limit the max allowed participants for a room e.g (5, 10, .. etc) both on a per room and per page basis. This can allow you to conduct a 1:1 or group session
* Upload your brand logo that is visible in the BBB room
* Customize the room background-color as per your brand color
* Change welcome message that is displayed in the Public Chat section of the room
* Customize thank you message when the user leaves the meeting
* Pre-upload your presentation (ability to upload both globally and per room basis)

**[Get Pro Version](https://elearningevolve.com/products/wp-virtual-classroom/)**
### Video Guide ###
[![Video Guide](https://elearningevolve.com/wp-content/uploads/2022/04/bbb-room-youtube.jpeg)](https://youtu.be/xb5wR-VcrXs)
[youtube https://www.youtube.com/watch?v=xb5wR-VcrXs]

### How-Tos ###

* [How to set up hosting & get Endpoint URL/Secret for Virtual Classroom for WordPress](https://elearningevolve.com/blog/hosting-virtual-classroom-for-wordpress/)
* [How to join BigBlueButton Room from WordPress](https://elearningevolve.com/blog/how-to-join-bigbluebutton-room-from-wordpress/)
* [How to limit number of users for BigBlueButton Room on WordPress](https://elearningevolve.com/blog/how-to-limit-number-of-users-for-bigbluebutton-room-on-wordpress/)
* [How to allow instructors or users to manage BigBlueButton Rooms on WordPress](https://elearningevolve.com/blog/how-to-allow-instructors-to-manage-bbb-rooms-on-wp/)


For further queries feel free to [contact us](https://elearningevolve.com/contact/) or directly reach out on *info@elearningevolve.com*

## Installation ##

Here's an overview of the installation.

   1. Log in as an admin and click on the Plugins menu on the sidebar.
   1. Click Add new.
   1. In the search bar enter "Video Conferencing with BBB" and click search plugins.
   1. When you find the plugin called Video Conferencing with BBB by eLearning evolve click the install now link.
   1. Activate the Plugin.
   1. Click on BBB Rooms in the sidebar and click on Server Settings.
   1. Fill out the URL of where the BigBlueButton server is running (be sure to add /bigbluebutton/ to the end of the URL) and it's salt. Then click on Save.
   1. Click on BBB Rooms in the sidebar.
   1. Add a new room and publish it.
   1. Click on BBB Rooms in the sidebar again and copy the token of your new room.
   1. Click on widgets under the Appearance menu.
   1. Find the BBB Rooms Widget. Then click and drag it to either the right, content or footer windows on the right of the screen depending on where you wish the BBB Rooms widget to appear.
   1. Enter the token you copied earlier into the widget and save it.
   1. You are ready to begin creating meetings and holding conferences.

## Frequently Asked Questions ##
**Cannot see Add New option for BBB Rooms**
The free plugin allows you to Add New maximum 2 BBB Rooms. To create unlimited rooms activate the [Pro version](https://elearningevolve.com/products/wp-virtual-classroom/) on your site

**404 error when joining BBB room**
It is required that your BBB hosting server is up and running before you join a BBB room. This error is likely to show up when the
default BBB test instance is not started from the BBB cloud. Please review this [hosting guide](https://elearningevolve.com/blog/hosting-virtual-classroom-for-wordpress/) to understand how to start the cloud instance.

**401 unauthorized error when BBB room window opens within the page**
It is required that your BBB hosting server supports the BBB room in an iFrame for our Pro plugin else the room window within a page will display a 401 unauthorized error when starting a meeting. The solution to add the iFrame support on BBB hosting server is mentioned on Github [here](https://github.com/bigbluebutton/bigbluebutton/issues/9998#issuecomment-678272306). Our list of [recommended BBB hosts](https://elearningevolve.com/blog/bigbluebutton-hosting/) already support this feature.

**How do I create meetings?**
After activating the plugin, click on "BBB Rooms" and "Add New" and give the meeting a title and fill out the room details.

**How to display room join form?**

* By default, each room will be on its own page, with the permalink listed under BBB Rooms -> All Rooms. 
* A single BBB Room can also be inserted into any post/page using the **[bigbluebutton] shortcode** with a specified token in the shortcode in the format,
`[bigbluebutton token=z2xxx]`
* There is also an option to insert multiple Rooms to any post/page where the user can select a specific room to join. To achieve this insert multiple tokens in the shortcode in the format,
`[bigbluebutton token=z2xxx,z2yyy]`
* Users join meetings using a join room form. This form can be shown on a site as a sidebar element or as a page/post.
* For setting up in the sidebar, add the BBB Rooms widget, as you do with any other widget, dragging the box to the position you want it to be in.

**How to join the BBB room?**
Once you display the room join form on your preferred page or section on your site. Simply, share the website link of your page with your participants and they can join the BBB room directly from there.

**How can users view recordings?**

By default, the recordings display under each room created under BBB Rooms -> All Rooms.

* To place recordings on a separate post/page, use the shortcode `[bigbluebutton type=recording]`, with the room token of the desired recording e.g:
`[bigbluebutton type=recording token=z2xxx]`
* To place multiple recordings on a separate post/page, use the shortcode `[bigbluebutton type=recording]`, with the room tokens of the desired recording e.g:
`[bigbluebutton type=recording token=z2xxx,z2yyy]`

**How to let users select a specific BBB room to join from frontend**

Insert the token of your BBB Room that you would like the users to select from in the shortcode with this format, `[bigbluebutton token=z2xxx,z2yyy]`

**Which users are required to enter the Name and Access Code on room join form?**
* *For non-logged in users:* The Name & Access Code will be always required.
* *For logged-in users:* The login username will be taken as their Name. The Access Code field does not displays for logged-in users 
* *For logged-in users:* To apply the Access Code requirement for a user role, you can customize the particular user role by adding the capability, **join_with_access_code_bbb_room** and remove the capability **join_as_viewer_bbb_room**.

**How can I change the capability/permissions of a user role?**

You can install the [**"User Role Editor plugin"**](https://wordpress.org/plugins/user-role-editor/) and update the capabilities/permissions from **"Users" > "User Role Editor"**.
[See User Role Plugin Usage Screenshot](https://elearningevolve.com/wp-content/uploads/2022/04/bbb-room-user-roles-editor.jpeg)

**How to allow a user role to create BBB Rooms from the Dashbaord?**

See our detailed [step by step guide](https://elearningevolve.com/blog/how-to-allow-instructors-to-manage-bbb-rooms-on-wp/) to learn this.

**How to assign a WordPress user role as the moderator for the BBB room?**

* By default, the user who has created a BBB room and will always join their room as a moderator, this does not apply to others'rooms.
* The WordPress site administrators have the moderator access for all BBB Rooms.
* Additionally, you can customize your site user roles to add the capability,  **join_as_moderator_bbb_room** for your preferred role to grant them the moderator access for all BBB Rooms like the administrator.

**How to Restrict number of users or max participants for all rooms or per room?**
This feature is available in our [Pro plugin](https://elearningevolve.com/products/wp-virtual-classroom/). You can limit the max participants for all the rooms from *BBB Rooms -> Settings -> Room Config*
[See Global Participant Limit Screenshot](https://elearningevolve.com/wp-content/uploads/2022/04/bbb-room-limit-participant-global.jpeg)

You can also override the global settings or set a different limit for each page by setting the max participants param with each shortcode that is added to a page.
[See Shortcode Level Limit Screenshot](https://elearningevolve.com/wp-content/uploads/2022/04/bbb-room-limit-participant-shortcode.jpeg)

**Where do administrator of the room login to their page/ room to schedule and manage meetings**
They need to login to their WordPress dashboard https://mywpsite.com/wp-admin
from the dashbaord they can manage the room from BBB Rooms menu.

**How to schedule a BBB room meeting**
This feature is available in our [Pro plugin](https://elearningevolve.com/products/wp-virtual-classroom/) where the Room admin can set a date/time of room meeting to start for each of the rooms.
[See BBB Room Countdown Screenshot](https://elearningevolve.com/wp-content/uploads/2022/04/bbb-room-countdown-setting.jpeg)

**I want to edit my recordings. How do I do that?**

If a user has the capability to manage recordings, they will see a pencil icon next to the recording name and description. Click on the icon to start editing, and press enter to submit. A user can cancel editing by pressing the ESC key.

To allow a user role to manage recordings add the capability, **manage_bbb_room_recordings**.

## Screenshots ##

1. Features: Audio - built-in and dial-in numbers (in some regions), Video - low, medium, and high resolution, Screen sharing, Chat (public/private), Upload slides (any PDF, Microsoft PowerPoint, Word, or Excel), Whiteboard annotation, Multi-user whiteboard, Breakout rooms, Shared notes, Raise hand, Emojis, Polling, Share external video, Recordings, Browser and Mobile Friendly HTML5 interface, runs on desktop, laptop, and mobile devices using iOS 12.2+ and Android 6.0+.
2. BBB Meeting Room.
3. BBB Rooms are a Content Type that has its own view.
4. BBB Rooms can be embedded into Posts, Pages, and other Content Types using shortcodes.
5. Multiple rooms can be accessed from the same Page or Post.
6. Server settings define where the meetings are hosted.
7. BBB Rooms can be managed through the Administrator Dashboard.
8. BBB Rooms can also be organized using Categories.

## Changelog ##
### 2.5.3 ###
* Fixed: Translation strings now use actual default messages instead of placeholder keys so the correct text displays when translation files are missing or not loaded (Room Settings: server notice, success/error messages)
* Updated: Regenerated .pot/.po translation files; compatibility tested with WordPress 6.9.1

### 2.5.2 ###
* Fixed: Multiple recording buttons in the recording view

### 2.5.1 ###
* Fixed: Fatal error in previous v2.5.0 update

### 2.5.0 ###
* Added: Allow LearnDash Instructors and Group Leaders to embed room shortcode

### 2.4.3 ###
* Fixed: Access code not updates are not applied for the room
* Fixed: Shortcode does not display in the admin rooms list

### 2.4.2 ###
* Added: Character limit message for meeting access code on the meeting edit page

### 2.4.1 ###
* Added: Translation support for a few text snippets in the plugin that were not translation friendly

### 2.4.0 ###
* Updated: Improved UI and button styling
* Compatibility: Tested with WordPress v6.5.3 

### 2.3.9 ###
* Fixed: Addressed CSS conflict with Tooltips Pro plugin that prevented the shortcode from displaying on the All Rooms list page.

### 2.3.8 ###
* Fixed: plugin shortcodes not working with Woffice WordPress theme 

### 2.3.7 ###
* Updated: Performance updates and speed optimization

### 2.3.6 ###
* Updated: BBB hosting details on settings page
* Added: Support for adding custom button text with Pro plugin

### 2.3.5 ###
* Tested: Compatibility with WP v6.4.3

### 2.3.4 ###
* Fixed: BBB shortcode column displays on admin screens other than BBB room list

### 2.3.3 ###
* Updated: Sort recordings in descending order by date in BBB room recordings list display

### 2.3.2 ###
* Updated: Improve UI styling for recording table view on room page

### 2.3.1 ###
* Fixed: 400 error on recording view due to incorrect recording URL

### 2.3.0 ###
* Updated: Improve layout for Recording list on room join page for mobile view

### 2.2.2 ###
* Fixed: Added checks to prevent PHP warning & minor bug fixes

### 2.2.1 ###
* Updated: Improved reporting messages in the plugin
* Added: Quick subscribe option from plugin settings page
* Removed: Subscribe page from plugin menus

### 2.2.0 ###
* Added: BBBHost.Cloud [test instance](https://elearningevolve.com/blog/hosting-virtual-classroom-for-wordpress/#start-test) start button on settings page

### 2.1.1 ###
* Updated: Plugin hosting notice on settings page

### 2.1.0 ###
* Added: [Hosting guide](https://elearningevolve.com/blog/hosting-virtual-classroom-for-wordpress/) details on the plugin settings page.

### 2.0.1 ###
* Fixed: Ability to add Endpoint URL not having /bigbluebutton in the URL

### 2.0.0 ###
* Added: Support for adding multiple BBB rooms on a single page
* Added: Support for adding multiple BBB room join forms on a single page
* Added: Support for adding multiple BBB room recordings on a single page

### 1.6.2 ###
* Fixed: Start/Join Here button opening in a new tab change it to open in the same window

### 1.6.1 ###
* Added: Compatibility with v2.4.3 of the [BigBlueButton Pro plugin](https://elearningevolve.com/products/wp-virtual-classroom/)
* Fixed: Join button UI issue on some browsers

### 1.6.0 ###
* Added: Compatibility with v2.4.2 of the [BigBlueButton Pro plugin](https://elearningevolve.com/products/wp-virtual-classroom/)
* Updated: Use the testing Blindside Networks BigBlueButton server when using free plugin
* Fixed: Ability to open BBB room in browser when Joining Fullscreen from BuddyBoss mobile App

### 1.5.4 ###
* Fixed: Recording delete not working from BBB room page when pro plugin not enabled

### 1.5.3 ###
* Fixed: Wait for Moderator option not working on some BBB hosts
* Updated: Require username input when user is not logged in to prevent join error

### 1.5.2 ###
* Updated: Compatibility with BBB Pro v2.4.0

### 1.5.1 ###
* Fixed: Remove admin permissions incorrectly set for other user roles in v1.2.1 update

### 1.5.0 ###
* Updated: Allow all logged-in users to access the BBB room without the need to enter the Access Code

### 1.4.4 ###
* Added: Share recording option for admins and moderators on bbb room page
* Updated: Confirmation check before deleting recording

### 1.4.3 ###
* Fixed: Error when moderator and viewer access codes are same while saving room
* Updated: New shortcodes added in Settings -> Shortcode Guide section

### 1.4.2 ###
* Added: New capability add_bbb_rooms to allow Add New rooms access to admins and users with this new capability
* Added: Update capability permissions on each plugin update to prevent the need for activate/deactivate plugin
* Updated: Performance improvement with code optimization

### 1.4.1 ###
* Updated: Remove custom fields from BBB Rooms -> Add New
* Added: New capability can_limit_user_in_bbb_rooms the room limit option will show only to admins and users with this new capability
* Added: New tutorial [How to allow instructors or users to manage BigblueButton Rooms on WordPress](https://elearningevolve.com/blog/how-to-allow-instructors-to-manage-bbb-rooms-on-wp/) in plugin settings page

### 1.4.0 ###
* Added: Tutorials section on plugin settings page
* Added: Shortcode guide section on settings page for all available plugin shortcodes
* Updated: Restrict settings page access only to Admin level users
* Updated: BBB multiple room select shortcode layout to align with the join form
* Updated: Compatibility for Room level limit feature addition in Pro plugin
* Fixed: Access code error message does not display when codes updated while meeting is running

### 1.3.1 ###
* Fixed: Error Call to undefined function get_current_screen()

### 1.3.0 ###
* Added: Automatically create a default Home Room under BBB Rooms -> All Rooms admin page
* Added: Ability to start meeting from BBB Rooms -> All Rooms
* Added: Ability to filter rooms by category from BBB Rooms -> All Rooms\
* Added: Help text on BBB Rooms -> All Rooms page
* Updated: Admin view of All Rooms page

### 1.2.1 ###
* Added: updated FAQ section and added new answers
* Updated: Removed restriction for preview of unpublished rooms
* Fixed: BBB Room create/edit permissions granted to non-admin user roles
* Fixed: Permissions are not assigned on plugin activate
[Action needed] Please deactivate and activate the plugin to apply the above fixes

### 1.2.0 ###
* Added: Compatibility for per shortcode max participant room limit in Pro plugin
* Added: Compatibility for pre upload presentation (global and per room basis) in Pro plugin
* Added: Compatibility for the ability to customize background color for the room in Pro plugin
* Added: Shortcode usage guide on the plugin settings page

### 1.1.6 ###
* Fixed: You did not pass the checksum security check error on room join with BBB On Demand Server

### 1.1.5 ###
* Fixed: The page can't be found error when viewing a BBB room
[Action needed] Please deactivate and activate the plugin to apply this fix

### 1.1.4 ###
* Added: compatibility for the max room participant limit feature added in Pro plugin

### 1.1.3 ###
* Added: compatibility for the room start time & countdown feature added in Pro plugin
* Fixed: Super admin can not login WP multisite after activating the plugin

### 1.1.2 ###
* Added: Our [Pro version](https://elearningevolve.com/products/wp-virtual-classroom/) release notice on the plugin settings page

### 1.1.1 ###
* Updated: Removed the need to assign activate_plugins user permission for admin BBB Rooms menu.
* Added: Use capability "publish_bbb_rooms" for admin BBB Rooms menu access by any user role.

### 1.1.0 ###
* Updated: Replaced the older test server credentials of Blindside Networks by [Bigbluebutton.host](https://bigbluebutton.host/) test server in plugin settings.
* Fixed: Blindside Networks test server not working anymore, not able to join rooms.
* Updated: Minor style changes, room join form center aligned with the page.

### 1.0.4 ###
* Added: [Our Recommended BBB hosting providers](https://elearningevolve.com/blog/bigbluebutton-hosting) blog in plugin settings.
* Compatibility: Tested with WP version 5.9.1.

### 1.0.3 ###
* Fixed: EndPoint URL & Shared Secret/Salt settings not saved and shows error sometimes.
* Improvement: Make error messages & recording page button text more user-friendly.
* Improvement: Added new hooks in plugin.

### 1.0.2 ###
* Tested: compatibility with WordPress v5.8.3.
* Improvement: Added new hooks in plugin.
* Improvement: Security enhancement on recordings section.

### 1.0.1 ###
* Fixed: plugin warning messages on WP dashboard.
* Improvement: Readability of plugin conflict messages.

### 1.0.0 ###
This plugin is a fork of the BigBlueButton plugin initially released by Blindside Networks but no longer maintained.
* Improvement: Security enhancement on room join page.
* Improvement: Tested with WP version 5.8.2.
* Improvement: Ability to copy the shortcode from the BBB Rooms listing page.
* Improvement: Use HTTPS version for the test bigbluebutton endpoint
